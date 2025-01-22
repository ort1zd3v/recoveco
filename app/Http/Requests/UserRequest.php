<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UserRequest extends FormRequest
{
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
			'role_id' => 'required',
			'name' => 'required|max:255',
			'paternal_surname' => 'required|max:255',
			'maternal_surname' => 'required|max:255',
			'email' => [
				'required',
				'max:255',
				'email',
				Rule::unique('users')->ignore($this->get("id")),
			],
			'password' => ($this->get("id") == null ? 'required|':'').'max:255',
		];
	}
}