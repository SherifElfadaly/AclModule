<?php namespace App\Modules\Acl\Traits;

use App\Modules\Acl\Permission;
use App\Modules\Acl\Group;
use DB;

trait PermissionTrait{

	public function getAllPermissions()
	{
		return Permission::all();
	}

	public function getPermission($id)
	{
		return Permission::find($id);
	}

	public function getItemPermissions($item, $itemId)
	{
		return $itemPermissions = DB::table('groups_permissions')->select('group_id', 'permission_id')->
		whereRaw('item_id=? and item_type=?',[$itemId, $item])->get();
	}

	public function insertDefaultItemPermissions($item, $itemId)
	{
		$groups = Group::whereIn('group_name', ['admin', 'manager', 'user'])->get();

		foreach ($groups as $group) 
		{
			if($group->group_name == 'admin')
			{
				$group->permissions()->attach(
					Permission::whereIn('key', ['show', 'edit', 'delete'])->lists('id'), 
					['item_id' => $itemId, 'item_type' => $item]
					);
			}
			elseif($group->group_name == 'manager')
			{
				$group->permissions()->attach(
					Permission::whereIn('key', ['show', 'edit', 'delete'])->lists('id'), 
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
		}
	}

	public function createPermission($data)
	{
		return Permission::create($data);
	}

	public function updatetPermission($id, $data)
	{
		$permission = $this->getPermission($id);
		return $permission->update($data);
	}

	public function deletePermission($id)
	{	
		$permission = $this->getPermission($id);
		return $permission->delete();
	}

	public function deleteItemPermissions($item, $itemId)
	{	
		return DB::table('groups_permissions')->
					 where('item_id', $itemId)->
					 where('item_type', ucfirst($item))->delete();
	}

	public function savePermissions($data, $itemId)
	{
		DB::table('groups_permissions')->where('item_id', $itemId)->delete();
		if($data) DB::table('groups_permissions')->insert($data);
	}

	public function deletePermissions($obj)
	{
		return $obj->permissions()->detach();
	}
}