<?php namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;
use App\Modules\Acl\Http\Requests\AddUserFormRequest;
use App\Modules\Acl\Http\Requests\EditUserFormRequest;

class AclUserController extends BaseController {

	/**
	 * Create new AclUserController instance.
	 */
	public function __construct()
	{
		parent::__construct('Users');
	}

	/**
	 * Display a listing of the users.
	 * 
	 * @return Response
	 */
	public function getIndex()
	{
 		$users = \CMS::users()->all();
		return view('Acl::users.users', compact('users', 'userPermissions'));
	}

	/**
	 * Show the form for creating a new user.
	 * 
	 * @return Response
	 */
	public function getCreate()
	{
		$groups = \CMS::groups()->all();
		return view('Acl::users.adduser', compact('groups'));
	}

	/**
	 * Store a newly created user in storage.
	 * 
	 * @param  AddUserFormRequest  $request
	 * @return Response
	 */
	public function postCreate(AddUserFormRequest $request)
	{
		$user = \CMS::users()->create($request->all());
		\CMS::groups()->addGroups($user, $request->get('user_groups'));

		return 	redirect()->back()->with('message', 'User had been created');
	}

	/**
	 * Show the form for editing the specified user.
	 * 
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		if( ! \CMS::users()->userHasGroup($id, 'admin') && \Auth::user()->id !== $id)
		{
			$user   = \CMS::users()->find($id);
			$groups = \CMS::groups()->all();

			return view('Acl::users.edituser', compact('user', 'groups'));
		}
		return 	redirect()->back();
	}

	/**
	 * Update the specified user in storage.
	 * 
	 * @param  int  $id
	 * @param  EditUserFormRequest  $request
	 * @return Response
	 */
	public function postEdit($id, EditUserFormRequest $request)
	{	
		if( ! \CMS::users()->userHasGroup($id, 'admin') && \Auth::user()->id !== $id)
		{
			\CMS::users()->update($user->id, $request->all());
			\CMS::groups()->addGroups($user, $request->get('user_groups'));

			return 	redirect()->back()->with('message', 'User had been Updated');
		}
		return 	redirect()->back();
	}

	/**
	 * Remove the specified user from storage.
	 * 
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		if( ! \CMS::users()->userHasGroup($id, 'admin') && \Auth::user()->id !== $id)
		{
			\CMS::users()->delete($id);
		}
		return 	redirect()->back();
	}
}
