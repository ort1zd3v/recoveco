<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReportByPaymentTypeDataTable;
use App\Services\PaymentService;
use App\Models\Payment;

class ReportByPaymentTypeController extends Controller
{

    public function index()
	{

		return (new ReportByPaymentTypeDataTable())->render('reports.report-by-payment-type');
	}
	
	public function getChart()
	{

		$initial_date = request()->initial_date == null ? '1900-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime(request()->initial_date));
		$final_date = request()->final_date == null ? '2099-01-01 23:59:38' : date('Y-m-d 23:59:59', strtotime(request()->final_date));

		$payments = (app(PaymentService::class)->getPaymentsBetweenDatesChart($initial_date, $final_date));

		$chartValues = $payments->map(function ($payment) {
			return [
				'user' => $payment->createdBy->name ?? "Default",
				'name' => $payment->name,
				'value' => round($payment->total_amount, 2),
			];
            
        })->toArray();

		return $chartValues;
	}
}
