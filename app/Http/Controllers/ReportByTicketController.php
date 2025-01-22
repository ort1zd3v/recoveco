<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReportByTicketDataTable;
use App\DataTables\ReportByTicketDetailDataTable;
use App\Models\Selling;
use App\Models\SellingRow;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use App\Models\ConfigTicket;

use App\Models\InventoryMovement;

class ReportByTicketController extends Controller
{
    public function index()
	{
		$paymentTypes = PaymentType::where('is_active', 1)->pluck('name', 'id');
		$paymentTypes->prepend("Todos", 0);

		$users = User::pluck('name', 'id');
		$users->prepend("Todos", 0);
		return (new ReportByTicketDataTable())->render('reports.report-by-ticket', compact('paymentTypes', 'users'));
	}

	public function getTicketDetail($selling_id)
	{
		return (new ReportByTicketDetailDataTable($selling_id))->render('reports.report-by-ticket-detail');
	}

	public function cancelSelling(Selling $selling)
	{
		$status = true;
		try {
			$selling->is_active = 0;
			$selling->save();
			foreach ($selling->sellingRows as $sellingRow) {
				InventoryMovement::create([
					'product_id' => $sellingRow->product_id,
					'inventory_movement_type_id' => 4,
					'amount' => $sellingRow->amount,
					'created_by' => auth()->id(),
					'updated_by' => auth()->id(),
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s")
				]);
				(new InventoryController)->updateMovement(4, $sellingRow->product_id, $sellingRow->amount);
			}
			

			SellingRow::where('selling_id', $selling->id)->update(['is_active' => 0]);
			Payment::where('selling_id', $selling->id)->update(['is_active' => 0]);

			$message = __('sellings.Successfully deleted');
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'sellings');
		}
		return $this->getResponse($status, $message);

	}

	public function getTicket(Selling $selling)
	{
		$config_ticket = ConfigTicket::first();
		$user = $selling->createdBy;
		return view('config-tickets.ticket', compact('config_ticket', 'user', 'selling'))->render();
	}
}
