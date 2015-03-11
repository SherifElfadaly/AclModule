<?php namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Acl\Http\Controllers\AclBaseController;
use App\Modules\Acl\Repositories\AclRepository;
use App\Modules\Acl\Http\Requests\GroupFormRequest;


class GroupController extends AclBaseController {

	/**
	 * Create new GroupController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl);
	}

	/**
	 * Display a listing of the groups.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$groups = $this->acl->getAllGroups();
		return view('Acl::groups.groups', compact('groups'));
	}

	/**
	 * Show the form for creating a new group.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$permissions = $this->acl->getAllPermissions();
		return view('Acl::groups.addgroup', compact('permissions'));
	}

	/**
	 * Store a newly created group in storage.
	 *
	 * @return Response
	 */
	public function postCreate(GroupFormRequest $request)
	{
		$data['group_name'] = $request->get('group_name');
		$data['is_active']  = $request->get('is_active') ? 1 : 0;

		$group = $this->acl->createGroup($data);
		return 	redirect()->back()->with('message', 'Your group had been created');
	}

	/**
	 * Show the form for editing the specified group.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$group = $this->acl->getGroup($id);
		return view('Acl::groups.editgroup', compact('group', 'permissions'));
	}

	/**
	 * Update the specified group in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit($id, GroupFormRequest $request)
	{
		$group              = $this->acl->getGroup($id);
		$data['group_name'] = $request->get('group_name');
		$data['is_active']  = $request->get('is_active') ? 1 : 0;

		$this->acl->updatetGroup($group->id, $data);
		return 	redirect()->back()->with('message', 'Your group had been Updated');
	}

	/**
	 * Remove the specified group from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->acl->deleteGroup($id);
		return 	redirect()->back();
	}

}
