@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "name",
		"id" => "name",
		"class" => "form-control",
		"entity" => "clients",
		"type" => "text",
		"defaultValue" => old("name") ?? ($client->name ?? ""),
		"required" => true,
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "client_number",
		"id" => "client_number",
		"class" => "form-control",
		"entity" => "clients",
		"type" => "text",
		"defaultValue" => old("client_number") ?? ($client->client_number ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "branch_id",
		"id" => "branch_id",
		"class" => "form-select",
		"entity" => "clients",
		"type" => "select",
		"defaultValue" => old("branch_id") ?? ($client->branch_id ?? ""),
		"required" => true,
		"elements" => $branches ?? [],
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "clients",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($client->notes ?? ""),
	]
]])
{{-- @include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "clients",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($client->is_active ?? ""),
		"required" => true,
	]
]]) --}}
