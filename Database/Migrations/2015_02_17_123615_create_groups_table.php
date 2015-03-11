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

			DB::table('groups')->insert([
				array(
					'group_name' => 'admin',
					'is_active'  => '1'
					),
				array(
					'group_name' => 'manager',
					'is_active'  => '1'
					),
				array(
					'group_name' => 'user',
					'is_active'  => '1'
					),
				array(
					'group_name' => 'guest',
					'is_active'  => '1'
					),
				]
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
		if (Schema::hasTable('groups'))
		{
			Schema::drop('groups');
		}
	}
}