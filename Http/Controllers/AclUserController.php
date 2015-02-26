<?php namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Acl\Http\Controllers\AclBaseController;
use App\Modules\Acl\Repositories\AclRepository;
use App\Modules\Acl\Http\Requests\UserFormRequest;

class AclUserController extends AclBaseController {

	/**
	 * Create new AclUserController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl);

		//If the user is admin.
		$this->middleware('App\Modules\Acl\Http\Middleware\AclAuthenticate');
	}

	/**
	 * Display a listing of the users.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$users = $this->acl->getAllUsers();
		return view('Acl::users.users', compact('users'));
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$permissions = $this->acl->getAllPermissions();
		$groups      = $this->acl->getAllGroups();

		return view('Acl::users.adduser', compact('permissions', 'groups'));
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function postCreate(UserFormRequest $request)
	{
		$data['name']     = $request->get('name');
		$data['email']    = $request->get('email');
		$data['password'] = bcrypt($request->get('password'));
		
		$user             = $this->acl->createUser($data);
		
		$this->acl->addPermissions($user, $request->get('user_permissions'));
		$this->acl->addGroups($user, $request->get('user_groups'));

		return 	redirect()->back()->with('message', 'Your user had been created');
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$user             = $this->acl->getUser($id);

		$permissions      = $this->acl->getPermissionsWithNoUser($user->id);
		$user_permissions = $this->acl->getPermissions($user);

		$groups           = $this->acl->getGroupsWithNoUser($user->id);
		$user_groups      = $this->acl->getGroups($user);

		return view('Acl::users.edituser', compact('user', 'permissions', 'user_permissions', 'groups', 'user_groups'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit($id, UserFormRequest $request)
	{	
		$user              = $this->acl->getUser($id);
		$data['name']      = $request->get('name');
		$data['email']     = $request->get('email');
		$data['password']  = $request->get('password');

		$this->acl->updatetUser($user->id, $data);

		$this->acl->addPermissions($user, $request->get('user_permissions'));
		$this->acl->addGroups($user, $request->get('user_groups'));

		return 	redirect()->back()->with('message', 'Your user had been Updated');
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->acl->deleteUser($id);
		return 	redirect()->back();
	}

}
