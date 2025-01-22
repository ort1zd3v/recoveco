<p class="text-center font-size-14">{{$inventory->product->name}}</p>
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "product_id",
		"id" => "product_id",
		"class" => "form-control",
		"entity" => "inventories",
		"type" => "text",
		"defaultValue" => old("product_id") ?? ($inventory->product_id ?? ""),
		"required" => "true",
		"display" => "none"
	]
]])

@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "amount",
		"id" => "amount",
		"class" => "form-control",
		"entity" => "inventories",
		"type" => "text",
		"defaultValue" => old("amount") ?? ($inventory->amount ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "inventories",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($inventory->notes ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "inventories",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($inventory->is_active ?? ""),
		"required" => "true",
	]
]])
