<h3>Adicionales</h3>
<hr>


<div class="row">
	<div class="col-8">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "is_saleable",
				"id" => "is_saleable",
				"class" => "form-check",
				"entity" => "products",
				"type" => "checkbox",
				"defaultValue" => 1,
				"checked" => (isset($isEdit) ? $product->is_saleable : false),
			],
			[
				"name" => "is_ticketable",
				"id" => "is_ticketable",
				"class" => "form-check",
				"entity" => "products",
				"type" => "checkbox",
				"defaultValue" => 1,
				"checked" => (isset($isEdit) ? $product->is_ticketable : false),
			],
			[
				"name" => "is_discountable",
				"id" => "is_discountable",
				"class" => "form-check",
				"entity" => "products",
				"type" => "checkbox",
				"defaultValue" => 1,
				"checked" => (isset($isEdit) ? $product->is_discountable : false),
			]
		]])

		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "is_favorite",
				"id" => "is_favorite",
				"class" => "form-check",
				"entity" => "products",
				"type" => "checkbox",
				"defaultValue" => 1,
				"checked" => (isset($isEdit) ? $product->is_favorite : false),
			],
			[
				"name" => "is_consigment",
				"id" => "is_consigment",
				"class" => "form-check",
				"entity" => "products",
				"type" => "checkbox",
				"defaultValue" => 1,
				"checked" => (isset($isEdit) ? $product->is_consigment : false),
			],
			[
				"name" => "is_product",
				"id" => "is_product",
				"class" => "form-check",
				"entity" => "products",
				"type" => "checkbox",
				"defaultValue" => 1,
				"checked" => (isset($isEdit) ? $product->is_product : false),
			]
		]])
	</div>
	<div class="col-md-4">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "notes",
				"id" => "notes",
				"class" => "form-control",
				"entity" => "products",
				"type" => "textarea",
				"defaultValue" => old("notes") ?? ($product->notes ?? ""),
				"rows" => 6
			]
		]])
	</div>
</div>

