<div style="height: 60vh; overflow: hidden" class="tab-pane pane-products {{ ($active ?? false) ? 'active' : '' }} {{($selected ?? false) ? 'selected' : ''}}" 
	id="{{ "ingredient-".$ingredient->id }}" 
	role="tabpanel">
	
	<hr><h3 style="margin: 1rem">@lang('pos.select_from_category'): {{ $ingredient->category->name }}</h3><hr>
	<input type="hidden" class="id" value="{{ $ingredient->id }}">
	<input type="hidden" class="category_id" value="{{ $ingredient->category->id }}">
	<input type="hidden" class="amount" value="{{ $ingredient->amount }}">
	{{-- Display grid --}}

	@php $active = true; @endphp
	<div id="carousel{{ "ingredient-".$ingredient->id }}" class="carousel slide h-100" data-bs-ride="carousel">
		<div class="carousel-inner">
			@foreach ($products as $key => $page)
				<div class="carousel-item {{ $active ? 'active' : null }}">
					<div class="p-2 bg-white productsGrid" style="margin-left: 60px; margin-right: 60px">
						@foreach ($page as $key => $product)
							@include('pos.products-item-grid', [
								'product' => $product,
								'displayImage' => in_array($configProducts->type_box, ["both", "icons"]) ? true : false,
								'displayName' => $configProducts->type_box == "icons" ? false : true,
								'onclick' => "selectIngredient(this, '".base64_encode(json_encode($product))."')",
								'cols' => 6
							])
						@endforeach
					</div>
				</div>
				@php $active = false; @endphp
			@endforeach
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ "ingredient-".$ingredient->id }}" data-bs-slide="prev" style="width: 0px">
			<span style="background-color: rgb({{$template->datatables_header_backround_color}}); position: absolute; left: 0; top: -16px; width: 55px; height: 90%" class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carousel{{ "ingredient-".$ingredient->id }}" data-bs-slide="next" style="width: 0px">
			<span style="background-color: rgb({{$template->datatables_header_backround_color}}); position: absolute; right: 0; top: -16px; width: 55px; height: 90%" class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>

	
</div>