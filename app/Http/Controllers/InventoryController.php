<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Product;

use App\Http\Requests\InventoryRequest;
use App\DataTables\InventoryDataTable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use App\Imports\ExcelWithHeadersImport;
use Carbon\Carbon;


class InventoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = false;
		$allowEdit = false;
		return (new InventoryDataTable())->render('inventories.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('inventories.create', compact('products'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(InventoryRequest $request)
	{
		$status = true;
		$inventory = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$inventory = Inventory::create($params);
			$message = __('inventories.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'inventories');
		}
		return $this->getResponse($status, $message, $inventory);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function show(Inventory $inventory)
	{
		return view('inventories.show', compact('inventory'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Inventory $inventory)
	{
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('inventories.edit', compact('inventory','products'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function update(InventoryRequest $request, Inventory $inventory)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$inventory->update($params);
			$message = __('inventories.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'inventories');
		}
		return $this->getResponse($status, $message, $inventory);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Inventory $inventory)
	{
		$status = true;
		try {
			$inventory->delete();
			$message = __('inventories.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'inventories');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Inventory $inventory = null)
	{
		$params = request("params");
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'inventory','products'))->render());
	}

	public function checkMovement($inventory_movement_type_id, $product_id, $amount)
	{
		$result = ["status" => true, "message" => ""];
		$product = Product::find($product_id);
		if ($product->is_discountable && $product->getComboProducts() == null) {
			$result = $this->checkInventory($inventory_movement_type_id, $product_id, $amount);
		}elseif ($product->getComboProducts() != null) {
			foreach ($product->getComboProducts() as $product) {
				$productIngredient = Product::find($product['product_id']);
				$productIngredientAmount = $product['amount'] * $amount;
				$result = $this->checkInventory($inventory_movement_type_id, $productIngredient->id, $productIngredientAmount);
				if (!$result['status']) {
					break;
				}
			}
		}

		return $result;
	}

	public function checkInventory($inventory_movement_type_id, $product_id, $amount)
	{
		$result = ["status" => true, "message" => ""];

		$product = Product::find($product_id);
		//Check if movement subtracts from inventory
		if (in_array($inventory_movement_type_id, [2,3,5,6])) {
			$inventory = Inventory::where("product_id", $product_id)->first();
			//Check if product exists in inventory
			if ($inventory != null) {
				//Check if product have more than 0 units in inventory
				if (intval($inventory->amount) > 0) {
					//Check if the given amount is available to substract from inventory
					if (intval($inventory->amount) < intval($amount)) {
						$result["status"] = false;
						$result["message"] = __("inventories.inventory_decrease_error", ["product" => $product->name]);
					}
				} else {
					$result["status"] = false;
					$result["message"] = __("inventories.inventory_empty", ["product" => $product->name]);
				}
			} else {
				$result["status"] = false;
				$result["message"] = __("inventories.inventory_does_not_exist", ["product" => $product->name]);
			}
		}
		return $result;
	}

	public function updateMovement($inventory_movement_type_id, $product_id, $amount)
	{
		$product = Product::find($product_id);

		if ($product->getComboProducts() == null) {
			$this->updateInventory($inventory_movement_type_id, $product_id, $amount);
		} else {
			$comboProducts = $product->getComboProducts();
			$this->processComboProducts($inventory_movement_type_id, $comboProducts, $amount);
		}
	}

	// Función auxiliar para procesar los combo products recursivamente
	private function processComboProducts($inventory_movement_type_id, $products, $amount)
	{
		foreach ($products as $product) {
			$productIngredientAmount = $product['amount'] * $amount;
			$this->updateInventory($inventory_movement_type_id, $product['product_id'], $productIngredientAmount);

			// Si el producto tiene combo products (productos hijos), procesarlos recursivamente
			$comboProducts = Product::find($product['product_id'])->getComboProducts();
			if ($comboProducts) {
				$this->processComboProducts($inventory_movement_type_id, $comboProducts, $productIngredientAmount);
			}
		}
	}

	public function updateInventory($inventory_movement_type_id, $product_id, $amount)
	{
		$inventory = Inventory::where("product_id", $product_id)->first();
		$product = Product::find($product_id);

		if (in_array($inventory_movement_type_id, [2,3,5,6])) {
			if ($inventory != null && $product->is_discountable) {
				$inventory->amount = intval($inventory->amount) - intval($amount);
				$inventory->save();
			}
		} else {
			if ($inventory != null && $product->is_discountable) {
				$inventory->amount = intval($inventory->amount) + intval($amount);
				$inventory->save();
			} else {
				Inventory::create([
					'product_id' => $product_id,
					'amount' => $amount,
					'created_by' => auth()->id(),
					'updated_by' => auth()->id(),
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s")
				]);
			}
		}
	}

/**
	 * Lee el archivo excel de inventario, 
	 * si existe el producto actualiza el precio y su cantidad'
	 * si es negativo lo resta
	 * si es positivo lo suma
	 * si no existe el codigo de barras crea el producto con los defaults y con su inventario correspondeinte
	 * Se ejecuta desde ajax
	 */
	public function insertOrUpdateInventory()
	{
		$result = ["status" => true, "message" => "Inventarios actualizados correctamente.", "inventories" => [], "icon" => "success"];
		$inventories['added'] = 0;
		$inventories['updated'] = 0;

		if(request()->hasFile('file_input')) {
			$file = request()->file('file_input');
			try {
				$sourceRowsPage = (Excel::toArray(new ExcelImport(), $file))[0];

				$row = [];
				$data = [];

				$supplier_id = $sourceRowsPage[3][2];
				$date = Carbon::createFromFormat('d-m-Y', '01-01-1900')->addDays($sourceRowsPage[0][2] - 2)->format('Y-m-d');

				$sourceRowsPage = array_slice($sourceRowsPage, 9);
				foreach ($sourceRowsPage as $key => $sourceRow) {
					$row = [
						'name' => $sourceRow[0] ?? '',
						'barcode' => $sourceRow[1] ?? '',
						'qty' => $sourceRow[2] ?? '',
						'price' => $sourceRow[3] ?? '',
					];

					if (strtolower(trim($row['name'])) == 'fin') {
						break;
					}

					//comprobar que exista el producto con codigo de barras
					$product = Product::where('barcode', $row['barcode'])->first() ?? null;

					//si no exsite se crea el producto
					if ($product == null) {
						$product = Product::create([
							'unit_type_id' => 6,
							'category_id' => 1,
							'supplier_id' => $supplier_id,
							'name' => $row['name'],
							'display_name' => $row['name'],
							'barcode' => $row['barcode'],
							'color' => '#ffffff',
							'url_image' => '',
							'print_order' => 1,
							'iva' => 0,
							'cost_base' => $row['price'],
							'cost_min' => $row['price'],
							'cost_max' => $row['price'],
							'price_base' => $row['price'],
							'price_min' => $row['price'],
							'price_max' => $row['price'],
							'overprice' => 0,
							'is_saleable' => 1,
							'is_ticketable' => 1,
							'is_discountable' => 1,
							'is_favorite' => 0,
							'is_consigment' => 1,
							'is_product' => 1,
							'notes' => '',
							'is_active' => 1,
							'created_by' => auth()->id(),
							'updated_by' => auth()->id(),
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s")
						]);
						$row['qty'] = intval($row['qty']) < 0 ? 0 : intval($row['qty']);
						$inventories['added']++;
					}else{
						$product->update([
							'name' => $row['name'],
							'display_name' => $row['name'],
							'cost_base' => $row['price'],
							'cost_min' => $row['price'],
							'cost_max' => $row['price'],
							'price_base' => $row['price'],
							'price_min' => $row['price'],
							'price_max' => $row['price'],
						]);
						$inventories['updated']++;
					}

					$movementType = intval($row['qty']) > 0 ? 1 : 6; 
					$addMovement = (new InventoryMovementController)->addMovement($movementType, $product->id, abs(intval($row['qty'])), $date);
				}

				$result['inventories'] = $inventories;

			} catch (Exception $e) {
				$result["status"] = false;
				$result["message"] = __("inventories.file_read_error");
				$result["icon"] = "error";
			}
		} else {
			$result["status"] = false;
			$result["message"] = __("inventories.file_request_empty");
			$result["icon"] = "error";
		}
		return $result;
	}
	
}
