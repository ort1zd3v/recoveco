{{-- Este componente agrega un row con multiples label e input en un formulario normal de agregar o editar --}}
<div class="row form-group">
	@for ($i = 0; $i < $cols; $i++)
		@if(isset($params[$i]))
			@php 
				$isRequired = isset($params[$i]["required"]) ? ($params[$i]["required"] == true ? true : false) : false;
				$displayInline = $inline ?? true;
			@endphp
			<div class="col-12 col-md-{{ $displayInline ? (12 / floatval($cols)) : 12 }}">
				{{-- The content --}}
				<div class="row {{ $params[$i]["name"] }}_container" style="display: {{ $params[$i]["display"] ?? "flex" }};">
					<label for="{{ $params[$i]["name"] }}" class="col-12 col-md-{{ $displayInline ? 5 : 12 }} control-label">
						{{ __($params[$i]["translations"] ?? $params[$i]["entity"].".".$params[$i]["name"]) }} 
						@if($isRequired) <span class="required">*</span> @endif
					</label>
					<div class="col-12 col-md-{{ $displayInline ? 7 : 12 }}">
						@include('crud-maker.components.field-add', ['params' => $params[$i]])
					</div>
				</div>
				{{-- The content --}}
			</div>
		@endif
	@endfor
</div>
