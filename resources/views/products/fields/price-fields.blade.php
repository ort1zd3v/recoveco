<h3>Precios</h3>
<hr>
<div class="row">
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "price_base",
				"id" => "price_base",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"step" => "any",
				"defaultValue" => old("price_base") ?? ($product->price_base ?? ""),
				"sign" => "$",
				"required" => "true",
			]
		]])
	</div>
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "price_min",
				"id" => "price_min",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"step" => "any",
				"defaultValue" => old("price_min") ?? ($product->price_min ?? ""),
				"sign" => "$",
				"required" => false,
			]
		]])
	</div>
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "price_max",
				"id" => "price_max",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"step" => "any",
				"defaultValue" => old("price_max") ?? ($product->price_max ?? ""),
				"sign" => "$",
				"required" => false,
			]
		]])
	</div>
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "overprice",
				"id" => "overprice",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"step" => "any",
				"defaultValue" => old("overprice") ?? ($product->overprice ?? ""),
				"sign" => "$",
				"required" => false,
				"tooltip" => "Se utiliza cuando un ingrediente tiene precio extra al ser seleccionado",

			]
		]])
	</div>
</div>