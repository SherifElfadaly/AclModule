<?php namespace App\Modules\Acl;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

	protected $table = 'profiles';
	protected $fillable = ['key', 'value'];

	public function user()
	{
		return $this->belongsTo('App\Modules\Acl\AclUser');
	}
}
