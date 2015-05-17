<?php namespace App\Modules\Acl\Repositories;

use App\AbstractRepositories\AbstractRepository;
use App\Modules\Acl\Group;
use DB;

class PermissionRepository extends AbstractRepository
{
	/**
	 * Return the module full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Acl\Permission';
	}
	
	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['groups', 'contents'];
	}

	/**
	 * Return the item type permissions based on
	 * the permission assigned to the group admin for that 
	 * item type.
	 * 
	 * @param  string $item
	 * @return collection
	 */
	public function getAllItemsPermissions($item)
	{
		return $this->model->whereIn('id', DB::table('groups_permissions')->
		                                 where('item_type', '=', $item)->
		                                 where('group_id', '=', \CMS::groups()->first('group_name', 'admin')->id)->
		                                 lists('permission_id'))->get();
	}

	/**
	 * Return the item permissions assigned to the
	 * given user groups.
	 * 
	 * @param  string $item
	 * @param  integer $itemId
	 * @param  integer $userId
	 * @return collection
	 */
	public function getUserPermissions($item, $itemId, $userId)
	{
		return $this->model->whereIn('id', DB::table('groups_permissions')->
			                             whereRaw('item_id=? and item_type=?', [$itemId, $item])->
			                             whereIn('group_id', \CMS::users()->find($userId)->groups->lists('id'))->
			                             lists('permission_id'))->get();
	}
	
	/**
	 * Return the item permissions.
	 * 
	 * @param  string $item
	 * @param  integer $itemId
	 * @return collection
	 */
	public function getItemPermissions($item, $itemId)
	{
		return DB::table('groups_permissions')->
		           select('group_id', 'permission_id')->
		           whereRaw('item_id=? and item_type=?', [$itemId, $item])->get();
	}

	/**
	 * Delete the specific item permissions if the item id is
	 * supplied and delete permissions for that type.
	 * 
	 * @param  string $item
	 * @param  integer $itemId
	 * @return integer affected rows
	 */
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

	/**
	 * Replace the item permissions with the given permissions.
	 * 
	 * @param  array $data
	 * @param  string $item
	 * @param  integer $itemId
	 * @return void
	 */
	public function savePermissions($data, $item, $itemId)
	{
		$groupPermissions = array();
		foreach ($data as $key => $value) 
		{	
			$groupPermissions[] = [
			'group_id'      => explode('_', $key)[0], 
			'permission_id' => explode('_', $key)[1],
			'item_id'       => $itemId,
			'item_type'     => $item
			];
		}
		$this->deleteItemPermissions($item, $itemId);
		DB::table('groups_permissions')->insert($groupPermissions);
	}

	/**
	 * Insert a default groups permissions if supplied or
	 * generate default groups permissions.
	 * 
	 * @param  string $item
	 * @param  integer $itemId
	 * @param  array  $groupsPermissions the key contains the group name and 
	 *                                   the value contain a list of permissions
	 * @return void
	 */
	public function insertDefaultItemPermissions($item, $itemId, $groupsPermissions = array())
	{
		if( ! empty($groupsPermissions))
		{
			foreach ($groupsPermissions as $key => $value) 
			{	
				$permissions = array();
				foreach ($value as $permission) 
				{
					$permissions[] = $this->model->firstOrCreate(['key' => $permission])->id;
				}
				
				Group::firstOrCreate(['group_name' => $key])->permissions()->attach(
						$permissions, ['item_id' => $itemId, 'item_type' => $item]
						);
			}
		}
		else
		{
			Group::with('permissions')->whereIn('group_name', ['admin', 'manager', 'user'])->get()->each(
				function($group) use ($item, $itemId){
			       	if($group->group_name == 'admin')
			       	{
			       		$group->permissions()->attach(
			       			$this->model->whereIn('key', ['show', 'add', 'edit', 'delete'])->lists('id'), 
			       			['item_id' => $itemId, 'item_type' => $item]
			       			);
			       	}
			       	elseif($group->group_name == 'manager')
			       	{
			       		$group->permissions()->attach(
			       			$this->model->whereIn('key', ['show', 'edit'])->lists('id'), 
			       			['item_id' => $itemId, 'item_type' => $item]
			       			);
			       	}
			       	elseif($group->group_name == 'user')
			       	{
			       		$group->permissions()->attach(
			       			$this->model->whereIn('key', ['show'])->lists('id'), 
			       			['item_id' => $itemId, 'item_type' => $item]
			       			);
			       	}
			});
		}
	}

	/**
	 * Check the given permission on the given item ,
	 * if the item id isn't supplied then check if the
	 * item is a module part and work on it's id.
	 * 
	 * @param  string  $permission
	 * @param  string $item
	 * @param  integer $itemId
	 * @return boolean
	 */
	public function can($permission, $item, $itemId = false)
	{
		if( ! $itemId)
		{
			$modulePart = \CMS::coreModuleParts()->getModulePart($item);
			if ( ! $modulePart) 
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
