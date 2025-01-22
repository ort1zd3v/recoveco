<div class="d-flex justify-content-center">
	<div class="mt-3">
		<table>
			<thead>
				<tr>
					<th>Usuario</th>
					@foreach ($paymentTypes as $pT)
						<th>{{$pT->name}}</th>
					@endforeach
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				@php
					$efectivo = 0;
					$credito = 0;
					$deposito = 0;
				@endphp
				@foreach ($totalPayments as $key => $payments)
					<tr>
						<td>{{$totalPayments[$key][0]->createdBy->name ?? ""}}</td>
						@foreach ($payments as $payment)
							<td class="text-end">${{ number_format($payment->total_amount, 2) }}</td>
							@php
								switch ($payment->id) {
									case 1:
										$efectivo += $payment->total_amount;
										break;
									case 2:
										$credito += $payment->total_amount;
										break;
									case 3:
										$deposito += $payment->total_amount;
										break;
									default:
										break;
								}
							@endphp
						@endforeach
						<td class="text-end">${{ number_format($payments->sum('total_amount'), 2) }}</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td class="text-end"><b>${{ number_format($efectivo, 2)}}</b></td>
					<td class="text-end"><b>${{ number_format($credito, 2)}}</b></td>
					<td class="text-end"><b>${{ number_format($deposito, 2)}}</b></td>
					<td class="text-end"><b>${{ number_format($efectivo + $credito + $deposito, 2)}}</b></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>