{{-- Este componente agrega un row con label e input en un formulario normal de agregar o editar --}}
@php 
	$isRequired = isset($params["required"]) ? ($params["required"] == true ? true : false) : false;
@endphp
<div class="row input-group mb-3">
	<label for="{{ $params["name"] }}" class="col-sm-12 control-label">
		
		{{ __($params["translations"] ?? $params["entity"].".".$params["name"]) }} 
		@if($isRequired) <span class="required">*</span> @endif
	</label>
	<div class="col-sm-12">
		@include('crud-maker.components.field-add', compact('params'))
	</div>
</div>