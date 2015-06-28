<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class GroupRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Acl\Group';
	}
	
	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['users', 'permissions'];
	}

	/**
	 * Replace with the given list of group ids to
	 * the given object.
	 * 
	 * @param object $obj
	 * @param array  $data
	 * @return void
	 */
	public function addGroups($obj, $data)
	{
		$this->deleteGroups($obj);
		$obj->groups()->attach($data);
	}

	/**
	 * Delete all groups from the given object.
	 * 
	 * @param  object $obj
	 * @return void
	 */
	public function deleteGroups($obj)
	{
		$obj->groups()->detach();
	}

	/**
	 * Check if the group is active or not.
	 * 
	 * @param  integer $id
	 * @return boolean
	 */
	public function groupIsActive($id)
	{
		return	$this->find($id)->is_active;
	}

	/**
	 * Return the number of admin users.
	 * 
	 * @return integer
	 */
	public function adminCount()
	{	
		return $this->findBy('group_name', 'admin')[0]->users()->count();
	}

	/**
	 * Check if the given group hase the given permission.
	 * 
	 * @param  integer $group_id       [description]
	 * @param  string $permissionName [description]
	 * @return boolean
	 */
	public function groupHasPermission($group_id, $permissionName)
	{
		$permissions = $this->find($group_id)->permissions->lists('key');
		if (in_array($permissionName, $permissions)) 
		{
			return true;
		}
		return false;
	}
}
