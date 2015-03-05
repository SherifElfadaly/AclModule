<?php namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Acl\Http\Controllers\AclBaseController;
use App\Modules\Acl\Repositories\AclRepository;
use App\Modules\Acl\Http\Requests\PermissionFormRequest;


class PermissionController extends AclBaseController {


	/**
	 * Create new PermissionController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl);

		//If the user is admin.
		$this->middleware('App\Modules\Acl\Http\Middleware\AclAuthenticate');
	}

	/**
	 * Display a listing of the permissions.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$permissions = $this->acl->getAllPermissions();
		return view('Acl::permissions.permissions', compact('permissions'));
	}

	/**
	 * Show the form for creating a new permission.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return view('Acl::permissions.addpermission');
	}

	/**
	 * Store a newly created permission in storage.
	 *
	 * @return Response
	 */
	public function postCreate(PermissionFormRequest $request)
	{
		$data['key']   = $request->get('key');
		$data['value'] = $request->get('value') ? 1 : 0;
		
		$permission    = $this->acl->createPermission($data);

		return 	redirect()->back()->with('message', 'Your permission had been created');
	}

	/**
	 * Display the specified permission.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	/*public function getshow($id)
	{
		//
	}*/

	/**
	 * Show the form for editing the specified permission.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$permission = $this->acl->getPermission($id);
		return view('Acl::permissions.editpermission', compact('permission'));
	}

	/**
	 * Update the specified permission in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit($id, PermissionFormRequest $request)
	{
		$permission    = $this->acl->getPermission($id);
		$data['key']   = $request->get('key');
		$data['value'] = $request->get('value') ? 1 : 0;

		$this->acl->updatetPermission($permission->id, $data);

		return 	redirect()->back()->with('message', 'Your permission had been Updated');
	}

	/**
	 * Remove the specified permission from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->acl->deletePermission($id);
		return 	redirect()->back();
	}

}
