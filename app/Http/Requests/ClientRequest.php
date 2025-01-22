<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ClientAttribute;

class ClientRequest extends FormRequest
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
		return array_merge([
			'name' => 'required|max:255',
			'branch_id' => 'required',
			'notes' => 'max:1024',
		]/*, $this->getRequiredRuleOrLangAttributes(true)*/); 
	}

    /**
     * Get the custom attribute names for the validation error messages.
     *
     * @return array
     */
	public function attributes()
    {
        return $this->getRequiredRuleOrLangAttributes(false);
    }

	
	private function getRequiredRuleOrLangAttributes($rule)
	{
		$attributes = ClientAttribute::whereIsRequired(1)
		->get()
		->mapWithKeys(function ($clientAttribute) use($rule){
			$key = "dynamics." . $clientAttribute->id; 	

			if($rule) return [$key => 'required'];
			
			return [$key => ucfirst($clientAttribute->name)];
		})->toArray();

		return $attributes;
	}
}