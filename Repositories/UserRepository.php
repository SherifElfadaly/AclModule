<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Acl\AclUser';
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
	 * Check if the given user hase the given group.
	 * 
	 * @param  integer $user_id
	 * @param  string $groupName
	 * @return boolean
	 */
	public function userHasGroup($user_id, $groupName)
	{
		$groups = $this->find($user_id)->groups->lists('group_name');
		if (in_array($groupName, $groups)) 
		{
			return true;
		}
		return false;
	}

	/**
	 * Get a listing of user ids wich their data match
	 * the given query.
	 * 
	 * @param  string $query
	 * @return array
	 */
	public function search($query)
	{
		return $this->model->whereIn('id', \CMS::languageContents()->search($query, 'user'))->
		                     orWhere('name', 'like', '%' . $query . '%')->lists('id');
	}
}
