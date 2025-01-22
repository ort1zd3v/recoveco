<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReportByMonthDataTable;
use App\DataTables\ReportByMonthDetailDataTable;
use App\DataTables\ReportByDayDataTable;
use App\Traits\MonthTrait;
use App\Services\PaymentService;
use App\Models\PaymentType;

class ReportByMonthController extends Controller
{
	use MonthTrait;

    public function index()
	{
		$year = null; //para indicar que todos los años
		return (new ReportByMonthDataTable())->render('reports.report-by-month', compact('year'));
	}

	public function getByDay($year, $month)
	{
		$nameOfMonth = $this->getNameOfMonth($month);
		return (new ReportByDayDataTable($year, $month))->render('reports.report-by-day', compact('year', 'month', 'nameOfMonth'));
	}


	public function getMonthDetail($year, $month)
	{
		$startDate = date($year."-".$month."-01 00:00:00");
		$endDate = date($year."-".$month."-31 23:59:59");
		$nameOfMonth = $this->getNameOfMonth($month);
		$totalPayments = app(PaymentService::class)->getPaymentsBetweenDates($startDate, $endDate);
		$paymentTypes = PaymentType::where('is_active', 1)->get();

		return (new ReportByMonthDetailDataTable($year, $month))->render('reports.report-by-month-detail', compact('paymentTypes','year', 'nameOfMonth', 'totalPayments'));
	}
}
