@extends('crud-maker.layouts.index', [
	'title' => __('products.title_index'), 
	'entity' => 'products', 
	'form' => 'product',
])

@section('datatable')
	<div class="row products-filters mt-2 mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["name" => "supplier_key", "type" => "text", "defaultValue" => old("supplier_key") ?? ""],
				["name" => "supplier_name", "type" => "text", "defaultValue" => old("supplier_name") ?? ""],
				["name" => "product_name", "type" => "text", "defaultValue" => old("product_name") ?? ""],
				[
					"id" => "is_active",
					"name" => "is_active",
					"type" => "select",
					"defaultValue" => old("is_active") ?? 2,
					"elements" => [1 => 'Solo activos', 0 =>'Inactivos', 2 => 'Todos'],
				]
			], 
			"entity" => "products",
			"translations" => "products",
			"type" => "datatable",
		])
	</div>
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection

@push('scripts')
	<script>
		let supplier_key = $('input[name="supplier_key"]');
    	let supplier_name = $('input[name="supplier_name"]');
    	let product_name = $('input[name="product_name"]');
    	let is_active = $('input[name="is_active"]');

		supplier_key.val(localStorage.getItem('supplier_key'));
		supplier_name.val(localStorage.getItem('supplier_name'));
		product_name.val(localStorage.getItem('product_name'));
		is_active.val(localStorage.getItem('is_active'));


		$("#btn-search-products").click(function() {
			localStorage.setItem('supplier_key', supplier_key.val());
    		localStorage.setItem('supplier_name', supplier_name.val());
			localStorage.setItem('product_name', product_name.val());
    		localStorage.setItem('is_active', is_active.val());
		})
		
	</script>
@endpush