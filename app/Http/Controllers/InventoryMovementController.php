<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\InventoryMovementType;
use App\Models\Product;

use App\Http\Requests\InventoryMovementRequest;
use App\DataTables\InventoryMovementDataTable;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("inventory_movements.create");
		$allowEdit = auth()->user()->hasPermissions("inventory_movements.edit");
		$inventoryMovementTypes = InventoryMovementType::orderBy('name', 'asc')->pluck('name', 'id');
		$inventoryMovementTypes[0] = "TODOS";
		$inventoryMovementTypes = $inventoryMovementTypes->sortBy(function ($value, $key) {
			return $key;
		});
		return (new InventoryMovementDataTable())->render('inventory-movements.index', compact('allowAdd', 'allowEdit', 'inventoryMovementTypes'));
	}

	public function showview()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("inventory_movements.create");
		$allowEdit = auth()->user()->hasPermissions("inventory_movements.edit");
		$inventoryMovementTypes = InventoryMovementType::orderBy('name', 'asc')->pluck('name', 'id');
		$inventoryMovementTypes[0] = "TODOS";
		$inventoryMovementTypes = $inventoryMovementTypes->sortBy(function ($value, $key) {
			return $key;
		});
		return (new InventoryMovementDataTable())->render('inventory-movements.index', compact('allowAdd', 'allowEdit', 'inventoryMovementTypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$inventoryMovementTypes = InventoryMovementType::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('inventory-movements.create', compact('inventoryMovementTypes','products'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(InventoryMovementRequest $request)
	{
		$result = $this->addMovement(request('inventory_movement_type_id'), request('product_id'), request('amount'));
		return $result;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\InventoryMovement  $inventory_movement
	 * @return \Illuminate\Http\Response
	 */
	public function show(InventoryMovement $inventory_movement)
	{
		return view('inventory-movements.show', compact('inventory_movement'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\InventoryMovement  $inventory_movement
	 * @return \Illuminate\Http\Response
	 */
	public function edit(InventoryMovement $inventory_movement)
	{
		$inventoryMovementTypes = InventoryMovementType::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('inventory-movements.edit', compact('inventory_movement','inventoryMovementTypes','products'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\InventoryMovement  $inventory_movement
	 * @return \Illuminate\Http\Response
	 */
	public function update(InventoryMovementRequest $request, InventoryMovement $inventory_movement)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$inventory_movement->update($params);
			$message = __('inventory_movements.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'inventory_movements');
		}
		return $this->getResponse($status, $message, $inventory_movement);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\InventoryMovement  $inventory_movement
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(InventoryMovement $inventory_movement)
	{
		$status = true;
		try {
			$inventory_movement->delete();
			$message = __('inventory_movements.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'inventory_movements');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(InventoryMovement $inventory_movement = null)
	{
		$params = request("params");
		$inventoryMovementTypes = InventoryMovementType::orderBy('name', 'asc')->pluck('name', 'id');
		$products = Product::orderBy('name', 'asc')->pluck('name', 'id');
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'inventory_movement','inventoryMovementTypes','products'))->render());
	}

	/**
	 * Add a new intentory movement
	 *
	 * @param [Int] $inventory_movement_type_id
	 * @param [Int] $product_id
	 * @param [Int] $amount
	 * @return void
	 */
	public function addMovement($inventory_movement_type_id, $product_id, $amount, $date = null)
	{
		$status = true;
		$message = '';
		$params = [
			'inventory_movement_type_id' => $inventory_movement_type_id,
			'product_id' => $product_id,
			'amount' => $amount,
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => $date == null ? date("Y-m-d H:i:s") : $date,
			'updated_at' => $date == null ? date("Y-m-d H:i:s") : $date
		];
		
		$canDiscount = (new InventoryController)->checkMovement($inventory_movement_type_id, $product_id, $amount);

		if ($canDiscount["status"]) {
			try {
				$inventory_movement = InventoryMovement::create($params);
				(new InventoryController)->updateMovement($inventory_movement_type_id, $product_id, $amount);
				$message = __('inventory_movements.Successfully created');
			} catch (\Illuminate\Database\QueryException $e) {
				$status = false;
				$message = $this->getErrorMessage($e, 'inventory_movements');
			}
			$result = $this->getResponse($status, $message, $inventory_movement);
		} else {
			$result = $this->getResponse($canDiscount["status"], $canDiscount["message"]);
		}
		
		return $result;
	}

	
}
