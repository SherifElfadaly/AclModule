<?php namespace App\Modules\Acl\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

class AuthenticateController extends AuthController {

	protected $loginPath = 'Acl/login';
	
	public function getRegister()
	{
		return view('Acl::auth.register');
	}

	public function getLogin()
	{
		return view('Acl::auth.login');	
	}

	public function postRegister(Request $request)
	{
		$this->redirectPath = $request->input('redirect');
		return parent::postRegister($request);
	}

	public function postLogin(Request $request)
	{
		$this->redirectPath = $request->input('redirect');
		return 	parent::postLogin($request);
	}
}
