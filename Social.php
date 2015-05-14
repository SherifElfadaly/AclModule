<?php namespace App\Modules\Acl;

use Laravel\Socialite\Contracts\Factory as Socialite;

class Social {
	
	/**
	 * The socialite implementation.
	 * 
	 * @var socialite
	 */
	private $socialite;

	/**
	 * Create new Social instance.
	 * 
	 * @param Socialite $socialite
	 */
	public function __construct(Socialite $socialite)
	{
		$this->socialite = $socialite;
	}

	/**
	 * Send request to the social if the code 
	 * dosen't exists , get the social user data
	 * if the code exists and check if the user is
	 * registerd then log in the user and if not registerd
	 * then redirect to register page with the social user data.
	 * 
	 * @param  string $code     the code returned by the social
	 * @param  string $type     the social type
	 * @param  object $listener the social controller object
	 * @return response
	 */
	public function check($code, $type, $listener)
	{
		if ( ! $code) return $this->socialite->with($type)->redirect();
		
		$social_user    = $this->socialite->with($type)->user();
		$registerd_user = \CMS::users()->findBy('email', $social_user->email);

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
