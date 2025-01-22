<?php

namespace App\Http\Controllers;

use App\Models\Category;

use App\Http\Requests\CategoryRequest;
use App\DataTables\CategoryDataTable;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("categories.create");
		$allowEdit = auth()->user()->hasPermissions("categories.edit");
		return (new CategoryDataTable())->render('categories.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('categories.create', compact('categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CategoryRequest $request)
	{
		$status = true;
		$category = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$category = Category::create($params);
			$message = __('categories.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'categories');
		}
		return $this->getResponse($status, $message, $category);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function show(Category $category)
	{
		return view('categories.show', compact('category'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Category $category)
	{
		$categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('categories.edit', compact('category','categories'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function update(CategoryRequest $request, Category $category)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$category->update($params);
			$message = __('categories.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'categories');
		}
		return $this->getResponse($status, $message, $category);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Category $category)
	{
		$status = true;
		try {
			$category->delete();
			$message = __('categories.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'categories');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Category $category = null)
	{
		$params = request("params");
		$categories = ["" => ""] + Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'category','categories'))->render());
	}

	public function getByParam(Request $request)
	{
		$categories = Category::select('name as value', 'id')
		->where('name', 'like', "%{$request->name}%")
		->get();

		return response()->json($categories, 200);
	}
}
