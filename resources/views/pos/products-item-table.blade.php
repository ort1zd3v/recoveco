<tr class="product-table-row" data-id="{{ $product->id }}" 
	onclick="selectProduct(this,'{{ base64_encode(json_encode($product)) }}', {{ json_encode($product->hasIngredients()) }})"
	style="cursor: pointer">
	<td>{{ $product->id }}</td>
	<td>{{ $product->supplier->id ?? 'N/A' }} - {{ $product->barcode }}</td>
	<td>{{ $product->name }} ({{ $product->inventories[0]->amount ?? 0 }})</td>
	<td>${{ number_format($product->price_base, 2, '.', ',') }}</td>
</tr>