<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	protected $table    = 'permissions';
	protected $fillable = ['key'];

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
			$permission->users()->detach();
			$permission->groups()->detach();
		});
	}
}
