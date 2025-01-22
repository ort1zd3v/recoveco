<?php

namespace App\Http\Controllers;

use App\Models\StartingFound;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Services\PaymentService;

use App\Models\Product;
use App\Models\SellingRow;
use App\Models\Selling;
use App\Models\ConfigTicket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StartingFoundRequest;
use App\DataTables\StartingFoundDataTable;
use Illuminate\Http\Request;

class StartingFoundController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return (new StartingFoundDataTable())->render('starting-founds.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('starting-founds.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$status = true;
		$starting_found = null;
		$params = [
			"amount" => $request->amount,
			"initial_date" => now(),
			"final_date" => null,
			"initial_user_id" => $request->initial_user_id,
			"final_user_id" => null,
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		];
		try {
			$starting_found = StartingFound::create($params);
			$message = __('starting_founds.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'starting_founds');
		}
		return redirect('pos');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\StartingFound  $starting_found
	 * @return \Illuminate\Http\Response
	 */
	public function show(StartingFound $starting_found)
	{
		$startDate = date('Y-m-d H:i:s', strtotime($starting_found->initial_date));
		$endDate = date('Y-m-d H:i:s', strtotime($starting_found->final_date));
		if ($starting_found->final_date == null) {
			$endDate = date('Y-m-d 23:59:59', strtotime($starting_found->initial_date));
		}
		
		$totalPayments = app(PaymentService::class)->getPaymentsBetweenDates($startDate, $endDate);
		$paymentTypes = PaymentType::where('is_active', 1)->get();

		$sellingProducts = SellingRow::whereBetween('created_at', [$startDate, $endDate])
		->selectRaw('product_id, SUM(amount) as total_amount, sum(total_price) as total_product_amount, commission_percentage')
		->where('total_price', '<>', 0)
		->where('is_active', 1)
		->orderBy('total_product_amount', 'desc')
		->groupBy('product_id', 'commission_percentage')
		->get();

		$configTicket = ConfigTicket::first();
		$user = User::find(auth()->id());
		$users = User::orderBy('name', 'asc')->pluck('name', 'id');

		return view('starting-founds.show', compact('paymentTypes','starting_found', 'totalPayments', 'sellingProducts', 'configTicket', 'user', 'users'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\StartingFound  $starting_found
	 * @return \Illuminate\Http\Response
	 */
	public function edit(StartingFound $starting_found)
	{
		return view('starting-founds.edit', compact('starting_found'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\StartingFound  $starting_found
	 * @return \Illuminate\Http\Response
	 */
	public function update(StartingFoundRequest $request, StartingFound $starting_found)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$starting_found->update($params);
			$message = __('starting_founds.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'starting_founds');
		}
		return $this->getResponse($status, $message, $starting_found);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\StartingFound  $starting_found
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(StartingFound $starting_found)
	{
		$status = true;
		try {
			$starting_found->delete();
			$message = __('starting_founds.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'starting_founds');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(StartingFound $starting_found = null)
	{
		$params = request("params");
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'starting_found'))->render());
	}


	public function closeDay(Request $request, StartingFound $starting_found)
	{
		$fechaActual = now()->toDateString();
		$existeFechaActual = StartingFound::whereDate('initial_date', $fechaActual)->exists();
		if ($existeFechaActual) {
			$closeDate = date('Y-m-d H:i:s', strtotime(now()));
		}else{
			$closeDate = date('Y-m-d 23:59:59', strtotime($starting_found->initial_date));
		}

		$starting_found->update(['final_date' => $closeDate, 'final_user_id' => $request->final_user_id]);

		$data = ($this->getTicket($starting_found->id));
		$result = $this->getResponse("200", "Ok", $data);

		return $result;
	}

	public function showCloseDay() {
		$day = StartingFound::orderBy('id', 'desc')->first();
		return view('starting-founds.close', compact('day'));
	}

	public function showInitDay() {
		$users = User::orderBy('name', 'asc')->pluck('name', 'id');
		return view('starting-founds.create', compact('users'));
	}

	public function getTicket($starting_found)
	{
		$config_ticket = ConfigTicket::first();
		$user = User::find(auth()->id());
		$starting_found = StartingFound::find($starting_found);
		$startDate = date('Y-m-d H:i:s', strtotime($starting_found->initial_date));
		$endDate = date('Y-m-d H:i:s', strtotime($starting_found->final_date));
		if ($starting_found->final_date == null) {
			$endDate = date('Y-m-d 23:59:59', strtotime($starting_found->initial_date));
		}

		$totalPayments = app(PaymentService::class)->getPaymentsBetweenDates($startDate, $endDate);
		$paymentTypes = PaymentType::where('is_active', 1)->get();


		return view('config-tickets.ticket_close_day', compact('config_ticket', 'user', 'starting_found', 'totalPayments', 'paymentTypes'))->render();
	}

}
