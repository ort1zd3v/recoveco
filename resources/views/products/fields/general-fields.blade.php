<h3>Generales</h3>
<hr>
<div class="row">
	<div class="col-md-4">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "name",
				"id" => "name",
				"class" => "form-control",
				"entity" => "products",
				"type" => "text",
				"defaultValue" => old("name") ?? ($product->name ?? ""),
				"required" => "true",
			]
		]])
	</div>
	{{-- <div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "display_name",
				"id" => "display_name",
				"class" => "form-control",
				"entity" => "products",
				"type" => "text",
				"defaultValue" => old("display_name") ?? ($product->display_name ?? ""),
				"required" => false,
			]
		]])
	</div> --}}
	<div class="col-md-2">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "category_id",
				"id" => "category_id",
				"class" => "form-select",
				"entity" => "products",
				"type" => "select",
				"defaultValue" => old("category_id") ?? ($product->category_id ?? ""),
				"required" => "true",
				"elements" => $categories ?? [],
			]
		]])
	</div>
	<div class="col-md-4">
		@include("crud-maker.components.form-row", ["params" => [
				[
				"name" => "barcode",
				"id" => "barcode",
				"class" => "form-control",
				"entity" => "products",
				"type" => "text",
				"defaultValue" => old("barcode") ?? ($product->barcode ?? ""),
				"required" => "true",
			]
		]])
	</div>
	<div class="col-md-2">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "print_order",
				"id" => "print_order",
				"class" => "form-control",
				"entity" => "products",
				"type" => "text",
				"step" => "any",
				"defaultValue" => old("print_order") ?? ($product->print_order ?? ""),
				"required" => false,
			]
		]])
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "unit_type_id",
				"id" => "unit_type_id",
				"class" => "form-select",
				"entity" => "products",
				"type" => "select",
				"defaultValue" => old("unit_type_id") ?? ($product->unit_type_id ?? ""),
				"required" => "true",
				"elements" => $unitTypes ?? [],
			]
		]])
	</div>
	<div class="col-md-3 d-none">
		<div class="mb-3">
			<label for="color">Color</label>
			<input style="height: 40px" type="color" class="form-control p-2" name="color" id="color" value="{{old("color") ?? ($product->color ?? "")}}">
		</div>
	</div>
	{{-- <div class="col-md-3">
		<div class="mb-2 d-flex gap-2">
			<div>
				<img id="image_product" class="img-fluid" style="max-width: 120px" 
				src="{{isset($product->url_image) ? "../../$product->url_image" : asset('images/no-image.png')}}" alt="">
			</div>
			<div class="w-100">
				<label for="url_image">@lang('products.url_image')</label>
				<input class="form-control" type="file" name="url_image" id="url_image" accept="image/*">
			</div>
		</div>
	</div> --}}
	<div class="col-md-2">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "amount",
				"id" => "amount",
				"class" => "form-control",
				"entity" => "products",
				"type" => "text",
				"step" => "any",
				"required" => true,
				"defaultValue" => old("amount") ?? ($product->inventories[0]->amount ?? ""),
				// "required" => "true",
			]
		]])
	</div>
	<div class="col-md-6">
		@include("crud-maker.components.form-row", ["params" => [
			[
				'name' => 'search_input',
				'id' => 'search_input',
				'class' => 'form-control input-autocomplete remove-searchx',
				'entity' => 'suppliers',
				'type' => 'input-autocomplete',
				'data-source' => 'suppliers/getbyparam',
				'data-hidden-id' => 'supplier_id',
				'data-hidden-value' => isset($product) ? $product->supplier->id ?? null : "",
				'data-hidden-name' => 'supplier_id',
				'translations' => 'suppliers.search',
				'data-filter' => 'name',
				"inputType" => 1,
				"label" => false,
				"defaultValue" => isset($product) ? $product->supplier->name ?? null : "",
			],
		]])
	</div>
	
	<div class="col-md-1">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "is_active",
				"id" => "is_active",
				"class" => "form-check mt-0",
				"entity" => "products",
				"type" => "checkbox",
				"defaultValue" => 1,
				"checked" => (isset($isEdit) ? $product->is_active : true),
				"required" => "true",
			]
		]])
	</div>
</div>

