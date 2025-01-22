@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "category_id",
		"id" => "category_id",
		"class" => "form-select",
		"entity" => "categories",
		"type" => "select",
		"defaultValue" => old("category_id") ?? ($category->category_id ?? ""),
		"elements" => $categories ?? [],
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "name",
		"id" => "name",
		"class" => "form-control",
		"entity" => "categories",
		"type" => "text",
		"defaultValue" => old("name") ?? ($category->name ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "description",
		"id" => "description",
		"class" => "form-control",
		"entity" => "categories",
		"type" => "text",
		"defaultValue" => old("description") ?? ($category->description ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "categories",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($category->notes ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "print_order",
		"id" => "print_order",
		"class" => "form-control",
		"entity" => "categories",
		"type" => "text",
		"defaultValue" => old("print_order") ?? ($category->print_order ?? "1"),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_visible",
		"id" => "is_visible",
		"class" => "form-control",
		"entity" => "categories",
		"type" => "text",
		"defaultValue" => old("is_visible") ?? ($category->is_visible ?? "1"),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "categories",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($category->is_active ?? "1"),
		"required" => "true",
	]
]])
