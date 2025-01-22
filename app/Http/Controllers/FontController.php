<?php

namespace App\Http\Controllers;

use App\Models\Font;

use App\Http\Requests\FontRequest;
use App\DataTables\FontDataTable;
use Illuminate\Http\Request;

class FontController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("fonts.create");
		$allowEdit = auth()->user()->hasPermissions("fonts.edit");
		return (new FontDataTable())->render('fonts.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('fonts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(FontRequest $request)
	{
		$status = true;
		$font = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$font = Font::create($params);
			$message = __('fonts.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'fonts');
		}
		return $this->getResponse($status, $message, $font);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Font  $font
	 * @return \Illuminate\Http\Response
	 */
	public function show(Font $font)
	{
		return view('fonts.show', compact('font'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Font  $font
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Font $font)
	{
		return view('fonts.edit', compact('font'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Font  $font
	 * @return \Illuminate\Http\Response
	 */
	public function update(FontRequest $request, Font $font)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$font->update($params);
			$message = __('fonts.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'fonts');
		}
		return $this->getResponse($status, $message, $font);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Font  $font
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Font $font)
	{
		$status = true;
		try {
			$font->delete();
			$message = __('fonts.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'fonts');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Font $font = null)
	{
		$params = request("params");
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'font'))->render());
	}
}
