<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
	use HasFactory;
	
	protected $table = 'products';
	protected $fillable = ['id', 'unit_type_id', 'category_id', 'supplier_id', 'name', 'display_name', 'barcode', 'color', 'url_image', 'print_order', 'iva', 'cost_base', 'cost_min', 'cost_max', 'price_base', 'price_min', 'price_max', 'overprice', 'is_saleable', 'is_ticketable', 'is_discountable', 'is_favorite', 'is_consigment', 'is_product', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}
	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}
	public function unitType()
	{
		return $this->belongsTo('App\Models\UnitType', 'unit_type_id');
	}
	public function supplier()
	{
		return $this->belongsTo('App\Models\Supplier', 'supplier_id');
	}
	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
	
	public function buyingRows()
	{
		return $this->hasMany('App\Models\BuyingRow');
	}
	
	public function productIngredients()
	{
		return $this->hasMany('App\Models\Ingredient', 'product_id');
	}
	
	public function ingredients()
	{
		return $this->hasMany('App\Models\Ingredient', 'ingredient_id');
	}
	
	public function inventories()
	{
		return $this->hasMany('App\Models\Inventory');
	}
	
	public function kioskos()
	{
		return $this->hasMany('App\Models\Kiosko');
	}
	
	public function productImages()
	{
		return $this->hasMany('App\Models\ProductImage');
	}
	
	public function productValues()
	{
		return $this->hasMany('App\Models\ProductValue');
	}
	
	public function sellingRows()
	{
		return $this->hasMany('App\Models\SellingRow');
	}

	//Autocomplete
	public static function getProduct()
	{
		return static::select('id', DB::raw("CONCAT_WS(' ', supplier_id, '-', name) as value"))->orderBy('name', 'asc');
	}

	/**
	 * [isCombo] Check if the product have any product or category as ingredient
	 *
	 * @return boolean
	 */
	public function isCombo()
	{
		$result = false;
		foreach ($this->productIngredients as $key => $ingredient) {
			$result = true;
			break;
		}
		return $result;
	}

	/**
	 * [hasIngredients] Check if the product have any category as ingredient
	 *
	 * @return boolean
	 */
	public function hasIngredients()
	{
		$result = false;
		if (!$this->productIngredients->isEmpty()) {
			foreach ($this->productIngredients as $key => $ingredient) {
				if ($ingredient->ingredient_id != null) {
					$p = Product::find($ingredient->ingredient_id);
					$result = $p->hasIngredients();
				
					if ($result) {
						break;
					}
				} else {
					$result = true;
					break;
				}
			}
		}

		return $result;
	}
	
	/**
	 * [getIngredientsAmount] Count the amount of ingredients the user need to select
	 *
	 * @return int
	 */
	public function getIngredientsAmount()
	{
		$result = 0;
		foreach ($this->productIngredients as $key => $ingredient) {
			if ($ingredient->ingredient_id == null) {
				$result++;
			}
		}
		return $result;
	}
	
	/**
	 * [getComboProducts] Get products in a combo to show in combo details
	 *
	 * @return int
	 */
	public function getComboProducts()
	{
		$result = null;
		foreach ($this->productIngredients as $key => $ingredient) {
			if ($ingredient->ingredient_id != null) {
				$pi = Product::find($ingredient->ingredient_id);
				$result[] = [
					"product_id" => $pi->id,
					"product_name" => $pi->name,
					"amount" => $ingredient->amount,
					"overprice" => $pi->overprice,
				];
			}
		}
		return $result;
	}

	
	/**
	 * [getAllProductIngredients] Get recursively all ingredients user need to select
	 *
	 * @return void
	 */
	public function getAllProductIngredients($isArray = false)
	{
		$result = [];
		foreach ($this->productIngredients as $key => $ingredient) {
			if ($ingredient->ingredient_id != null) {
				$p = Product::find($ingredient->ingredient_id);
				$t = $p->getAllProductIngredients($isArray);
				if($t != null) {
					$result = array_merge($result, $t);
				}
			} else {
				$product = $this;
				$product->has_ingredients = $this->hasIngredients();
				$product->ingredients_amount = $this->getIngredientsAmount();
				$row = $ingredient->load("category");
				$cat_ingredients = $ingredient->category->products->where('is_active', true)->sortBy('name');

				unset($this->productIngredients);
				unset($ingredient->category);
				//For webservice I need to retreive data as array to avoid recursive references
				if($isArray) {
					$product = $product->toArray();
					$row = $row->toArray();
					$row["amount"] = $ingredient->amount;
					$row["cat_ingredients"] = $cat_ingredients->toArray();
				} else {
					$row->amount = $ingredient->amount;
					$row->cat_ingredients = $cat_ingredients;
				}

				$result[$this->id]["product"] = $product;
				$result[$this->id]["ingredients"][] = $row;
			}
		}

		return $result;
	}

		
	// /**
	//  * [getProductIngredients] Get all ingredients of one product
	//  *
	//  * @return void
	//  */
	// public function getProductIngredients()
	// {
	// 	$result = [];
	// 	foreach ($this->productIngredients as $key => $ingredient) {
	// 		if ($ingredient->ingredient_id == null) {
	// 			$result[$this->id]["product"] = $this;
	// 			$row = $ingredient->load("category");
	// 			$row->amount = $ingredient->amount;
	// 			$row->cat_ingredients = $ingredient->category->products->where('is_active', true)->sortBy('name');
	// 			$result[$this->id]["ingredients"][] = $row;
	// 		}
	// 	}
	// 	return $result;
	// }


}