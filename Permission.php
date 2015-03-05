<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	protected $table    = 'permissions';
	protected $fillable = ['key', 'value'];
	protected $casts    = ['value' => 'boolean'];

	public function getValueAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	public function users()
	{
		return $this->belongsToMany('\App\Modules\Acl\AclUser', 'users_permissions', 'permission_id', 'user_id')->withTimestamps();
	}

	public function groups()
	{
		return $this->belongsToMany('\App\Modules\Acl\Group', 'groups_permissions', 'permission_id', 'group_id')->withTimestamps();
	}

	public static function boot()
	{
		parent::boot();

		Permission::deleting(function($permission)
		{
			$permission->users()->detach();
			$permission->groups()->detach();
		});
	}
}
