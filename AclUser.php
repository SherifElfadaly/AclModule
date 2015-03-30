<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AclUser extends User {

	protected $fillable = ['name', 'email', 'password'];

	public function groups()
	{
		return $this->belongsToMany('\App\Modules\Acl\Group', 'users_groups', 'user_id', 'group_id')->withTimestamps();
	}

	public function languageContents()
	{
		return $this->hasMany('\App\Modules\Language\LanguageContent', 'item_id');
	}

	public function contents()
    {
        return $this->hasMany('App\Modules\Content\ContentItems', 'user_id');
    }

	public static function boot()
	{
		parent::boot();

		AclUser::deleting(function($user)
		{
			$user->contents()->delete();
			$user->groups()->detach();

			\LanguageRepository::deleteItemLanguageContents('user', $user->id);
		});
	}
}
