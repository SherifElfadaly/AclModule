<?php namespace App\Modules\Acl;

use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Modules\Acl\Repositories\AclRepository;

class Social {
	
	private $socialite;
	private $acl;

	public function __construct(AclRepository $acl, Socialite $socialite)
	{
		$this->socialite = $socialite;
		$this->acl     = $acl;
	}

	public function check($code, $type, $listener)
	{
		if ( ! $code) return $this->socialite->with($type)->redirect();
		
		$social_user    = $this->socialite->with($type)->user();
		$registerd_user = $this->acl->findUserByEmail($social_user->email);

		if ( ! $registerd_user) 
		{
			return $listener->redirectRegister($social_user);
		}
		
		if (\Auth::loginUsingId($registerd_user->id))
        {
            return $listener->redirectLogin();
        }
	}
}
