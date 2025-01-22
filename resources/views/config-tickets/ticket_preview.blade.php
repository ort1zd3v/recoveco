<div class="card p-3">
	<div>
		<img class="logo mx-auto d-block" src="{{$config_ticket->url_logo}}" alt="">
	</div>
	<br>
	<div class="header">
		{{-- <p>Raspados y Helados de Yogurth</p>
		<p>Av. Tauro 205 Local 1 Nueva Linda Vista</p>
		<p>Guadalupe, Nuevo León</p>
		<p>CP 00000</p>
		<p>RFC 123123123123</p> --}}
		{!! $config_ticket->header !!}
	</div>
	<h3 id="ticket-number" class="text-center mt-2 mb-2">Ticket: X</h3>
	<div class="text-center">
		<p>Atendió: {{$user->name}}</p>
		<p>Fecha: {{date("d/m/Y h:i A")}}</p>
	</div>
	
	<br>
	<div class="w-100">
		<table id="table-ticket">
			<thead>
				<th>N.R</th>
				<th>Descipción</th>
				<th class="text-center">Cantidad</th>
				<th class="text-end">Importe</th>
			</thead>
			<tbody>
				<tr>
					<td>32</td>
					<td>Agua 600ml</td>
					<td class="text-center">1</td>
					<td class="text-end">$10.00</td>
				</tr>
				<tr>
					<td>33</td>
					<td>Agua 1L</td>
					<td class="text-center">1</td>
					<td class="text-end">$14.00</td>
				</tr>
			</tbody>
		</table>
	</div>
	<br>
	<div class="d-flex justify-content-between" id="info-payment">
		<div>
			<p>Total:</p>
			<p>Pago en efectivo:</p>
			<p>Cambio:</p>
		</div>
		<div>
			<p>$24.00</p>
			<p>$50.00</p>
			<p>$26.00</p>
		</div>
	</div>
	
	<div class="text-center mt-1">
		{{-- <p>¡Gracias, vuelve pronto!</p>
		<p>Regístrate en:</p>
		<p>www.gelow.com.mx</p> --}}
		{!! $config_ticket->footer !!}
	</div>
	
	<hr class="m-1 p-0" style="border: 1px solid black">
	<div class="text-center">
		{{-- <p>Gelow</p> --}}
		{!! $config_ticket->footer2 !!}
	</div>
</div>

<style>

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

</style>