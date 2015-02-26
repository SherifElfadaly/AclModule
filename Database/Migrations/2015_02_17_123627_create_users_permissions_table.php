<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPermissionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('users_permissions'))
		{
			Schema::create('users_permissions', function(Blueprint $table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('permission_id');
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('users_permissions'))
		{
			Schema::drop('users_permissions');
		}
	}
}