<?php namespace App\Modules\Acl\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Acl\Social;

use Illuminate\Http\Request;

class SocialController extends Controller {

	/**
	 * Login a user using social plugins
	 *
	 * @return Response
	 */
	public function login($type, Social $social, Request $request)
	{
		return $social->check($request->has('code'), $type, $this);
	}

	public function redirectRegister($user)
	{
		$user_data = array('email' => $user->email, 'name' => $user->name);
		return redirect('Acl/register')->with('user_data', $user_data);
	}

	public function redirectLogin()
	{
		return redirect('/');
	}
}
