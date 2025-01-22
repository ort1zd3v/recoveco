{{-- Este componente devuelve un input de tipo text button addon --}}

<div class="input-group mb-3">
	@if (isset($params["prepend"]))
		<div class="input-group-prepend">
	
  		@foreach($params["prepend"] as $key => $p)
    		<button class="btn btn-outline-primary" type="button"
    			@if (isset($p["callback"]))
    				onclick="{{ $p["callback"] }}" 
    			@endif
    		>
    			@if (isset($p["icon"]))
		  			<i class="{{$p['icon']}} pr-2" aria-hidden="true"></i>
		  		@endif
		  		@if (isset($p["text"]))
		  			<i class="{{$p['text']}} pr-2" aria-hidden="true"></i>
		  		@endif
    		</button>
   		@endforeach
    
  		</div>
	@endif 
	@php
		$aux = $params;
		unset($aux["prepend"]);
		unset($aux["append"]);
	@endphp
	@if ($aux["texttype"]=="number")
  		{{ Form::number($params["name"], "", $aux) }}
  	@else
  		{{ Form::text($params["name"], "", $aux) }}
  	@endif
  @if (isset($params["append"]))
		<div class="input-group-append">
	
  		@foreach($params["append"] as $key => $p)
    		<button class="btn btn-outline-primary" type="button"
    			@if (isset($p["callback"]))
    				onclick="{{ $p["callback"] }}" 
    			@endif
    		>
    			@if (isset($p["icon"]))
		  			<i class="{{$p['icon']}} pr-2" aria-hidden="true"></i>
		  		@endif
		  		@if (isset($p["text"]))
		  			<i class="{{$p['text']}} pr-2" aria-hidden="true"></i>
		  		@endif
    		</button>
   		@endforeach
    
  		</div>
	@endif
 
</div>

