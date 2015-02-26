<?php namespace App\Modules\Acl\Traits;

use App\Modules\Acl\AclUser;

trait UserTrait{

	public function getAllUsers()
	{
		return AclUser::all();
	}

	public function getUser($id)
	{
		return AclUser::find($id);
	}

	public function createUser($data)
	{
		return AclUser::create($data);
	}

	public function updatetUser($id, $data)
	{
		$user = $this->getUser($id);
		return $user->update($data);
	}

	public function deleteUser($id)
	{	
		$user = $this->getUser($id);

		$this->deleteGroups($user);
		$this->deletePermissions($user);
		$this->deleteProfiles($user);

		return $user->delete();
	}

	public function deleteUsers($obj)
	{
		return $obj->users()->detach();
	}

	public function findUserByEmail($email)
	{
		return AclUser::whereEmail($email)->first();
	}
}