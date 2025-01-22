<h3>Costos</h3>
<hr>

<div class="row">
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "cost_base",
				"id" => "cost_base",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"defaultValue" => old("cost_base") ?? ($product->cost_base ?? ""),
				"step" => "any",
				"sign" => "$",
				"required" => "true",
			]
		]])
	</div>
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "cost_min",
				"id" => "cost_min",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"step" => "any",
				"defaultValue" => old("cost_min") ?? ($product->cost_min ?? ""),
				"sign" => "$",
				"required" => false,
			]
		]])
	</div>
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "cost_max",
				"id" => "cost_max",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"step" => "any",
				"defaultValue" => old("cost_max") ?? ($product->cost_max ?? ""),
				"sign" => "$",
				"required" => false,
			]
		]])
	</div>
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "iva",
				"id" => "iva",
				"class" => "form-control",
				"entity" => "products",
				"type" => "number",
				"step" => "any",
				"defaultValue" => old("iva") ?? ($product->iva ?? ""),
				"sign" => "%",
				"required" => "true",
			]
		]])
	</div>
</div>



