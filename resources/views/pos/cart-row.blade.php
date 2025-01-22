@php $uniqueId = strtotime('now'); @endphp
<tr data-id="{{ $product->id }}" data-unique-id="{{ $uniqueId }}" data-product='{{ base64_encode(json_encode($product)) }}' class="cart-row">
	<td><a class='btn btn-danger' onclick="deleteProduct(this)">X</a></td>
	<td>
		{{ $product->supplier->id ?? 'N/A' }}
	</td>
	<td>
		{{ $product->name }}
	</td>
	<td>
		<div class="input-group">
			<div class="input-group-prepend">
				<a class="btn button-add" onclick="decreaseAmount(this)">-</a>
			</div>
			<input type="number" class="form-control amount text-center" min="1" max="100" value="{{ $amount }}">
			<div class="input-group-append">
				<a class="btn button-add" onclick="increaseAmount(this)">+</a>
			</div>
		</div>
	</td>
	<td class="price text-end">
		<input type="hidden" value="{{$product->price_base}}">
		<span>${{ number_format($product->price_base,2) }}</span>
	</td>
	<td class="subtotal text-end"> 
		<input type="hidden" value="{{$product->price_base * $amount}}">
		<span>${{ number_format($product->price_base * $amount, 2) }}</span>
	</td>
</tr>

@include('pos.cart-row-ingredients', compact('product', 'uniqueId', 'allIngredients'))