<?php namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;
use App\Modules\Acl\Http\Requests\GroupFormRequest;

class GroupController extends BaseController {

	/**
	 * Create new GroupController instance.
	 */
	public function __construct()
	{
		parent::__construct('Groups');
	}

	/**
	 * Display a listing of the groups.
	 * 
	 * @return Response
	 */
	public function getIndex()
	{
		$groups = \CMS::groups()->all();
		return view('Acl::groups.groups', compact('groups'));
	}

	/**
	 * Show the form for creating a new group.
	 * 
	 * @return Response
	 */
	public function getCreate()
	{
		return view('Acl::groups.addgroup');
	}

	/**
	 * Store a newly created group in storage.
	 * 
	 * @param  GroupFormRequest  $request
	 * @return Response
	 */
	public function postCreate(GroupFormRequest $request)
	{
		$data['group_name'] = $request->get('group_name');
		$data['is_active']  = $request->get('is_active') ? 1 : 0;
		\CMS::groups()->create($data);

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
		$group = \CMS::groups()->find($id);
		return view('Acl::groups.editgroup', compact('group'));
	}

	/**
	 * Update the specified group in storage.
	 * 
	 * @param  int  $id
	 * @param  GroupFormRequest  $request
	 * @return Response
	 */
	public function postEdit($id, GroupFormRequest $request)
	{
		$data['group_name'] = $request->get('group_name');
		$data['is_active']  = $request->get('is_active') ? 1 : 0;
		\CMS::groups()->update($id, $data);

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
		\CMS::groups()->delete($id);
		return 	redirect()->back();
	}

}
