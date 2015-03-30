<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Acl\Traits\UserTrait;
use App\Modules\Acl\Traits\GroupTrait;
use App\Modules\Acl\Traits\PermissionTrait;

class AclRepository
{
	use UserTrait;
	use GroupTrait;
	use PermissionTrait;

	public function userHasGroup($user_id, $groupName)
	{
		$groups   = $this->getUser($user_id)->groups;
		$response = false;
		
		$groups->each(function($group) use ($groupName, &$response){
			$response = $group->group_name === $groupName;
		});
		return $response;
	}

	public function groupHasPermission($group_id, $permissionName)
	{
		$permissions = $this->getGroup($group_id)->permissions;
		$response    = false;

		$permissions->each(function($permission) use ($permissionName, &$response){
			$response = $permission->key === $permissionName;
		});
		return $response;
	}
}
