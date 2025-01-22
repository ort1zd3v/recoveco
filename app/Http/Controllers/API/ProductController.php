<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends APIController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$result = Product::where("is_active", true)->where("is_saleable", true);
		$result = $this->filters($result, request()->all());
		foreach ($result as $key => $product) {
			$product->has_ingredients = $product->hasIngredients();
			$product->ingredients_amount = $product->getIngredientsAmount();
			$product->ingredients = $product->getAllProductIngredients(true);
			//$product = $product->toArray();
			//dd($product->toArray());
		}
		return response()->json($result, 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		return response()->json(false, 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$product = Product::with("productIngredients.ingredient")->find($id);
		$product->has_ingredients = $product->hasIngredients();
		$product->ingredients_amount = $product->getIngredientsAmount();
		$product->ingredients = $product->getAllProductIngredients(true);
		return response()->json($product, 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		return response()->json(false, 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		return response()->json(false, 200);
	}
}
