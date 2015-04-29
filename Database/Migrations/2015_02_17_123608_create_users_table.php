<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('users'))
		{
			Schema::create('users', function(Blueprint $table)
			{
				$table->bigIncrements('id');
				$table->string('name', 50)->index();
				$table->string('email', 100)->unique();
				$table->string('password', 60);
				$table->string('activation_key');
				$table->rememberToken();
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
		if (Schema::hasTable('users'))
		{
			Schema::drop('users');
		}
	}
}