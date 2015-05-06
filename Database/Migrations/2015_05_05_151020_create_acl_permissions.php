<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclPermissions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach (\InstallationRepository::getModuleParts('acl') as $modulePart) 
		{
			\AclRepository::insertDefaultItemPermissions(
				$modulePart->part_key, 
				$modulePart->id, 
				[
				'admin'   => ['show', 'add', 'edit', 'delete'],
				'manager' => ['show', 'edit']
				]);
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		foreach (\InstallationRepository::getModuleParts('acl') as $modulePart) 
		{
			\AclRepository::deleteItemPermissions($modulePart->part_key);
		}
	}
}