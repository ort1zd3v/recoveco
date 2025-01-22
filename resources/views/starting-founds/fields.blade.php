@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "current_date",
		"id" => "current_date",
		"class" => "form-control",
		"entity" => "starting_founds",
		"type" => "text",
		"defaultValue" => old("current_date") ?? ($starting_found->current_date ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "amount",
		"id" => "amount",
		"class" => "form-control",
		"entity" => "starting_founds",
		"type" => "text",
		"defaultValue" => old("amount") ?? ($starting_found->amount ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "starting_founds",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($starting_found->notes ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "starting_founds",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($starting_found->is_active ?? ""),
		"required" => "true",
	]
]])
