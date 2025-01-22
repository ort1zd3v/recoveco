@extends('layouts.app')
@section('content')

<div class="d-flex gap-2 align-items-center">
	<h1 class="m-0">@lang('config_pos.title_index')</h1>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#configModal">
		Configuración
	</button>
</div>
<hr>

{{ Form::open(['id' => 'config_pos-edit', 'route' => ['config_pos.update'], 'method' => 'POST', 'enctype' => "multipart/form-data"]) }}
@method('PUT')

{{-- <div id="configView">
	
</div> --}}

<!-- Modal -->
<div class="modal fade" id="configModal2" tabindex="-1" aria-labelledby="configModal2Label" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="configModal2Label">Configuración de POS</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="configView">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a id="saveConfig" type="submit" class="btn btn-primary">@lang('config_pos.save')</a>
			</div>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div id="contentPreviewPOS" class="w-100 h-100" style="overflow-y: scroll">
		
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="configModalLabel">Configuración de POS</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<h3 id="section">Filas y columnas</h3>
						@include("crud-maker.components.form-row", ["params" => [
							[
								"name" => "total_rows",
								"id" => "total_rows",
								"class" => "form-select",
								"entity" => "config_pos",
								"type" => "select",
								"defaultValue" => old("total_rows") ?? ($config->total_rows ?? 1),
								"required" => "true",
								"elements" => [1=>1, 2=>2],
							]
						]])
						@include("crud-maker.components.form-row", ["params" => [
							[
								"name" => "total_columns",
								"id" => "total_columns",
								"class" => "form-select",
								"entity" => "config_pos",
								"type" => "select",
								"defaultValue" => old("total_columns") ?? ($config->total_columns ?? 1),
								"required" => "true",
								"elements" => [1=>1,2=>2,3=>3,4=>4,"1:2"=>"1:2","2:1"=>"2:1"],	
							]
						]])
					</div>
					<div class="col-md-6">
						<h3 id="section">Para sección</h3>
						@include("crud-maker.components.form-row", ["params" => [
							[
								"name" => "num_section",
								"id" => "num_section",
								"class" => "form-select",
								"entity" => "config_pos",
								"type" => "select",
								"defaultValue" => old("num_section") ?? 1,
								"required" => "true",
								"elements" => [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8],	
							]
						]])
						<div class="d-flex align-items-center gap-2">
							@include("crud-maker.components.form-row", ["params" => [
								[
									"name" => "views",
									"id" => "views",
									"class" => "form-select",
									"entity" => "views",
									"type" => "select",
									"defaultValue" => old("views") ?? (0 ?? ""),
									"elements" => ["productos", "carrito", "pago"],
								]
							]])
						<a class="btn btn-success" onclick="setView()">+</a>
					</div>
				</div>
				{{-- <div class="col-md-8">
					<div class="row mb-2">
						<label for="background_color_views">Imagen de fondo para pantalla (opcional)</label>
						<input class="form-control" type="file" name="background_image" id="background_image">
					</div>
				</div> --}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<input type="submit" value="@lang('config_pos.save')" class="btn btn-primary">
			</div>
		</div>
	</div>
</div>


{{ Form::close() }}
@endsection

@push('scripts')
	<script src="{{asset('js/configuration/config_pos.js')}}"></script>
@endpush