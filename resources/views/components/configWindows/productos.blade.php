<h3>Configuración de productos</h3>
<div class="mb-2">
	<label for="with_tabs">@lang('config_products.with_tabs')</label>
	<input type="checkbox" name="with_tabs" id="with_tabs" {{$configProducts->with_tabs == true ? 'checked' : false}}>
</div>

<div class="mb-2">
	<label for="with_filters">@lang('config_products.with_filters')</label>
	<input type="checkbox" name="with_filters" id="with_filters" {{$configProducts->with_filters == true ? 'checked' : false}}>
</div>
<div class="mb-2">
	<label for="with_keyboard">@lang('config_products.with_keyboard')</label>
	<input type="checkbox" name="with_keyboard" id="with_keyboard" {{$configProducts->with_keyboard == true ? 'checked' : false}}>
</div>
<div class="row">
	<div class="col">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "num_cols",
				"id" => "num_cols",
				"class" => "form-control",
				"entity" => "config_products",
				"type" => "number",
				"defaultValue" => old("num_cols") ?? ($configProducts->num_cols ?? ""),
			]
		]])
	</div>
	<div class="col">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "type_box",
				"id" => "type_box",
				"class" => "form-select",
				"entity" => "config_products",
				"type" => "select",
				"defaultValue" => old("type_box") ?? ($configProducts->type_box ?? ""),
				"elements" => ["both"=>"Ambos", "names"=>"Solo nombres", "icons"=>'Solo íconos'],
			]
		]])
	</div>
</div>

<script>
	$("#saveConfig").click(function(){
		var formData = new FormData();
		formData.append('view', 'productos');
		formData.append("data[with_tabs]", $("#with_tabs").prop('checked'));
		formData.append("data[with_filters]", $("#with_filters").prop('checked'));
		formData.append("data[with_keyboard]", $("#with_keyboard").prop('checked'));
		formData.append("data[type_box]", $(`#type_box option:selected`).val());
		formData.append("data[num_cols]", $(`#num_cols`).val());


		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+"/config_pos/saveConfigView",
			type: 'POST',
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response)
				location.reload()
			},
			error: function(response) {
				console.log(response)
			}
		});
	})

</script>