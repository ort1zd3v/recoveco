<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\UnitType;
use App\Models\Supplier;
use App\Models\Inventory;

use App\Services\ProductService;

use App\DataTables\IngredientDataTable;
use App\DataTables\ProductDataTable;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

use DataTables;

class ProductController extends Controller
{
	use UploadTrait;

	protected $categories;
	protected $unitTypes;
	protected $suppliers;

	public function __construct()
	{
		$this->categories = Category::selectElements('name');
		$this->unitTypes = UnitType::selectElements('name');
		$this->suppliers = Supplier::selectElements('name');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("products.create");
		$allowEdit = auth()->user()->hasPermissions("products.edit");
		return (new ProductDataTable('products'))->render('products.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$ingredientsView = $this->getIngredientsView();
		return view('products.create', array_merge(compact('ingredientsView'), [
			'categories' => $this->categories,
			'unitTypes' => $this->unitTypes,
			'suppliers' => $this->suppliers,
		]));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ProductRequest $request)
	{
		$status = true;
		$product = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);

		if(request()->hasFile('url_image')) {
			$file = request()->file('url_image');
			$path = $this->uploadFile($file, 'images/products');
			$params['url_image'] = $path;
		}else{
			$params['url_image'] = 'no-image.png';
			if ($params['color'] == "#000000") {
				$params['color'] = '';
			}
		}
		
		$product = Product::create($params);
		Inventory::create([
			'product_id' => $product->id,
			'amount' => $params['amount'],
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$message = __('products.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'products');
		}
		return redirect()->route('products.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show(Product $product)
	{
		return view('products.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Product $product)
	{
		$ingredientsView = $this->getIngredientsView($product->id);
		return view('products.edit', array_merge(compact('product', 'ingredientsView'), [
			'categories' => $this->categories,
			'unitTypes' => $this->unitTypes,
			'suppliers' => $this->suppliers,
		]));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(ProductRequest $request, Product $product)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);

		if(request()->hasFile('url_image')) {
			$file = (request()->file('url_image'));
			$path = $this->uploadFile($file, 'images/products');
			$params['url_image'] = $path;
		}else{
			if ($params['color'] == "#000000") {
				$params['color'] = '';
			}
		}

		try {
			$product->update($params);
			$inventory = $product->inventories()->first();
			$inventory->amount = $params['amount'];
			$inventory->save();
			$message = __('products.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'products');
		}
		return $this->getResponse($status, $message, $product);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Product $product)
	{
		$status = true;
		try {
			$product->delete();
			$message = __('products.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'products');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Product $product = null)
	{
		$params = request("params");
		$categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
		$unitTypes = UnitType::orderBy('name', 'asc')->pluck('name', 'id');
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'product','categories','unitTypes'))->render());
	}

	// public function getByParam(Request $request, $id)
	// {
	// 	if($id != 0){
	// 		$products = Product::select('name as value', 'id')
	// 		->where('category_id', $id)
	// 		->where('name', 'like', "%{$request->name}%")
	// 		->get();
	
	// 		return response()->json($products, 200);
	// 	}

	// 	return response()->json([], 200);
	// }

	public function getByParam()
	{
		//dd(request()->all());
		$result = Product::getProduct()->where("name", "like", "%".request("name")."%")->where("supplier_id", request("supplier_id"))->get();
        if($result->isEmpty()) {
            $result = [['value' => 'No se encontraron resultados', 'disabled' => true]]; 
        }
		return response()->json($result, 200);
	}

	public function getIngredientsView($productId = 0)
	{
		$dataTable = new IngredientDataTable($productId);
		return view('products.fields.ingredient-fields', compact('productId', 'dataTable'));
	}

	public function getProductTableView()
	{
		$dataTable = new ProductDataTable();
		$categories = Category::all();

		$html = (new ProductService)->getHTMLProductDataTable($dataTable);
		return [
			'tableView' => view('products.table', compact('html', 'categories'))->render(), 
			'html' => $html
		];
	}

	public function getProductTableAjax()
	{
		$dataTable = new ProductDataTable();
		if(request()->ajax()){
			$query = $dataTable->query((new Product));

			if(request()->has('category_id')){
				$query->where('products.category_id', request()->category_id);
			}

			return DataTables::eloquent($query)->toJson();
		}
	}
	
}
