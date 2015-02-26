<?php namespace App\Modules\Acl\Http\Middleware;

use App\Modules\Acl\Repositories\AclRepository;
use Closure;

class AclAuthenticate {

	/**
	 * The AclRepository implementation.
	 *
	 * @var AclRepository
	 */
	protected $aclRepo;

	/**
	 * Create a new filter instance.
	 *
	 * @param  AclRepository  $aclRepo
	 * @return void
	 */
	public function __construct(AclRepository $aclRepo)
	{
		$this->aclRepo = $aclRepo;
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
		//If the user is admin
		if ( ! $this->aclRepo->userHasGroup(\Auth::user()->id, 'admin')) 
		{
			return response('Unauthorized.', 401);
		}
		return $next($request);
	}

}
