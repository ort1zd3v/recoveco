<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReportByYearDataTable;
use App\DataTables\ReportByMonthDataTable;
use App\DataTables\ReportByYearDetailDataTable;
use App\Services\PaymentService;
use App\Models\PaymentType;

class ReportByYearController extends Controller
{
    public function index()
	{
		return (new ReportByYearDataTable())->render('reports.report-by-year');
	}
	
	public function getByMonth($year)
	{
		return (new ReportByMonthDataTable($year))->render('reports.report-by-month', compact('year'));
	}

	public function getYearDetail($year)
	{
		$startDate = date($year."-01-01 00:00:00");
		$endDate = date($year."-12-31 23:59:59");
		$totalPayments = app(PaymentService::class)->getPaymentsBetweenDates($startDate, $endDate);
		$paymentTypes = PaymentType::where('is_active', 1)->get();

		return (new ReportByYearDetailDataTable($year))->render('reports.report-by-year-detail', compact('paymentTypes','year', 'totalPayments'));
	}
}
