<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;

use App\Http\Requests\IngredientRequest;
use App\DataTables\IngredientDataTable;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("ingredients.create");
		$allowEdit = auth()->user()->hasPermissions("ingredients.edit");
		return (new IngredientDataTable())->render('ingredients.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('ingredients.create', compact('categories','products','products'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(IngredientRequest $request)
	{
		$status = true;
		$ingredient = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$ingredient = Ingredient::create($params);
			$message = __('ingredients.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'ingredients');
		}
		return $this->getResponse($status, $message, $ingredient);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Ingredient  $ingredient
	 * @return \Illuminate\Http\Response
	 */
	public function show(Ingredient $ingredient)
	{
		return view('ingredients.show', compact('ingredient'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Ingredient  $ingredient
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Ingredient $ingredient)
	{
		$categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('ingredients.edit', compact('ingredient','categories','products','products'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Ingredient  $ingredient
	 * @return \Illuminate\Http\Response
	 */
	public function update(IngredientRequest $request, Ingredient $ingredient)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$ingredient->update($params);
			$message = __('ingredients.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'ingredients');
		}
		return $this->getResponse($status, $message, $ingredient);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Ingredient  $ingredient
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Ingredient $ingredient)
	{
		$status = true;
		try {
			$ingredient->delete();
			$message = __('ingredients.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'ingredients');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Ingredient $ingredient = null)
	{
		$params = request("params");
		$categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'ingredient','categories','products','products'))->render());
	}

	public function getDataTable($id = null){
		return (new IngredientDataTable($id))->ajax();
	}
}
