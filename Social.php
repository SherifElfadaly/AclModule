<?php namespace App\Modules\Acl;

use Laravel\Socialite\Contracts\Factory as Socialite;

use App\Modules\Acl\Repositories\AclRepository;
use Auth;

class Social {
	
	private $socialite;
	private $users;

	public function __construct(AclRepository $users, Socialite $socialite)
	{
		$this->socialite = $socialite;
		$this->users     = $users;
	}

	public function check($code, $type, $listener)
	{
		if ( ! $code) return $this->socialite->with($type)->redirect();
		
		$social_user    = $this->socialite->with($type)->user();
		$registerd_user = $this->users->findUserByEmail($social_user->email);

		if ( ! $registerd_user) 
		{
			return $listener->redirectRegister($social_user);
		}
		
		if (Auth::loginUsingId($registerd_user->id))
        {
            return $listener->redirectLogin();
        }
	}
}
