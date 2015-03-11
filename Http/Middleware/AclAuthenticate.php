<?php namespace App\Modules\Acl\Http\Middleware;

use App\Modules\Acl\Repositories\AclRepository;
use Illuminate\Contracts\Auth\Guard;
use Closure;

class AclAuthenticate {

	/**
	 * The AclRepository implementation.
	 *
	 * @var AclRepository
	 */
	protected $aclRepo;

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  AclRepository  $aclRepo
	 * @return void
	 */
	public function __construct(AclRepository $aclRepo, Guard $auth)
	{
		$this->aclRepo = $aclRepo;
		$this->auth    = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{	
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('Acl/login');
			}
		}
		elseif ( ! $this->aclRepo->userHasGroup(\Auth::user()->id, 'admin')) 
		{
			return response('Unauthorized.', 401);
		}

		return $next($request);
	}

}
