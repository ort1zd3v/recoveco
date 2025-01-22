<?php

namespace App\Services;
use App\Models\PaymentType;
use App\Models\Payment;

use Illuminate\Support\Facades\DB;

class PaymentService {
    
	public function getPaymentsBetweenDates($startDate, $endDate)
	{

		$usersSelling = Payment::where('is_active', 1)
			->whereBetween('created_at', [$startDate, $endDate])
			->groupBy('created_by')
			->pluck('created_by')
			->all();

		$totalPaymentsByUsers = [];

		foreach ($usersSelling as $user) {
			$paymentsByUser = PaymentType::where('is_active', 1)->leftJoin(
				DB::raw('(SELECT payment_type_id, SUM(amount) as total_amount
					FROM payments
					WHERE is_active = 1 AND created_at BETWEEN ? AND ?
					AND created_by = ?
					GROUP BY payment_type_id) as subquery'),
				function ($join) {
					$join->on('payment_types.id', '=', 'subquery.payment_type_id');
				}
			)
			->select('payment_types.id', 'payment_types.name', DB::raw('COALESCE(subquery.total_amount, 0) as total_amount'))
			->addBinding([$startDate, $endDate, $user], 'select')
			->get();

			$paymentsByUser->map(function ($item) use ($user) {
				$item->created_by = $user;
				return $item;
			});

			$totalPaymentsByUsers[$user] = $paymentsByUser;
		}

		return $totalPaymentsByUsers;
		
	}


	public function getPaymentsBetweenDatesChart($startDate, $endDate)
	{
		return PaymentType::leftJoin('payments', 'payment_types.id', '=', 'payments.payment_type_id')
		->whereBetween('payments.created_at', [$startDate, $endDate])
		->where('payments.is_active', 1)
		->select('payments.created_by','payment_types.name', DB::raw('COALESCE(SUM(payments.amount), 0) as total_amount'))
		->groupBy('payment_types.name', 'payments.created_by')
		->unionAll(
			PaymentType::select('created_by','name', DB::raw('0 as total_amount'))
			->where('payment_types.is_active', 1)
			->whereNotIn('id', function($query) use ($startDate, $endDate) {
				$query->select('payment_type_id')
					->from('payments')
					->whereBetween('created_at', [$startDate, $endDate]);
			})
		)->get();
	}
}