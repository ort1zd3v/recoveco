<style>
	body * {
		color: black;
	}
	table {
		width: 100%;
	}

	th {
		border-top: 1px solid black;	
		border-bottom: 1px solid black;
		padding: 4px;
		font-size: 12px;
	}

	td {
		padding: 2px;
		font-size: 12px;
		border-bottom: none;
	}

	.logo {
		max-width: 100px;
		width: 40%;
	}

	.header {
		text-align: center;
	}

	h1,h2,h3,h4,h5,h6,p{
		margin: 0px;
		padding: 0px;
	}

	.ticket-prod {
		margin-top: 2px;
		border-bottom: 1px solid black;
	}

</style>

<div class="card p-3 ticketInfo">
	<div>
		<img class="logo mx-auto d-block" src="{{$config_ticket->url_logo}}" alt="">
	</div>
	<br>
	<div class="header">
		{!! $config_ticket->header !!}
	</div>
	<h3 id="ticket-number" class="text-center mt-2 mb-2">
		@lang('sellings.ticket_number'): {{ $selling->id }}
	</h3>
	<div class="text-center">
		<p>@lang('sellings.cashier_name'): {{ $user->name }}</p>
		<p>@lang('sellings.ticket_date'): {{ date("d/m/Y h:i A") }}</p>
	</div>
	
	<br>
	<div class="w-100">
		<table id="table-ticket">
			<thead>
				<th>@lang('sellings.nr')</th>
				<th>@lang('sellings.description')</th>
				<th class="text-center">Qty.</th>
				<th class="text-end">@lang('sellings.total_ticket')</th>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				
				@foreach($selling->sellingRows as $row)
					<tr class="ticket-ingredient {{$row->parent_product_id == null ? 'fw-bold' : ''}}">
						@if($row->parent_product_id == null)
							@php $count = 1; @endphp
						@endif
						@if ($row->parent_product_id != null && $row->description == null)
							<td class="ticket-prod">
								{{ $row->product->supplier->id ?? 'N/A' }}
							</td>
							<td colspan="3" class="ticket-prod">
								<span>
									{{ $count }}.
								</span>
								<span>
									{{ ($row->description != null ? "(".$row->description.")" : '') }}
								</span> 
								<span>{{ $row->product->name }}</span> 
								@php $count++; @endphp
							</td>
						@else
							<td>
								{{ $row->product->supplier->id ?? 'N/A' }}
							</td>
							<td>
								<span>
									{{ ($row->description != null ? "(".$row->description.")" : '') }}
								</span> 
								<span>{{ $row->product->name }}</span> 
							</td>
							<td class="text-center">{{ $row->amount }}</td>
							<td class="text-end">
								${{ number_format($row->unit_price * $row->amount, 2) }}
							</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<br>
	<div class="d-flex justify-content-between" id="info-payment">
		<div>
			<p>@lang('sellings.total'):</p>
			@foreach($selling->payments as $payment)
				<p>@lang('sellings.payment_type') {{$payment->paymentType->name}}:</p>
			@endforeach
			<p>@lang('sellings.change'):</p>
		</div>
		<div class="text-end">
			<p>${{number_format($selling->total, 2)}}</p>
			@php $total_payments = 0; @endphp
			@foreach($selling->payments as $payment)
				<p>${{number_format($payment->notes, 2)}}</p>
				@php $total_payments += $payment->notes; @endphp
			@endforeach
			<p>${{number_format($total_payments - $selling->total, 2)}}</p>
		</div>
	</div>

	{{-- points --}}
	@if ($selling->client_id != null)
		<br>
		<div class="d-flex justify-content-between">
			<p>@lang('sellings.total_points'):</p>
			<p>{{$selling->client->points}}</p>
		</div>
	@endif
	
	
	<br><br>
	
	<div class="text-center">
		{!! $config_ticket->footer !!}
	</div>
	
	<hr class="m-1 p-0" style="border: 1px solid black">
	<div class="text-center">
		{!! $config_ticket->footer2 !!}
	</div>
</div>
