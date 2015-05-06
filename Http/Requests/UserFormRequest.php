<?php namespace App\Modules\Acl\Http\Requests;

use App\Http\Requests\Request;
use App\Modules\Acl\Repositories\AclRepository;

class UserFormRequest extends Request {
	
	/**
	 * The AclRepository implementation.
	 *
	 * @var AclRepository
	 */
	protected $aclRepo;

	/**
	 * Create a new request instance.
	 *
	 * @param  AclRepository  $aclRepo
	 * @return void
	 */
	public function __construct(AclRepository $aclRepo)
	{
		$this->aclRepo = $aclRepo;
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name'     => 'required',
			'email'    => 'required|email|unique:users,id,'.$this->get('id'),
			'password' => 'required|min:6',
		];
	}

}
