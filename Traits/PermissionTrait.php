<?php namespace App\Modules\Acl\Traits;

use App\Modules\Acl\Permission;
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

	public function getPermissionsWithNoUser($id)
	{
		$ids = DB::table('users_permissions')->where('user_id', '=', $id)->lists('permission_id');
		return Permission::whereNotIn('id', $ids)->get();
	}

	public function getPermissionsWithNoGroup($id)
	{
		$ids = DB::table('groups_permissions')->where('group_id', '=', $id)->lists('permission_id');
		return Permission::whereNotIn('id', $ids)->get();
	}

	public function getPermissions($obj)
	{
		return $obj->permissions;
	}

	public function addPermissions($obj, $data)
	{
		$this->deletePermissions($obj);
		return $obj->permissions()->attach($data);
	}

	public function deletePermissions($obj)
	{
		return $obj->permissions()->detach();
	}

	public function permissionIsActive($id)
	{
		return $this->getPermission($id)->value;
	}
}