<?php namespace App\Modules\Acl\Traits;

use App\Modules\Acl\Permission;
use App\Modules\Acl\Group;
use DB;

trait PermissionTrait{

	public function getAllPermissions($item)
	{
		return Permission::whereIn('id', DB::table('groups_permissions')->
			                             where('item_type', '=', $item)->
			                             where('group_id', '=', Group::where('group_name', '=', 'admin')->first()->id)->
			                             lists('permission_id'))->get();
	}

	public function getUserPermissions($item, $itemId, $userId)
	{
		return Permission::whereIn('id', DB::table('groups_permissions')->
			                             whereRaw('item_id=? and item_type=?', [$itemId, $item])->
			                             whereIn('group_id', $this->getUser($userId)->groups->lists('id'))->
			                             lists('permission_id'))->get();
	}
	
	public function getItemPermissions($item, $itemId)
	{
		return DB::table('groups_permissions')->
		       select('group_id', 'permission_id')->
		       whereRaw('item_id=? and item_type=?', [$itemId, $item])->get();
	}

	public function deleteItemPermissions($item, $itemId = false)
	{	
		if($itemId)
		{
			return DB::table('groups_permissions')->
			       where('item_id', $itemId)->
			       where('item_type', $item)->delete();
		}
		return DB::table('groups_permissions')->
			       where('item_type', $item)->delete();
	}

	public function savePermissions($data, $item, $itemId)
	{
		if($data)
		{
			$this->deleteItemPermissions($item, $itemId);
			DB::table('groups_permissions')->insert($data);
		}
	}

	public function insertDefaultItemPermissions($item, $itemId, $groupsPermissions = array())
	{
		if( ! empty($groupsPermissions))
		{
			foreach ($groupsPermissions as $key => $value) 
			{	
				$permissions = array();
				foreach ($value as $permission) 
				{
					$permissions[] = Permission::firstOrCreate(['key' => $permission])->id;
				}
				
				Group::firstOrCreate(['group_name' => $key])->permissions()->attach(
						$permissions, ['item_id' => $itemId, 'item_type' => $item]
						);
			}
		}
		else
		{
			Group::with('permissions')->
			whereIn('group_name', ['admin', 'manager', 'user'])->
			get()->each(function($group) use ($item, $itemId){
				if($group->group_name == 'admin')
				{
					$group->permissions()->attach(
						Permission::whereIn('key', ['show', 'add', 'edit', 'delete'])->lists('id'), 
						['item_id' => $itemId, 'item_type' => $item]
						);
				}
				elseif($group->group_name == 'manager')
				{
					$group->permissions()->attach(
						Permission::whereIn('key', ['show', 'edit'])->lists('id'), 
						['item_id' => $itemId, 'item_type' => $item]
						);
				}
				elseif($group->group_name == 'user')
				{
					$group->permissions()->attach(
						Permission::whereIn('key', ['show'])->lists('id'), 
						['item_id' => $itemId, 'item_type' => $item]
						);
				}
			});
		}
	}

	/**
	 * Check for the given permission.
	 * @param permission
	 */
	public function can($permission, $item, $itemId = false)
	{
		if( ! $itemId)
		{
			$modulePart = \InstallationRepository::getModulePart($item);
			if ($modulePart === null) 
			{
				return false;
			}

			$itemId = $modulePart->id;
		}

		$userPermissions = $this->getUserPermissions($item, $itemId, \Auth::user()->id)->lists('key');
		if ( ! in_array($permission, $userPermissions)) 
		{
			return false;
		}
		return true;
	}
}