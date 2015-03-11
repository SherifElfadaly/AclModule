<?php namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Acl\Http\Controllers\AclBaseController;
use App\Modules\Acl\Repositories\AclRepository;
use App\Modules\Acl\Http\Requests\PermissionFormRequest;

use Illuminate\Http\Request;

class PermissionController extends AclBaseController {


	/**
	 * Create new PermissionController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl);
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
	 * Display the item permissions.
	 *
	 * @return Response
	 */
	public function getShow($item, $itemId)
	{
		$itemPermissions = $this->acl->getItemPermissions($item, $itemId);
		$permissions     = $this->acl->getAllPermissions();
		$groups          = $this->acl->getAllGroups();

		return view('Acl::permissions.itempermissions', compact('permissions', 'groups', 'itemPermissions'));
	}

	/**
	 * Save the item permissions.
	 *
	 * @return Response
	 */
	public function postShow(Request $request, $item, $itemId)
	{
		$groupPermissions = array();
		foreach ($request->except('_token') as $key => $value) 
		{	
			$groupPermissions[] = [
			'group_id'      => explode('_', $key)[0], 
			'permission_id' => explode('_', $key)[1],
			'item_id'       => $itemId,
			'item_type'     => ucfirst($item)
			];
		}
		$this->acl->savePermissions($groupPermissions, $itemId);

		return 	redirect()->back()->with('message', 'Your permissions had been saved');
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
		$permission    = $this->acl->createPermission($data);

		return 	redirect()->back()->with('message', 'Your permission had been created');
	}

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
