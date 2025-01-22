<div class="card p-3 ticketInfo">
	<div>
		<img class="logo mx-auto d-block" src="{{$config_ticket->url_logo}}" alt="">
	</div>
	<br>
	<div class="header">
		{!! $config_ticket->header !!}
	</div>
	<div class="text-center">
		<p>@lang('sellings.cashier_name'): {{ $user->name }}</p>
		<p>@lang('sellings.ticket_date'): {{ date("d/m/Y h:i A") }}</p>
	</div>
	<br><br>
	
	<p>Fecha de inicio: {{date('d F Y H:i:s', strtotime($starting_found->initial_date))}}</p>
	<p>Fecha de cierre: {{date('d F Y H:i:s', strtotime(now()))}}</p>
	<p>Inició: {{$starting_found->initialUser->name}}</p>
	<p>Cerró: {{$starting_found->finalUser->name}}</p>

	<br><br><hr>
	<div class="row font-size-16">
		<div class="d-flex gap-2">
			<p>@lang('starting_founds.starting_found')</p>
			<p class="text-success"><b>${{number_format($starting_found->amount, 2)}}</b></p>
		</div>
		
		@include('reports.table-sellings-users')

		@php
			$total = $starting_found->amount;
		@endphp
		@foreach ($totalPayments as $key => $payments)
			@php
				$total += $payments->sum('total_amount')
			@endphp
		@endforeach
		<p class="mt-2">Total con fondo de caja: <b>${{number_format($total,2)}}</b></p>
	</div>

	<br><br>
	<div class="text-center">
		{!! $config_ticket->footer !!}
	</div>
	
	<hr class="m-1 p-0" style="border: 1px solid black">
	<div class="text-center">
		{!! $config_ticket->footer2 !!}
	</div>
</div>

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