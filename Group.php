<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'groups';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['group_name', 'is_active'];

	/**
	 * Specify what field should be castet to what.
	 * 
	 * @var casts
	 */
	protected $casts    = ['is_active' => 'boolean'];

	/**
	 * Get True or False based on the value
	 * of is active field.
	 * 
	 * @param  inteher $value 
	 * @return string
	 */
	public function getIsActiveAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	/**
	 * Get the group users.
	 * 
	 * @return collection
	 */
	public function users()
	{
		return $this->belongsToMany('\App\Modules\Acl\AclUser', 'users_groups', 'group_id', 'user_id')->withTimestamps();
	}

	/**
	 * Get the group permissions.
	 * 
	 * @return collection
	 */
	public function permissions()
	{
		return $this->belongsToMany('\App\Modules\Acl\Permission', 'groups_permissions', 'group_id', 'permission_id')->
		withPivot('item_id', 'item_type')->
		withTimestamps();
	}

	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the users and permissions
		 * related to the deleted group.
		 */
		Group::deleting(function($group)
		{
			$group->users()->detach();
			$group->permissions()->detach();
		});
	}
}
