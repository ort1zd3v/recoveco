@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "product_id",
		"id" => "product_id",
		"class" => "form-select",
		"entity" => "ingredients",
		"type" => "select",
		"defaultValue" => old("product_id") ?? ($ingredient->product_id ?? ""),
		"required" => "true",
		"elements" => $products ?? [],
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "ingredient_id",
		"id" => "ingredient_id",
		"class" => "form-select",
		"entity" => "ingredients",
		"type" => "select",
		"defaultValue" => old("ingredient_id") ?? ($ingredient->ingredient_id ?? ""),
		"elements" => $products ?? [],
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "category_id",
		"id" => "category_id",
		"class" => "form-select",
		"entity" => "ingredients",
		"type" => "select",
		"defaultValue" => old("category_id") ?? ($ingredient->category_id ?? ""),
		"elements" => $categories ?? [],
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "amount",
		"id" => "amount",
		"class" => "form-control",
		"entity" => "ingredients",
		"type" => "text",
		"defaultValue" => old("amount") ?? ($ingredient->amount ?? ""),
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "ingredients",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($ingredient->notes ?? ""),
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "ingredients",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($ingredient->is_active ?? ""),
		"required" => "true",
	]
]])
