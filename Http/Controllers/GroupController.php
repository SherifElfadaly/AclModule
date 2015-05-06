<?php namespace App\Modules\Acl\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Acl\Repositories\AclRepository;
use App\Modules\Acl\Http\Requests\GroupFormRequest;

class GroupController extends BaseController {

	/**
	 * Create new GroupController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl, 'Groups');
	}

	/**
	 * Display a listing of the groups.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$this->hasPermission('show');
		$groups = $this->repository->getAllGroups();

		return view('Acl::groups.groups', compact('groups'));
	}

	/**
	 * Show the form for creating a new group.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$this->hasPermission('add');
		$permissions = $this->repository->getAllPermissions();

		return view('Acl::groups.addgroup', compact('permissions'));
	}

	/**
	 * Store a newly created group in storage.
	 *
	 * @return Response
	 */
	public function postCreate(GroupFormRequest $request)
	{
		$this->hasPermission('add');
		$data['group_name'] = $request->get('group_name');
		$data['is_active']  = $request->get('is_active') ? 1 : 0;

		$group = $this->repository->createGroup($data);
		return 	redirect()->back()->with('message', 'Group had been created');
	}

	/**
	 * Show the form for editing the specified group.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$this->hasPermission('edit');
		$group = $this->repository->getGroup($id);

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
		$this->hasPermission('edit');
		$group              = $this->repository->getGroup($id);
		$data['group_name'] = $request->get('group_name');
		$data['is_active']  = $request->get('is_active') ? 1 : 0;

		$this->repository->updatetGroup($group->id, $data);

		return 	redirect()->back()->with('message', 'Group had been Updated');
	}

	/**
	 * Remove the specified group from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->hasPermission('delete');		
		$this->repository->deleteGroup($id);

		return 	redirect()->back();
	}

}
