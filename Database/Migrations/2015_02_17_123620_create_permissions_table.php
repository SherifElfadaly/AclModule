<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('permissions'))
		{
			Schema::create('permissions', function(Blueprint $table) {
				$table->increments('id');
				$table->string('key');
				$table->boolean('value')->default(0);
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
		if (Schema::hasTable('permissions'))
		{
			Schema::drop('permissions');
		}
	}
}