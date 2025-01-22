<?php

namespace App\Http\Controllers;

use App\Models\UnitType;

use App\Http\Requests\UnitTypeRequest;
use App\DataTables\UnitTypeDataTable;
use Illuminate\Http\Request;

class UnitTypeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("unit_types.create");
		$allowEdit = auth()->user()->hasPermissions("unit_types.edit");
		return (new UnitTypeDataTable())->render('unit-types.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('unit-types.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UnitTypeRequest $request)
	{
		$status = true;
		$unit_type = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$unit_type = UnitType::create($params);
			$message = __('unit_types.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'unit_types');
		}
		return $this->getResponse($status, $message, $unit_type);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\UnitType  $unit_type
	 * @return \Illuminate\Http\Response
	 */
	public function show(UnitType $unit_type)
	{
		return view('unit-types.show', compact('unit_type'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\UnitType  $unit_type
	 * @return \Illuminate\Http\Response
	 */
	public function edit(UnitType $unit_type)
	{
		return view('unit-types.edit', compact('unit_type'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\UnitType  $unit_type
	 * @return \Illuminate\Http\Response
	 */
	public function update(UnitTypeRequest $request, UnitType $unit_type)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$unit_type->update($params);
			$message = __('unit_types.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'unit_types');
		}
		return $this->getResponse($status, $message, $unit_type);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\UnitType  $unit_type
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(UnitType $unit_type)
	{
		$status = true;
		try {
			$unit_type->delete();
			$message = __('unit_types.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'unit_types');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(UnitType $unit_type = null)
	{
		$params = request("params");
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'unit_type'))->render());
	}
}
