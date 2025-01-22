@extends('layouts.app')
@section('content')
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="generales-tab" data-view='' data-toggle="tab" href="#generales" role="tab" aria-controls="general" aria-selected="true">@lang('config_general.general')</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="datatables-tab" data-view='tables' data-toggle="tab" href="#datatables" role="tab" aria-controls="tables" aria-selected="false">@lang('config_general.datatables')</a>
		</li>
	</ul>
	<!-- Tab panes -->
	{{ Form::open(['id' => 'config_general-edit', 'route' => ['templates.update'], 'method' => 'POST', 'enctype' => "multipart/form-data"]) }}
		@method('PUT')

		<div class="d-inline-block mt-3">
			@include("crud-maker.components.form-row", ["params" => [
			[
				"name" => "data[id]",
				"id" => "template_id",
				"class" => "form-select",
				"entity" => "templates",
				"type" => "select",
				"defaultValue" => old("template_id") ?? ($template->id ?? ""),
				"required" => "true",
				"elements" => $templates ?? [],
			]
		]])
		</div>

		<input id="name_template" type="text" name="data[name]" value="{{$template->name}}" hidden>
		
		<div class="tab-content">
			<div class="tab-pane active" id="generales" role="tabpanel" aria-labelledby="home-tab">
				@include('config-general.config_general', [$template])
			</div>
		</div>

		<div class="tab-pane" id="datatables" role="tabpanel" aria-labelledby="profile-tab">
			@include('config-general.config_tables', [$template])
		</div>
		
	</div>

	{{-- Preview --}}
	@extends('components.configTemplates.general', [$template])
	@section('contentPreview')
		<div id="preview">
		</div>
	@endsection

	{{ Form::close() }}

	
@endsection

@push('scripts')
	<script src="{{ asset('js/configuration/config_general.js') }}"></script>
	<script src="{{ asset('js/configuration/config_tables.js') }}"></script>

	<script>
		$('#myTab a').on('click', function (e) {
			e.preventDefault()
			$(this).tab('show');
			const preview = $("#preview");

			if ($(this).attr('data-view') != '') {
				$.ajax({
					url: $('meta[name="app-url"]').attr('content')+'/config_general/getPreview/' + $(this).attr('data-view') + '/' + $('#template_id').val(),
					type: 'GET',
					success: function(response) {
						preview.fadeOut('fast', function () {
							preview.html(response);
							preview.fadeIn('fast');
						});
						
					}
				});
			}else{
				preview.fadeOut('fast', function () {
					preview.html('');
					preview.fadeIn('fast');
				});
			}
		})
	</script>
@endpush