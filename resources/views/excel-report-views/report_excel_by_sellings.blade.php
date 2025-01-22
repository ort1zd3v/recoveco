<table>
    <thead>
		<tr colspan='6'>
			@php
				$additionalHeaderText = "CORTE DE TODOS LOS TIEMPOS - ".$additionals['name'] ?? "";
				if ($additionals['initial_date'] != null && $additionals['initial_date'] != null) {
					$additionalHeaderText = "CORTE DEL ".$additionals['initial_date']." AL ".$additionals['final_date']. " - ".$additionals['name'] ?? "";
				}
			@endphp
			<th style="text-align: center" colspan='8'><b>{{$additionalHeaderText}}</b></th>
		</tr>
	</thead>
</table>

@foreach ($data as $supplier)
	<table>
		<thead>
			<tr>
				<th style="border: 1px solid black">Num</th>
				<th style="border: 1px solid black">Recovequero</th>
				<th style="border: 1px solid black">Ticket</th>
				<th style="border: 1px solid black">Fecha</th>
				<th style="border: 1px solid black">Producto</th>
				<th style="border: 1px solid black">Cantidad</th>
				<th style="border: 1px solid black">Precio</th>
				<th style="border: 1px solid black">Precio venta</th>
			</tr>
		</thead>
		<tbody>
			@foreach($supplier->products as $product)
				<tr>
					<td style="border: 1px solid black">{{$product->supplier_id}}</td>
					<td style="border: 1px solid black">{{$product->supplier_name}}</td>
					<td style="border: 1px solid black">{{$product->selling_id}}</td>
					<td style="border: 1px solid black">{{date("d/m/Y H:i:s", strtotime($product->created_at))}}</td>
					<td style="border: 1px solid black">{{$product->product_name}}</td>
					<td style="border: 1px solid black">{{$product->amount}}</td>
					<td style="border: 1px solid black">{{$product->unit_price}}</td>
					<td style="border: 1px solid black">{{$product->total_price}}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5"></td>
				<td style="border: 1px solid black">Total</td>
				<td style="border: 1px solid black"></td>
				<td style="border: 1px solid black">{{$supplier->total}}</td>
			</tr>
			<tr>
				<td colspan="5"></td>
				<td style="border: 1px solid black">{{$supplier->commission_percentage}} %</td>
				<td style="border: 1px solid black"></td>
				<td style="border: 1px solid black">{{$supplier->net_sales}}</td>
			</tr>
			<tr>
				<td colspan="5"></td>
				<td style="border: 1px solid black">Sobre</td>
				<td style="border: 1px solid black"></td>
				<td style="border: 1px solid black">{{$supplier->commissions}}</td>
			</tr>
		</tfoot>
	</table>
@endforeach