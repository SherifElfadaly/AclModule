<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('password_resets'))
		{
			Schema::create('password_resets', function(Blueprint $table) 
			{
				$table->string('email', 100)->index();
				$table->string('token')->index();
				$table->timestamp('created_at');
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
		if (Schema::hasTable('password_resets'))
		{
			Schema::drop('password_resets');
		}
	}
}