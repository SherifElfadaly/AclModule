<?php namespace App\Modules\Acl\Http\Requests;

use App\Http\Requests\Request;

class EditUserFormRequest extends Request {
	
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
			'name'     => 'required|max:50|alpha_dash',
			'email'    => 'required|max:100|email|unique:users,id,'.$this->get('id'),
		];
	}

}
