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
		$groups   = $this->getUser($user_id)->groups->lists('group_name');
		if (in_array($groupName, $groups)) 
		{
			return true;
		}
		return false;
	}

	public function groupHasPermission($group_id, $permissionName)
	{
		$permissions = $this->getGroup($group_id)->permissions->lists('key');
		if (in_array($permissionName, $permissions)) 
		{
			return true;
		}
		return false;
	}
}
