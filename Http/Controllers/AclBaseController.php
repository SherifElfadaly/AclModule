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
		
		//If the user is admin.
		$this->middleware('AclAuthenticate');
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
