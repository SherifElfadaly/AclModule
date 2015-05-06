<?php
namespace App\Modules\Acl\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
	/**
	 * Register the Acl module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Acl\Providers\RouteServiceProvider');

		//Bind AclRepository Facade to the IoC Container
		App::bind('AclRepository', function()
		{
			return new App\Modules\Acl\Repositories\AclRepository;
		});
		
		$this->registerNamespaces();
	}

	/**
	 * Register the Acl module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('Acl', __DIR__.'/../Resources/Lang/');

		View::addNamespace('Acl', __DIR__.'/../Resources/Views/');
	}
}
