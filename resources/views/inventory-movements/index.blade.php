@extends('crud-maker.layouts.index', [
	'title' => __('inventory_movements.title_index'), 
	'entity' => 'inventory_movements', 
	'form' => 'inventoryMovement',
])

@section('datatable')

<div class="row inventory_movements-filters mt-2 mb-3">
	@include('crud-maker.components.filters', [
		"rows" => [
			["id" => "initial_date", "name" => "initial_date", "type" => "date"],
			["id" => "final_date", "name" => "final_date", "type" => "date"],
			[
				"id" => "inventory_movement_type_id",
				"name" => "inventory_movement_type_id",
				"type" => "select",
				"defaultValue" => old("inventory_movement_type_id") ?? 0,
				"elements" => $inventoryMovementTypes ?? [],
			],

			["id" => "supplier_name", "name" => "supplier_name", "type" => "text"],
			["id" => "product_name", "name" => "product_name", "type" => "text"],
			["id" => "barcode", "name" => "barcode", "type" => "text"],

		], 
		"entity" => "inventory_movements",
		"translations" => "inventory_movements",
		"type" => "datatable",
	])
</div>
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection