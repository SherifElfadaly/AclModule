<?php namespace App\Modules\Acl\Facades;

use Illuminate\Support\Facades\Facade;

class AclRepository extends Facade
{
	protected static function getFacadeAccessor() { return 'AclRepository'; }
}