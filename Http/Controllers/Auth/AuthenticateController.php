<?php namespace App\Modules\Acl\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthController;

class AuthenticateController extends AuthController {

	protected $redirectPath = '/';
	protected $loginPath    = 'Acl/login';

	public function getRegister()
	{
		return view('Acl::auth.register');
	}

	public function getLogin()
	{
		return view('Acl::auth.login');	
	}
}
