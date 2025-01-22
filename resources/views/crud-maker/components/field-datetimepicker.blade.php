{{-- Este componente devuelve un input de tipo datepicker --}}
<div class="input-group date {{ $params["datepickerClass"] ?? "datetimepicker2" }}" id="{{ $params["id"] ?? $params["name"] }}" data-target-input="nearest">
	@php $params["class"] .= " datetimepicker-input"; @endphp
	{{ Form::text($params["name"], $params["defaultValue"] ?? "", $params) }}
	<div class="input-group-append" data-target="#{{ $params["id"] ?? $params["name"] }}" data-toggle="datetimepicker">
		<div class="input-group-text d-block">
			<i class="fa fa-calendar"></i>
		</div>
	</div>
</div>