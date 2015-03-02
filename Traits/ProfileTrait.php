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
		$this->getUser($userId)->profiles()->saveMany($data);
	}

	public function deleteProfile($id)
	{	
		$profile = $this->getProfile($id);
		$profile->delete();
	}

	public function deleteProfiles($obj)
	{
		$obj->profiles()->delete();
	}
}