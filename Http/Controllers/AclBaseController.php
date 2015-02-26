<?php namespace App\Modules\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Acl\Repositories\AclRepository;

class AclBaseController extends Controller {
	
	/**
	 * The AclRepository implementation.
	 *
	 * @var AclRepository
	 */
	protected $acl;

	/**
	 * Create new AclBaseController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		$this->acl = $acl;
		$isAdmin   = false;

		//If the user is logged in.
		if(\Auth::check())
		{
			//If the user is admin.
			$isAdmin = $this->acl->userHasGroup(\Auth::user()->id, 'admin');
		}

		view()->share('idAdmin', $isAdmin);
	}

	/**
	 * Render home page
	 * @return Response
	 */
	public function index()
	{
		return view('Acl::home');
	}
}
