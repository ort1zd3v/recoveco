@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "name",
		"id" => "name",
		"class" => "form-control",
		"entity" => "unit_types",
		"type" => "text",
		"defaultValue" => old("name") ?? ($unit_type->name ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "description",
		"id" => "description",
		"class" => "form-control",
		"entity" => "unit_types",
		"type" => "text",
		"defaultValue" => old("description") ?? ($unit_type->description ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "unit_types",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($unit_type->notes ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "unit_types",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($unit_type->is_active ?? ""),
		"required" => "true",
	]
]])
