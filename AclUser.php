<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AclUser extends User {

	protected $fillable = ['name', 'email', 'password'];

	public function groups()
	{
		return $this->belongsToMany('\App\Modules\Acl\Group', 'users_groups', 'user_id', 'group_id')->withTimestamps();
	}

	public function permissions()
	{
		return $this->belongsToMany('\App\Modules\Acl\Permission', 'users_permissions', 'user_id', 'permission_id')->withTimestamps();
	}

	public function languageContents()
	{
		return $this->hasMany('\App\Modules\Language\LanguageContent', 'item_id');
	}

	public static function boot()
	{
		parent::boot();

		AclUser::deleting(function($user)
		{
			foreach ($user->languageContents as  $languageContent) 
			{
				$languageContent->languageContentData()->delete();
			}	
			$user->languageContents()->delete();

			$user->groups()->detach();
			$user->permissions()->detach();
		});
	}
}
