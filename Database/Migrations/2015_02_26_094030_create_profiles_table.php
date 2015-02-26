<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{	if ( ! Schema::hasTable('profiles'))
	{
		Schema::create('profiles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('key');
			$table->text('value');
			$table->integer('user_id');
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
		if (Schema::hasTable('profiles'))
		{
			Schema::drop('profiles');
		}
	}
}