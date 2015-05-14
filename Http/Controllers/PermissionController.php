<?php namespace App\Modules\Acl\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class PermissionController extends BaseController {

	/**
	 * Specify that this controller should be 
	 * accessed by the admin users only.
	 * @var adminOnly
	 */
	protected $adminOnly = true;

	/**
	 * Create new PermissionController instance.
	 */
	public function __construct()
	{
		parent::__construct('Permissions');
	}

	/**
	 * Display the item permissions.
	 * 
	 * @param  string $item
	 * @param  integer $itemId
	 * @return Response
	 */
	public function getShow($item, $itemId)
	{
		$itemPermissions = \CMS::permissions()->getItemPermissions($item, $itemId);
		$permissions     = \CMS::permissions()->getAllItemsPermissions($item);
		$groups          = \CMS::groups()->all();
		return view('Acl::permissions.itempermissions', compact('permissions', 'groups', 'itemPermissions'));
	}

	/**
	 * Save the item permissions.
	 * 
	 * @param  Request $request
	 * @param  string  $item
	 * @param  itneger  $itemId
	 * @return Response
	 */
	public function postShow(Request $request, $item, $itemId)
	{
		\CMS::permissions()->savePermissions($request->except('_token'), $item, $itemId);
		return 	redirect()->back()->with('message', 'Your permissions had been saved');
	}
}
