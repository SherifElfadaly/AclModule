<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersGroupsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('users_groups'))
		{
			Schema::create('users_groups', function(Blueprint $table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('group_id');
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
		if (Schema::hasTable('users_groups'))
		{
			Schema::drop('users_groups');
		}
	}
}