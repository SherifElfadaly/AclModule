<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	protected $table    = 'groups';
	protected $fillable = ['group_name', 'is_active'];
	protected $casts    = ['is_active' => 'boolean'];

	public function getIsActiveAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	public function users()
	{
		return $this->belongsToMany('\App\Modules\Acl\AclUser', 'users_groups', 'group_id', 'user_id')->withTimestamps();
	}

	public function permissions()
	{
		return $this->belongsToMany('\App\Modules\Acl\Permission', 'groups_permissions', 'group_id', 'permission_id')->withTimestamps();
	}

	public static function boot()
	{
		parent::boot();

		Group::deleting(function($group)
		{
			$group->users()->detach();
			$group->permissions()->detach();
		});
	}
}
