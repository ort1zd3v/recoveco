@if ($allIngredients ?? false)
	@foreach ($allIngredients as $item)
		@php $overprice = 0; @endphp
		<tr data-parent-id="{{ $uniqueId }}" data-product-id="{{ $item["product_id"] }}" class="cart-row ingredients">
			<td>
				@php $buttonId = mt_rand(1, 9999999999); @endphp
				<button class='btn btn-primary' data-id="{{$buttonId}}" onclick="editProduct(this, {{$buttonId}})">E</button>
			</td>
			<td></td>
			<td colspan="2">
				<span>{{ $item["product_name"] }}:</span>
				<br>
				<span class="ingredients">
					@lang("pos.ingredients"): 
					<span class="detail-item">
						<input type="hidden" name="product_id" id="product_id" value="{{ $item["product_id"] }}">
						<input type="hidden" name="amount" id="amount" value="{{ $amount }}">
						<input type="hidden" name="parent_product_id" id="parent_product_id" value="{{ $product->id }}">
					</span>
					{{-- All ingredients selected by user --}}
					@foreach ($item["ingredients"] ?? [] as $key => $ingredient)
						@php $overprice += $ingredient['overprice'] * $ingredient['amount'] @endphp
						<span class="detail-item">
							[{{$ingredient['amount']}}] {{ $ingredient["product_name"] }} 
							@if ($ingredient["pos"] ?? false)
								({{ $ingredient["pos"] }})
							@endif
						
							@foreach ($ingredient as $key => $value)
								<input type="hidden" name="{{ $key }}" id="{{ $key }}" value="{{ $value }}">
							@endforeach
							<input type="hidden" name="parent_product_id" id="parent_product_id" value="{{ $item["product_id"] }}">
						</span>
						<span class="detail-separator">,</span>
						
					@endforeach

					{{-- All combo default products --}}
					@if ($item["products"] ?? false)
						@foreach ($item["products"] as $key => $product)
							@php $overprice += $product['overprice'] * $product['amount'] @endphp
							<span class="detail-item">
								[{{$product['amount']}}] {{ $product["product_name"] }}
							</span>
							<span class="detail-separator">,</span>
						@endforeach
					@endif
				</span>
			</td>
			<td class="text-center"></td>
			<input type="hidden" class="total-overprice-input" value="{{ $overprice }}">
			<td class="total-overprice">${{ number_format($overprice, 2) }}</td>
		</tr>
	@endforeach
@endif