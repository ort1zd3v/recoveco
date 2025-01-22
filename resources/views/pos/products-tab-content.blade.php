<div class="productsGrid p-2 bg-white tab-pane pane-products {{ ($active ?? false) ? 'active' : '' }}" id="{{ str_replace(" ", '-', $name) }}" 
	role="tabpanel" aria-labelledby="{{ str_replace(" ", '-', $name) }}-tab">
	{{-- Display grid --}}
	@if ($isGrid ?? false)
		@foreach ($products->sortBy('print_order') as $product)
			@include('pos.products-item-grid', [
				'product' => $product,
				'displayImage' => in_array($configProducts->type_box, ["both", "icons"]) ? true : false,
				'displayName' => $configProducts->type_box == "icons" ? false : true,
				'onclick' => "selectProduct(this,'".base64_encode(json_encode($product))."', 
					".json_encode($product->hasIngredients()).")",
				'cols' => $configProducts->num_cols ?? 0,
				"hasKeyboard" => $configProducts->with_keyboard
			]) 
		@endforeach
	@else
		<input id="with_inventory" type="checkbox" name="with_inventory" checked>
		<label for="with_inventory">Mostrar solo con inventario</label>

		{{-- {!! $productsDT->table(['width' => '100%']) !!} --}}
		<table id="pos-products-table" class="table dataTable no-footer">
			<thead>
				<th style="width: 25%">Clave</th>
				<th style="width: 10%">C.</th>
				<th style="width: 45%">Nombre</th>
				<th style="width: 20%">Precio</th>
			</thead>
			<tbody id="pos-products-table-body">
			</tbody>
		</table>

		<div id="message-search-scan" class="d-flex justify-content-center align-items-center h-100">
			<p class="font-size-24" style="color: gray">Favor de buscar o escanear</p>
		</div>
	@endif
		
</div>