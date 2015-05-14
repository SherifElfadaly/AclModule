<?php namespace App\Modules\Acl\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

class AuthenticateController extends AuthController {

	/**
	 * Specify the redirect path to
	 * the login page.
	 * 
	 * @var loginPath
	 */
	protected $loginPath = 'admin/Acl/login';
	
	/**
	 * Show the form for registering.
	 * 
	 * @return Response
	 */
	public function getRegister()
	{
		return view('Acl::auth.register');
	}

	/**
	 * Show the form for looging in.
	 * 
	 * @return Response
	 */
	public function getLogin()
	{
		return view('Acl::auth.login');	
	}

	/**
	 * Register the user.
	 * 
	 * @param  Request $request
	 * @return Response
	 */
	public function postRegister(Request $request)
	{
		$this->redirectPath = $request->input('redirect');
		return parent::postRegister($request);
	}

	/**
	 * login the user.
	 * 
	 * @param  Request $request
	 * @return Response
	 */
	public function postLogin(Request $request)
	{
		$this->redirectPath = $request->input('redirect');
		return 	parent::postLogin($request);
	}
}
