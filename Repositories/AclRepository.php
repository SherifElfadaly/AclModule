<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Acl\Traits\UserTrait;
use App\Modules\Acl\Traits\ProfileTrait;
use App\Modules\Acl\Traits\GroupTrait;
use App\Modules\Acl\Traits\PermissionTrait;
use App\Modules\Acl\Group;
use App\Modules\Acl\AclUser;

class AclRepository
{
	use UserTrait;
	use ProfileTrait;
	use GroupTrait;
	use PermissionTrait;

	public function userHasGroup($user_id, $groupName)
	{
		$groups   = AclUser::find($user_id)->groups;
		$response = false;
		
		$groups->each(function($group) use ($groupName, &$response){
			$response = $group->group_name === $groupName;
		});
		return $response;
	}

	public function userHasPermission($user_id, $permissionName)
	{
		$permissions = AclUser::find($user_id)->permissions;
		$response    = false;

		$permissions->each(function($permission) use ($permissionName, &$response){
			$response = $permission->key === $permissionName;
		});
		return $response;
	}

	public function groupHasPermission($group_id, $permissionName)
	{
		$permissions = Group::find($group_id)->permissions;
		$response    = false;

		$permissions->each(function($permission) use ($permissionName, &$response){
			$response = $permission->key === $permissionName;
		});
		return $response;
	}

	public function getUserProfileData($user_id, $key)
	{
		return $this->getUser($user_id)->profiles()->where('key' , $key)->get(['value'])->first()->value;
	}
}
