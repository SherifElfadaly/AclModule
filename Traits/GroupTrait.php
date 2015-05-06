<?php namespace App\Modules\Acl\Traits;

use App\Modules\Acl\Group;
use DB;

trait GroupTrait{

	public function getAllGroups()
	{
		return Group::with(['users', 'permissions'])->get();
	}

	public function getGroup($id)
	{
		return Group::find($id);
	}

	public function createGroup($data)
	{
		return Group::create($data);
	}

	public function updatetGroup($id, $data)
	{
		$group = $this->getGroup($id);
		return $group->update($data);
	}

	public function deleteGroup($id)
	{	
		$group = $this->getGroup($id);
		return $group->delete();
	}

	public function addGroups($obj, $data)
	{
		$this->deleteGroups($obj);
		return $obj->groups()->attach($data);
	}

	public function deleteGroups($obj)
	{
		return $obj->groups()->detach();
	}

	public function groupIsActive($id)
	{
		return	$this->getGroup($id)->is_active;
	}

	public function checkForAdmins()
	{
		return Group::where('group_name', '=', 'admin')->first()->users()->count();
	}
}