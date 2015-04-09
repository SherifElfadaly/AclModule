<?php namespace App\Modules\Acl\Traits;

use App\Modules\Acl\AclUser;
use \LanguageRepository;

trait UserTrait{

	public function getAllUsers()
	{
		return AclUser::with(['groups', 'contents', 'languageContents'])->get();
	}

	public function getUser($id)
	{
		return AclUser::with(['groups', 'contents', 'languageContents'])->find($id);
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
		$user = $this->getUser($id);$user->delete();
		return $user->delete();
	}

	public function findUserByEmail($email)
	{
		return AclUser::whereEmail($email)->first();
	}

	public function search($query)
	{	
		return AclUser::whereIn('id', LanguageRepository::search($query))->
		orWhere('name', 'like', '%' . $query . '%')->lists('id');
	}
}