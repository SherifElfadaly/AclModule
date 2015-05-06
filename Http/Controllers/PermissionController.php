<?php namespace App\Modules\Acl\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Acl\Repositories\AclRepository;

use Illuminate\Http\Request;

class PermissionController extends BaseController {


	/**
	 * Create new PermissionController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl, 'Permissions');
		$this->middleware('AclAdminAuthenticate');
	}

	/**
	 * Display the item permissions.
	 *
	 * @return Response
	 */
	public function getShow($item, $itemId)
	{
		$itemPermissions = $this->repository->getItemPermissions($item, $itemId);
		$permissions     = $this->repository->getAllPermissions($item);
		$groups          = $this->repository->getAllGroups();
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
			'item_type'     => $item
			];
		}
		$this->repository->savePermissions($groupPermissions, $item, $itemId);

		return 	redirect()->back()->with('message', 'Your permissions had been saved');
	}
}
