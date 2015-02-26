<?php namespace App\Modules\Acl\Traits;

use App\Modules\Acl\Profile;

trait ProfileTrait{
	
	public function getProfile($id)
	{
		return Profile::find($id);
	}

	public function prepareProfileData($data)
	{
		$profiles = array();
		for ($i = 0 ; $i < count($data['key']) ; $i++) 
		{ 
			$profiles[] =  new Profile(['key' => $data['key'][$i], 'value' => $data['value'][$i]]);
		}
		return $profiles;
	}

	public function createProfile($data, $userId)
	{	
		$this->addProfile($this->getUser($userId), $data);
	}

	public function deleteProfile($id)
	{	
		$profile = $this->getProfile($id);
		return $profile->delete();
	}

	public function deleteProfiles($obj)
	{
		return $obj->profiles()->delete();
	}

	public function addProfile($obj, $profiles)
	{
		return $obj->profiles()->saveMany($profiles);
	}
}