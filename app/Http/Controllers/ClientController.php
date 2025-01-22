<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client;
use App\Models\ClientAttribute;
use App\Models\ClientValue;

use App\Http\Requests\ClientRequest;
use App\DataTables\ClientDataTable;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		$allowAdd = auth()->user()->hasPermissions("clients.create");
		$allowEdit = auth()->user()->hasPermissions("clients.edit");
		return (new ClientDataTable())->render('clients.index', compact('allowAdd', 'allowEdit'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$branches = Branch::orderBy('name', 'asc')->pluck('name', 'id');
		$dynamicAttributes = ClientAttribute::all();
		
		return view('clients.create', compact('branches', 'dynamicAttributes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ClientRequest $request)
	{
		$status = true;
		$client = null;
		$params = array_merge($request->all(), [
			'client_number' => $this->calculateClientNumber($request->all()),
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$client = Client::create($params);
			// $this->updateOrCreateClientValues($dynamics, $defaults, $client);
			$message = __('clients.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'clients');
		}
		return $this->getResponse($status, $message, $client);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function show(Client $client)
	{
		return view('clients.show', compact('client'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Client $client)
	{
		$branches = Branch::orderBy('name', 'asc')->pluck('name', 'id');
		$dynamicAttributes = ClientAttribute::all();
		$clientAttributes = $client->clientValues->pluck('value', 'client_attribute_id');
		
		return view('clients.edit', compact('client','branches', 'dynamicAttributes', 'clientAttributes'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function update(ClientRequest $request, Client $client)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$client->update($params);
			// $this->updateOrCreateClientValues($dynamics, $defaults, $client);

			$message = __('clients.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'clients');
		}
		return $this->getResponse($status, $message, $client);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Client  $client
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Client $client)
	{
		$status = true;
		try {
			$client->delete();
			$message = __('clients.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'clients');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Client $client = null)
	{
		$params = request("params");
		$branches = Branch::orderBy('name', 'asc')->pluck('name', 'id');
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'client','branches'))->render());
	}

	public function getByParam()
	{
		$query = Client::select(
			'clients.id as id', 
			DB::raw("CONCAT(clients.name, ', ', clients.client_number) as value"),
			'clients.points as points'
		);
		$filters = request()->all();
		unset($filters["type"]);
		$result = $this->filter($query, $filters);
		//dd($result->toSql());
		$result = $result->orderBy('value', 'asc')->limit(10)->get();
		return response()->json($result, 200);
	}

	private function calculateClientNumber($data)
	{
		$lastClient = Client::orderBy("id", "DESC")->first();
		$lastId = $lastClient != NULL ? (floatval($lastClient->id) + 1) : 1;
		return str_pad(request('branch_id'), 3, "0", STR_PAD_LEFT).str_pad($lastId, 6, "0", STR_PAD_LEFT);
	}

	private function updateOrCreateClientValues($dynamics, $defaults, $client)
	{
		if($dynamics ?? false){
			//Filtrar arreglo con valores null
			$nullIds = array_keys(array_filter($dynamics, 'is_null'));
			
			//Filtrar arreglo sin valores null
			$values = array_filter($dynamics);
			
			//Eliminar registros de la tabla client_values si el valor es null
			$clientValues = ClientValue::where("client_id", $client->id)
			->whereIn("client_attribute_id", $nullIds)
			->pluck('id')->toArray();
			ClientValue::destroy($clientValues);
			
			//Si existen valores a modificar, crear o actualizar el registro
			//en la tabla de client_values
			if(count($values) > 0){
				foreach ($values as $key => $value) {
					$dynamicValue = array_merge(["value" => $value], $defaults);
					ClientValue::updateOrCreate(
						["client_id" => $client->id, "client_attribute_id" => $key],
						$dynamicValue
					);	
				}
			}
		}
	}
}
