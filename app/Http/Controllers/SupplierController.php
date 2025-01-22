<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;

use App\Http\Requests\SupplierRequest;
use App\DataTables\SupplierDataTable;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("suppliers.create");
		$allowEdit = auth()->user()->hasPermissions("suppliers.edit");
		return (new SupplierDataTable())->render('suppliers.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('suppliers.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SupplierRequest $request)
	{
		$status = true;
		$supplier = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$supplier = Supplier::create($params);
			$message = __('suppliers.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'suppliers');
		}
		return $this->getResponse($status, $message, $supplier);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Supplier  $supplier
	 * @return \Illuminate\Http\Response
	 */
	public function show(Supplier $supplier)
	{
		return view('suppliers.show', compact('supplier'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Supplier  $supplier
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Supplier $supplier)
	{
		return view('suppliers.edit', compact('supplier'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Supplier  $supplier
	 * @return \Illuminate\Http\Response
	 */
	public function update(SupplierRequest $request, Supplier $supplier)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$supplier->update($params);
			if ($status) {
				// Actualizar el estatus de todos los productos asociados al proveedor
				Product::where('supplier_id', $supplier->id)->update(['is_active' => $supplier->is_active]);
			}
			$message = __('suppliers.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'suppliers');
		}
		return $this->getResponse($status, $message, $supplier);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Supplier  $supplier
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Supplier $supplier)
	{
		$status = true;
		try {
			$supplier->delete();
			$message = __('suppliers.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'suppliers');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Supplier $supplier = null)
	{
		$params = request("params");
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'supplier'))->render());
	}

	public function getByParam()
	{
		$result = Supplier::getSupplier()->where("name", "like", "%".request("name")."%")->get();
        if($result->isEmpty()) {
            $result = [['value' => 'No se encontraron resultados', 'disabled' => true]]; 
        }
		return response()->json($result, 200);
	}
}
