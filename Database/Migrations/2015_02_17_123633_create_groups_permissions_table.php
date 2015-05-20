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
				$table->bigIncrements('id');
				$table->bigInteger('group_id')->unsigned();
				$table->foreign('group_id')->references('id')->on('groups');
				$table->bigInteger('permission_id')->unsigned();
				$table->foreign('permission_id')->references('id')->on('permissions');
				$table->bigInteger('item_id')->unsigned();
				$table->string('item_type', 100)->index();
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