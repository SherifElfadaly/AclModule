<?php namespace App\Modules\Acl\Http\Controllers\Auth;

use App\Http\Controllers\Auth\PasswordController;

class PasswordResetController extends PasswordController {

	/**
	 * Specify the redirect path to
	 * the login page.
	 * 
	 * @var redirectPath
	 */
	protected $redirectPath = 'admin/Acl/login';

	/**
	 * Show the form for forget password.
	 * 
	 * @return Response
	 */
	public function getEmail()
	{
		return view('Acl::auth.password');
	}

	/**
	 * Show the form for reseting the user password 
	 * if the token is valid.
	 * 
	 * @param  String $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token))
		{
			throw new NotFoundHttpException;
		}

		return view('Acl::auth.reset')->with('token', $token);
	}
}
