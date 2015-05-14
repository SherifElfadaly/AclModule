<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'permissions';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['key'];

	/**
	 * Get the permission groups.
	 * 
	 * @return collection
	 */
	public function groups()
	{
		return $this->belongsToMany('\App\Modules\Acl\Group', 'groups_permissions', 'permission_id', 'group_id')->
		              withPivot('item_id', 'item_type')->
		              withTimestamps();
	}

	public static function boot()
	{
		parent::boot();

		Permission::deleting(function($permission)
		{
			/**
			 * Remove the users and groups
			 * related to the deleted permission.
			 */
			$permission->users()->detach();
			$permission->groups()->detach();
		});
	}
}
