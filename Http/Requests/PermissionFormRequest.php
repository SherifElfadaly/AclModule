<?php namespace App\Modules\Acl\Http\Requests;

use App\Http\Requests\Request;
use App\Modules\Acl\Repositories\AclRepository;

class PermissionFormRequest extends Request {

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
		//If the user is admin
		return $this->aclRepo->userHasGroup(\Auth::user()->id, 'admin');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'key' => 'required|unique:permissions,id,'.$this->get('id'),
		];
	}

}
