{{-- Este componente agrega un row con multiples label e input en un formulario normal de agregar o editar --}}
<div class="row mb-3">
	@php 
		$cols = $cols ?? count($params);
		$displayInline = $cols > 1 ? true : false;
	@endphp
	@for ($i = 0; $i < $cols; $i++)
		@if(isset($params[$i]))
			@php 
				$isRequired = $params[$i]["required"] ?? false;
			@endphp
			<div class="col-12 col-md-{{ $displayInline ? (12 / floatval($cols)) : 12 }}">
				{{-- The content --}}
				<div class="row {{ $params[$i]["name"] }}_container" style="display: {{ $params[$i]["display"] ?? "flex" }};">
					<label for="{{ $params[$i]["name"] }}" class="col-12 col-md-12 control-label">
						{{ __($params[$i]["translations"] ?? $params[$i]["entity"].".".$params[$i]["name"]) }} 
						@if($isRequired) <span class="required">*</span> @endif
						@if (array_key_exists('tooltip', $params[$i]))
							<a href="#"  data-tooltip="{{$params[$i]['tooltip']}}"><i class='bx bx-question-mark text-white p-1 font-size-16 icon-tooltip'></i></a>
						@endif
					</label>
					<div class="col-12 col-md-12">
						@include('crud-maker.components.field-add', ['params' => $params[$i]])
					</div>
				</div>
				{{-- The content --}}
			</div>
		@endif
	@endfor
</div>
