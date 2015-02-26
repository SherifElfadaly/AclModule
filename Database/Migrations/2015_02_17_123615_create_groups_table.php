<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('groups'))
		{
			Schema::create('groups', function(Blueprint $table) {
				$table->increments('id');
				$table->string('group_name');
				$table->boolean('is_active')->default(0);
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
		if (Schema::hasTable('groups'))
		{
			Schema::drop('groups');
		}
	}
}