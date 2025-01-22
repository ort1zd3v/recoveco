
<table>
    <tbody>
        @foreach($data as $supplier)
            <tr>
                <td>
                    <table>
                        <thead>
							<tr colspan='6'>
								@php
									$additionalHeaderText = "Todos los tiempos - ".$additionals['name'] ?? "";
									if ($additionals['initial_date'] != null && $additionals['initial_date'] != null) {
										$additionalHeaderText = "Desde ".$additionals['initial_date']." hasta ".$additionals['final_date']. " - ".$additionals['name'] ?? "";
									}
								@endphp
								<th style="text-align: center" colspan='6'><b>{{ $supplier->supplier_name }} - {{$additionalHeaderText}}</b></th>
							</tr>
                            <tr>
                                <th><b>Producto</b></th>
                                <th><b>Cantidad</b></th>
								<th><b>Importe</b></th>
                                <th><b>% Recoveco</b></th>
                                <th></th>
                                <th><b>Sobre</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplier->products as $product)
                                <tr>
                                    <td style="border: 1px solid black">{{ $product->product_id }}</td>
                                    <td style="border: 1px solid black">{{ $product->total_amount }}</td>
									<td style="border: 1px solid black">{{ $product->total_product_amount }}</td>
                                    <td style="border: 1px solid black">{{ $product->commission_percentage / 100 }}</td>
									<td style="border: 1px solid black">{{ $product->commission }}</td>
									<td style="border: 1px solid black">{{ $product->commission2 }}</td>
                                </tr>
                            @endforeach
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td style="text-align: end"><b>{{ $supplier->commissions }}</b></td>
							</tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>