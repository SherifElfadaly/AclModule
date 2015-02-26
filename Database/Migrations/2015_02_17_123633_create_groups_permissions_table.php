<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsPermissionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('groups_permissions'))
		{
			Schema::create('groups_permissions', function(Blueprint $table) {
				$table->increments('id');
				$table->integer('group_id');
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
		if (Schema::hasTable('groups_permissions'))
		{
			Schema::drop('groups_permissions');
		}
	}
}