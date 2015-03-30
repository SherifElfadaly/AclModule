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
				$table->bigIncrements('id');

				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');

				$table->bigInteger('group_id')->unsigned();
				$table->foreign('group_id')->references('id')->on('groups');
				
				$table->timestamps();
			});
			
			DB::table('users_groups')->insert(
				array(
					'user_id'  => '1',
					'group_id' => '1'
					)
				);
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