<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'Acl'], function() {

	//Social Login
	Route::get('social/{type?}', 'SocialController@login');

	//Users, Permissions, Groups, Register, Login and Password Pages
	Route::controllers([
		'/users'            => 'AclUserController',
		'/permissions'      => 'PermissionController',
		'/groups'           => 'GroupController',
		'/password'         => 'Auth\PasswordResetController',
		'/'                 => 'Auth\AuthenticateController',
		]);

});