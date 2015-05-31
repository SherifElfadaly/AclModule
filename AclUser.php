<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AclUser extends User {

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * Get the name that will be displayed in the 
	 * menu link.
	 * 
	 * @return string
	 */
	public function getLinkNameAttribute()
	{
		return $this->attributes['name'];
	}

	/**
	 * Get all groups seperated by |.
	 * 
	 * @return string
	 */
	public function getUserGroupsAttribute()
	{
		return implode('|', $this->groups->lists('group_name'));
	}

	/**
	 * Encrypt the password attribute before
	 * saving it in the storage.
	 * 
	 * @param string $value 
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

	/**
	 * Get the user groups.
	 * 
	 * @return collection
	 */
	public function groups()
	{
		return $this->belongsToMany('\App\Modules\Acl\Group', 'users_groups', 'user_id', 'group_id')->withTimestamps();
	}

	/**
	 * Get the user contents.
	 * 
	 * @return collection
	 */
	public function contents()
    {
        return $this->hasMany('App\Modules\Content\ContentItems', 'user_id');
    }

	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the contents , groups and language contents 
		 * related to the deleted user.
		 */
		AclUser::deleting(function($user)
		{
			$user->contents()->delete();
			$user->groups()->detach();
			\CMS::languageContnets()->deleteItemLanguageContents('user', $user->id);
		});
	}
}
