{{-- 
	Este componente devuelve un input ya formateado con el tipo correspondiente
--}}
@php
	$params["class"] = $params["class"] ?? 'form-control';
	/* En caso de que el nombre del campo sea un nombre raro como por ejemmplo users[email]
		Para poner el texto en el placeholder se buscará "id" en los parámetros */
	$name = $params["id"] ?? $params["name"];
	$params["placeholder"] = __($params["translations"] ?? ($params["entity"].".".$name));
	$quickadd = $params["quickadd"] ?? [];
	$addonButton = $params["addonButton"] ?? false;
	unset($params["quickadd"]);
	unset($params["addonButton"]);
@endphp

@if($addonButton != false)
<div class="input-group">
@elseif($quickadd ?? false)
<div class="input-group">
@endif

@if(isset($params["type"]))
	@switch($params["type"])
		@case('date')
			{{ Form::date($params["name"], $params["defaultValue"] ?? "", $params) }}
			@break
		@case('month')
			{{ Form::month($params["name"], $params["defaultValue"] ?? "", $params) }}
			@break
		@case('datepicker')
			@include('crud-maker.components.field-datetimepicker', compact('params'))
			@break
		@case('input-autocomplete')
			@include('crud-maker.components.field-autocomplete-input', compact('params'))
			@break
		@case('select')
			@php
				//Quitamos de los parámetros el array con los elementos que rellenará el select
				$elements = $params["elements"];
				unset($params["elements"]);
				//Quitamos placeholder para que no nos agregue elemento vacío al inicio
				unset($params["placeholder"]);
			@endphp
			{{ Form::select($params["name"], $elements, $params["defaultValue"] ?? "", $params) }}
			@break
		@case('number')
			<div class="d-flex align-items-center gap-1">
				<span class="font-size-20">{{$params['sign'] ?? ""}}</span>
				{{ Form::number($params["name"], $params["defaultValue"] ?? "", $params) }}
			</div>
			
			@break
		@case('textarea')
			{{ Form::textarea($params["name"], $params["defaultValue"] ?? "", $params) }}
			<span class="font-size-20">{{$params['helper'] ?? ""}}</span>
			@break
		@case('text')
			{{ Form::text($params["name"], $params["defaultValue"] ?? "", $params) }}
			@break
		@case('text-div')
			@include('crud-maker.components.field-text-div', compact('params'))
			@break
		@case('password')
			{{ Form::password($params["name"], $params) }}
			@break
		@case('checkbox')
			@include('crud-maker.components.field-checkbox', compact('params'))
			@break
		@case('radio')
			@include('crud-maker.components.field-radio', compact('params'))
			@break
		@case('label')
			{{ Form::label($params["name"], $params["defaultValue"] ?? "", $params) }}
			@break
	@endswitch
@else
	{{ Form::text($params["name"], "", $params) }}
@endif

@if($addonButton != false)
	<div class="input-group-append">
		{{ Form::button($addonButton["name"], $addonButton) }}
	</div>
</div>
@elseif($quickadd ?? false)
	<div class="input-group-append">
		{{ Form::button($quickadd["text"] ?? '<i class="fas fa-plus"></i></button>', array_merge(["class" => "btn btn-secondary"], ($quickadd["props"] ?? []))) }}
	</div>
</div>
@endif
