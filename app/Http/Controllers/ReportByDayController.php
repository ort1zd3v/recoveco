<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReportByDayDataTable;
use App\DataTables\ReportByDayDetailDataTable;
use App\Traits\MonthTrait;
use App\Services\PaymentService;
use App\Models\PaymentType;

class ReportByDayController extends Controller
{
	use MonthTrait;

    public function index()
	{
		$year = null; //para indicar que todos los años
		return (new ReportByDayDataTable())->render('reports.report-by-day', compact('year'));
	}

	public function getByDayDetail($year, $month, $day)
	{
		$startDate = date($year."-".$month."-".$day." 00:00:00");
		$endDate = date($year."-".$month."-".$day." 23:59:59");
		$nameOfMonth = $this->getNameOfMonth($month);
		$totalPayments = app(PaymentService::class)->getPaymentsBetweenDates($startDate, $endDate);
		$paymentTypes = PaymentType::where('is_active', 1)->get();
		return (new ReportByDayDetailDataTable($startDate, $endDate))->render('reports.report-day-detail', compact('paymentTypes','totalPayments', 'year','month', 'nameOfMonth', 'day'));
	}
}
