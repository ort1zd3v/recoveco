{{ Form::hidden($params["name"], $params["defaultValue"] ?? "", $params) }}
@php
	$params["id"] = $params["id"] . "_show"; 
@endphp

<div 
@foreach($params as $key => $param)
	{{ $key }} = "{{ $param }}" 
@endforeach
>{!! $params["defaultValue"] ?? "" !!}</div>
