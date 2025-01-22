<?php

namespace App\Http\Controllers;

use App\Models\ConfigClient;
use App\Models\Client;
use App\Models\Selling;
use App\Models\SellingRow;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Product;

use App\Http\Requests\SellingRequest;
use App\DataTables\SellingDataTable;
use Illuminate\Http\Request;

class SellingController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Consultar permiso para botón de agregar
		return (new SellingDataTable())->render('sellings.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$clients = Client::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('sellings.create', compact('clients'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SellingRequest $request)
	{
		$status = true;
		$selling = null;
		$params = array_merge($request->all(), [
			'created_by' => auth()->id(),
			'updated_by' => auth()->id(),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$selling = Selling::create($params);
			$message = __('sellings.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'sellings');
		}
		return $this->getResponse($status, $message, $selling);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Selling  $selling
	 * @return \Illuminate\Http\Response
	 */
	public function show(Selling $selling)
	{
		return view('sellings.show', compact('selling'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Selling  $selling
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Selling $selling)
	{
		$clients = Client::orderBy('name', 'asc')->pluck('name', 'id');
		
		return view('sellings.edit', compact('selling','clients'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Selling  $selling
	 * @return \Illuminate\Http\Response
	 */
	public function update(SellingRequest $request, Selling $selling)
	{
		$status = true;
		$params = array_merge($request->all(), [
			'updated_by' => auth()->id(),
			'updated_at' => date("Y-m-d H:i:s")
		]);
		try {
			$selling->update($params);
			$message = __('sellings.Successfully updated');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'sellings');
		}
		return $this->getResponse($status, $message, $selling);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Selling  $selling
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Selling $selling)
	{
		$status = true;
		try {
			$selling->delete();
			$message = __('sellings.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'sellings');
		}
		return $this->getResponse($status, $message);
	}

	public function getQuickModalContent(Selling $selling = null)
	{
		$params = request("params");
		$clients = Client::orderBy('name', 'asc')->pluck('name', 'id');
		
		return response()->json(view('crud-maker.components.modal-quickadd', compact('params', 'selling','clients'))->render());
	}

	
	
	/**
	 * Insert selling in DB
	 *
	 * @param [Array] $data ["rows" => [], "payments" => []]
	 * @return void
	 */
	public function saveSelling($data)
	{
		$selling = null;
		$status = true;
		$message = "";
		$subtotal = 0;
		$iva = 0;
		//Check inventory
		foreach ($data["rows"] as $row) {
			$canSale = (new InventoryController)->checkMovement(2, $row['product_id'], $row['amount']);

			if (!$canSale["status"]) {
				return $canSale;
			}
		}


		//Calculate row subtotal and IVA
		foreach ($data["rows"] as $row) {
			$p = Product::find($row['product_id']);
			$sub = ($p->price_base * $row['amount']);
			$subtotal += $sub;
			$iva += ($sub * $p->iva) / 100;
			if ($row['ingredients'] ?? false) {
				foreach ($row['ingredients'] as $ingredient) {
					$ing = Product::find($ingredient['product_id']);
					$sub = $ing->overprice * $ingredient['amount'];
					$subtotal += $sub;
					$iva += ($sub * $ing->iva) / 100;
				}
			}
		}
		$total = $subtotal + $iva;

		//Calculate the points the sale generate
		$points = null;
		$toAdd = 0;
		if($data["client_id"] != null) {
			$client = Client::find($data["client_id"]);
			$configClients = ConfigClient::first();

			if ($client != null) {
				//Check if there's no payment with points
				$allow = true;
				foreach ($data["payments"] as $payment) {
					if ($payment['payment_type_id'] != 4) {
						$toAdd += floatval($payment['amount']);
					}
				}

				if ($toAdd > 0) {
					$points = $toAdd * floatval($configClients->refund_percentage);
					$client->points = floatval($client->points) + $points;
					$client->save();
				}
			}
		}
		
		//Save selling
		try {
			$pSelling = array_merge([
				'client_id' => $data["client_id"],
				'points' => $points,
				'subtotal' => $subtotal,
				'iva' => $iva,
				'total' => $total,
			], $this->defaultParams);
			$selling = Selling::create($pSelling);
			$message = __('sellings.Successfully created');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'sellings');
		}

		if ($selling->id != null) {
			$resultRows = $this->saveSellingRows($data["rows"], $selling->id);

			if ($resultRows["status"]) {
				$resultRows = $this->saveSellingPayments($data, $selling->id, $total);
			}
		}

		if (!$resultRows["status"]) {
			$result = $resultRows;
		} else {
			$selling->load("payments.paymentType", "sellingRows.product");
			$result = compact('status', 'message', 'selling');
		}

		return $result;
	}

	public function saveSellingRows($rows, $selling_id, $ingredient = null)
	{
		$result = ["status" => true, "message" => ""];
		foreach ($rows as $row) {
			$p = Product::find($row['product_id']);
			$price = $ingredient == "ingredient" ? $p->overprice : $p->price_base;
			$subtotal = $price * $row['amount'];
			$iva = ($subtotal * $p->iva) / 100;
			$params = array_merge([
				'selling_id' => $selling_id,
				'product_id' => $p->id,
				'parent_product_id' => $row['parent_product_id'] ?? null,
				'description' => $row['pos'] ?? null,
				'amount' => $row['amount'],
				'unit_price' => floatval($price),
				'subtotal' => $subtotal,
				'iva' => $iva,
				'total_price' => $subtotal + $iva,
				'commission_percentage' => $p->supplier->commission_percentage ?? 100,
				'notes' => $ingredient,
			], $this->defaultParams);
			
			try {
				$sellingRow = SellingRow::create($params);
				$resultMovement = (new InventoryMovementController)->addMovement(2, $sellingRow->product_id, $sellingRow->amount);
				$result["message"] = __('selling_rows.Successfully created');
			} catch (\Illuminate\Database\QueryException $e) {
				$result["status"] = false;
				$result["message"] = "Error: ".$p->name;
				$result["message"] = __("sellings.row_save_error", [
					"product" => $p->name,
					"amount" => $row['amount'],
				]);
			}


			if ($row['ingredients'] ?? false) {
				$result = $this->saveSellingRows($row['ingredients'], $selling_id, 'ingredient');
			}
		}

		return $result;
	}

	public function saveSellingPayments($data, $selling_id, $total)
	{
		$result = ["status" => true, "message" => ""];
		$totalPayments = 0;

		//proceso para que si pagó con mucho efectivo no se registre todo en pagos, sino solo el que debía pagar
		//para problemas con los reportes
		foreach ($data["payments"] as $payment) {
			if ($payment['payment_type_id'] !== 1) {
				$totalPayments += $payment['amount'];
			}
		}
		$totalPayments -= $total;
		$totalPayment = 0;

		foreach ($data["payments"] as $payment) {
			$totalPayment = $payment['amount'];
			if ($payment['payment_type_id'] == 1) {
				$payment['amount'] -= $totalPayments;
			}
			$params = array_merge([
				'payment_type_id' => $payment['payment_type_id'],
				'selling_id' => $selling_id,
				'amount' => $payment['amount'],
				'notes' => $totalPayment
			], $this->defaultParams);
			
			try {
				$payment = Payment::create($params);

				//Discount client points if payment type is client dard
				if ($payment != null) {
					if ($payment->payment_type_id == 4) {
						$client = Client::find($data["client_id"]);
						if ($client != null) {
							$client->points = floatval($client->points) - floatval($payment['amount']);
							$client->save();
						}
					}
				}

				$result["message"] = __('selling_rows.Successfully created');
			} catch (\Illuminate\Database\QueryException $e) {
				$result["status"] = false;
				$pT = PaymentType::find($payment['payment_type_id']);
				$result["message"] = __("sellings.payment_save_error", [
					"payment_type" => $pT->name,
					"amount" => $payment['amount'],
				]);
			}
			
		}

		return $result;
	}
}
