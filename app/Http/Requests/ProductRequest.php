<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class ProductRequest extends FormRequest
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
			'name' => 'required|max:255',
			'unit_type_id' => 'required',
			'category_id' => 'required',
			'barcode' => 'required|max:255',
			'color' => 'required|max:255',
			'print_order' => [
				'required',
				'numeric',
				// Rule::unique('products')->ignore($this->get("id")),
			], //unique:products
			'iva' => 'required',
			'cost_base' => 'required',
			'cost_min' => 'required',
			'amount' => 'required',
			'cost_max' => 'required',
			'price_base' => 'required',
			'price_min' => 'required',
			'price_max' => 'required',
			'overprice' => 'required',

			// 'is_saleable' => 'required',
			// 'is_ticketable' => 'required',
			// 'is_discountable' => 'required',
			// 'is_favorite' => 'required',
			// 'is_consigment' => 'required',
			// 'is_product' => 'required',
			'notes' => 'max:1024',
			'is_active' => 'required',
			
		];
	}
	public function attributes()
	{
		return [
			'name' => "Nombre",
			'unit_type_id' => "Tipo de unidad",
			'category_id' => "Categoría",
			'barcode' => "Código de barras",
			'color' => "Color de producto",
			'print_order' => "Orden de impresión",
			'amount' => 'Cantidad',
			'iva' => "IVA",
			'cost_base' => "Costo base",
			'cost_min' => "Costo mínimo",
			'cost_max' => "Costo máximo",
			'price_base' => "Precio base",
			'price_min' => "Precio mínimo",
			'price_max' => "Precio máximo",
			'overprice' => 'Sobreprecio',
			'is_active' => 'Activo',
		];
	}
}