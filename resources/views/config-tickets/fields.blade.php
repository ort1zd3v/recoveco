<div class="mb-2">
	<label for="url_logo">@lang('config_tickets.url_logo')</label>
	<input class="form-control" type="file" name="url_logo" id="url_logo" accept="image/*">
</div>

@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "header",
		"id" => "header",
		"class" => "form-control",
		"entity" => "config_tickets",
		"type" => "textarea",
		"defaultValue" => old("header") ?? ($config_ticket->header ?? ""),
		"required" => "true",
		"rows" => "3",
	]
]])
<div class="row">
	<div class="col">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "footer",
				"id" => "footer",
				"class" => "form-control",
				"entity" => "config_tickets",
				"type" => "textarea",
				"defaultValue" => old("footer") ?? ($config_ticket->footer ?? ""),
				"required" => "true",
				"rows" => "3",
			]
		]])
	</div>
	<div class="col">
		@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "footer2",
				"id" => "footer2",
				"class" => "form-control",
				"entity" => "config_tickets",
				"type" => "textarea",
				"defaultValue" => old("footer2") ?? ($config_ticket->footer2 ?? ""),
				"rows" => "3",
			]
		]])
	</div>
</div>
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "notes",
		"id" => "notes",
		"class" => "form-control",
		"entity" => "config_tickets",
		"type" => "textarea",
		"defaultValue" => old("notes") ?? ($config_ticket->notes ?? ""),
		"rows" => "3",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "is_active",
		"id" => "is_active",
		"class" => "form-control",
		"entity" => "config_tickets",
		"type" => "text",
		"defaultValue" => old("is_active") ?? ($config_ticket->is_active ?? ""),
		"required" => "true",
	]
]])	


@push('scripts')
	<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
	<script>
		$(function() {
			tinymce.init({
				selector: '#header',
				height: "300",
				setup: function (editor) {
					editor.on('change', function () {
						tinymce.triggerSave();
					});
				}
			});	

			tinymce.init({
				selector: '#footer',
				height: "300",
				setup: function (editor) {
					editor.on('change', function () {
						tinymce.triggerSave();
					});
				}
			});	

			tinymce.init({
				selector: '#footer2',
				height: "300",
				setup: function (editor) {
					editor.on('change', function () {
						tinymce.triggerSave();
					});
				}
			});	
		});
	</script>
@endpush