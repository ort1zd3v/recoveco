@if ($configProducts->with_filters)
	<div class="d-flex mb-1"> 
		<div class="w-100">
			<div class="input-group">
				<input id="filter" type="text" class="form-control" placeholder="Buscar por código de barras o nombre">
				<div class="input-group-append">
					<button type="button" class="btn btn-danger" id="btnClearSearch">
						<i class="mdi mdi-close"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="ms-2 text-end">
			<button class="btn btn-primary" id="btnSearch">Buscar</button>
		</div>
	</div>
@endif


{{-- @if ($configProducts->with_tabs) --}}
{{-- Tabs --}}
<ul class="nav nav-tabs mb-1" id="myTab" role="tablist">
	{{-- @foreach ($categories as $category)
		@include('pos.products-tab-header', ["name" => $category->name])
	@endforeach --}}
	@include('pos.products-tab-header', ["name" => "Todos"])
</ul>


<input type="hidden" id="selected_product">
{{-- Tab content --}}
<div class="tab-content">
	@include('pos.products-tab-content', [
		"name" => "Todos", 
		"products" => $allProducts,
		"data" => compact('configProducts', 'template'),
		"isGrid" => $configProducts->with_tabs,
	])

	{{-- @foreach ($categories as $category)
		@include('pos.products-tab-content', [
			"name" => $category->name, 
			"products" => $category->products,
			"data" => compact('configProducts', 'template'),
			"isGrid" => $configProducts->with_tabs,
		])
	@endforeach --}}
</div>

{{-- Numeric keyboard --}}
<div class="container mb-2 mt-2">
	<div class="d-flex gap-2 align-items-center">
		<label class="mb-0" for="qty">Cantidad</label>
		<input type="number" class="form-control" id="amount" name="qty" min="0">
	</div>
</div>

@if($configProducts->with_keyboard)
	@include('pos.keyboard', ["target" => "#amount"])
@endif


@push('styles')
	<style>
		#products-table_filter {
			display: none;
		}
		@if (!$configProducts->with_keyboard)
			.pane-products{
				height: 75vh;
			}
			#product-table-option{
				height: 73vh !important;
			}
		@endif
	</style>
@endpush


