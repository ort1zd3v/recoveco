<?php

namespace App\Http\Controllers;

use App\Models\ConfigTicket;
use App\Models\User;

use App\Http\Requests\ConfigTicketRequest;
use App\DataTables\ConfigTicketDataTable;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

class ConfigTicketController extends Controller
{
	use UploadTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$config_ticket = ConfigTicket::first();
		$user = User::find(auth()->id());
		return view('config-tickets.index', compact('config_ticket', 'user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ConfigTicket  $config_ticket
	 * @return \Illuminate\Http\Response
	 */
	public function update(ConfigTicketRequest $request, ConfigTicket $config_ticket)
	{
		$status = true;
		$path = null;
		if(array_key_exists('url_logo', $request->all())){
			$path = $this->uploadFile($request->all()['url_logo'], 'images/logos');
		}

		if ($path !== null) {
			$params = array_merge($request->all(), [
				'url_logo' => $path,
				'updated_by' => auth()->id(),
				'updated_at' => date("Y-m-d H:i:s")
			]);
		}else{
			$params = array_merge($request->all(), [
				'updated_by' => auth()->id(),
				'updated_at' => date("Y-m-d H:i:s")
			]);
		}

		try {
			$config_ticket->update($params);
			$message = __('config_tickets.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'config_tickets');
		}
		return $this->getResponse($status, $message, $config_ticket);
	}
	
}
