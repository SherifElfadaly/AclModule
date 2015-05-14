<?php namespace App\Modules\Acl\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Closure;

class AclAdminAuthenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
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
				return redirect()->guest('admin/Acl/login');
			}
		}
		elseif ( ! \CMS::users()->userHasGroup(\Auth::user()->id, 'admin')) 
		{
			abort(403, 'Unauthorized');
		}

		return $next($request);
	}
}
