@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "client_id",
		"id" => "client_id",
		"class" => "form-select",
		"entity" => "sellings",
		"type" => "select",
		"defaultValue" => old("client_id") ?? ($selling->client_id ?? ""),
		"elements" => $clients ?? [],
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "subtotal",
		"id" => "subtotal",
		"class" => "form-control",
		"entity" => "sellings",
		"type" => "text",
		"defaultValue" => old("subtotal") ?? ($selling->subtotal ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "iva",
		"id" => "iva",
		"class" => "form-control",
		"entity" => "sellings",
		"type" => "text",
		"defaultValue" => old("iva") ?? ($selling->iva ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "total",
		"id" => "total",
		"class" => "form-control",
		"entity" => "sellings",
		"type" => "text",
		"defaultValue" => old("total") ?? ($selling->total ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "sellings",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($selling->notes ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "sellings",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($selling->is_active ?? ""),
		"required" => "true",
	]
]])
