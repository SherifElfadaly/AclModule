<?php namespace App\Modules\Acl\Http\Controllers\Auth;

use App\Http\Controllers\Auth\PasswordController;

class PasswordResetController extends PasswordController {

	protected $redirectPath = 'Acl/login';

	public function getEmail()
	{
		return view('Acl::auth.password');
	}

	public function getReset($token = null)
	{
		if (is_null($token))
		{
			throw new NotFoundHttpException;
		}

		return view('Acl::auth.reset')->with('token', $token);
	}
}
