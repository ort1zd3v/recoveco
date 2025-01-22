@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "name",
		"id" => "name",
		"class" => "form-control",
		"entity" => "suppliers",
		"type" => "text",
		"defaultValue" => old("name") ?? ($supplier->name ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "description",
		"id" => "description",
		"class" => "form-control",
		"entity" => "suppliers",
		"type" => "text",
		"defaultValue" => old("description") ?? ($supplier->description ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "commission_percentage",
		"id" => "commission_percentage",
		"class" => "form-control",
		"entity" => "suppliers",
		"type" => "text",
		"defaultValue" => old("commission_percentage") ?? ($supplier->commission_percentage ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "suppliers",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($supplier->notes ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "suppliers",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($supplier->is_active ?? ""),
		"required" => "true",
	]
]])
