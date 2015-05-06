<?php namespace App\Modules\Acl\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Acl\Repositories\AclRepository;
use App\Modules\Acl\Http\Requests\UserFormRequest;

class AclUserController extends BaseController {

	/**
	 * Create new AclUserController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl, 'Users');
	}

	/**
	 * Display a listing of the users.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$this->hasPermission('show');
		$users = $this->repository->getAllUsers();

		return view('Acl::users.users', compact('users', 'userPermissions'));
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$this->hasPermission('add');
		$groups = $this->repository->getAllGroups();

		return view('Acl::users.adduser', compact('groups'));
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @param  UserFormRequest  $request
	 * @return Response
	 */
	public function postCreate(UserFormRequest $request)
	{
		$this->hasPermission('add');
		$data['name']     = $request->get('name');
		$data['email']    = $request->get('email');
		$data['password'] = bcrypt($request->get('password'));
		
		$user             = $this->repository->createUser($data);
		$this->repository->addGroups($user, $request->get('user_groups'));

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
		if( ! \AclRepository::userHasGroup($id, 'admin') && \Auth::user()->id !== $id)
		{
			$this->hasPermission('edit');
			$user   = $this->repository->getUser($id);
			$groups = $this->repository->getAllGroups();

			return view('Acl::users.edituser', compact('user', 'groups'));
		}
		return 	redirect()->back();
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit($id, UserFormRequest $request)
	{	
		if( ! \AclRepository::userHasGroup($id, 'admin') && \Auth::user()->id !== $id)
		{
			$this->hasPermission('edit');
			$user              = $this->repository->getUser($id);
			$data['name']      = $request->get('name');
			$data['email']     = $request->get('email');
			$data['password']  = $request->get('password');

			$this->repository->updateUser($user->id, $data);
			$this->repository->addGroups($user, $request->get('user_groups'));

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
		if( ! \AclRepository::userHasGroup($id, 'admin') && \Auth::user()->id !== $id)
		{
			$this->hasPermission('delete');
			$this->repository->deleteUser($id);
		}
		return 	redirect()->back();
	}
}
