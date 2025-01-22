{{-- @include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "product_id",
		"id" => "product_id",
		"class" => "form-select",
		"entity" => "inventory_movements",
		"type" => "select",
		"defaultValue" => old("product_id") ?? ($inventory_movement->product_id ?? ""),
		"required" => "true",
		"elements" => $products ?? [],
	]
]]) --}}
@include("crud-maker.components.form-row", ["params" => [
			[
				'name' => 'search_input',
				'id' => 'search_input',
				'class' => 'form-control input-autocomplete remove-searchx',
				'entity' => 'suppliers',
				'type' => 'input-autocomplete',
				'data-source' => 'suppliers/getbyparam',
				'data-hidden-id' => 'supplier_id',
				'data-hidden-value' => isset($supplier) ? $supplier->id ?? null : "",
				'data-hidden-name' => 'supplier_id',
				'translations' => 'suppliers.search',
				'data-filter' => 'name',
				"inputType" => 1,
				"label" => false,
				"defaultValue" => isset($supplier) ? $supplier->name ?? null : "",
			],
		]])

@include("crud-maker.components.form-row", ["params" => [
			[
				'name' => 'search_input',
				'id' => 'search_input',
				'class' => 'form-control input-autocomplete remove-searchx',
				'entity' => 'products',
				'type' => 'input-autocomplete',
				'data-source' => 'products/getbyparam',
				'data-hidden-id' => 'product_id',
				'data-hidden-value' => isset($product) ? $product->id ?? null : "",
				'data-hidden-name' => 'product_id',
				'data-parent' => 'supplier_id',
				'translations' => 'products.search',
				'data-filter' => 'name',
				"inputType" => 1,
				"label" => false,
				"defaultValue" => isset($product) ? $product->name ?? null : "",
			],
		]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "inventory_movement_type_id",
		"id" => "inventory_movement_type_id",
		"class" => "form-select",
		"entity" => "inventory_movements",
		"type" => "select",
		"defaultValue" => old("inventory_movement_type_id") ?? ($inventory_movement->inventory_movement_type_id ?? ""),
		"required" => "true",
		"elements" => $inventoryMovementTypes ?? [],
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "amount",
		"id" => "amount",
		"class" => "form-control",
		"entity" => "inventory_movements",
		"type" => "text",
		"defaultValue" => old("amount") ?? ($inventory_movement->amount ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "inventory_movements",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($inventory_movement->notes ?? ""),
	]
]])
