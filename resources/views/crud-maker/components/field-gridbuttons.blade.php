{{-- Este componente devuelve un input de tipo grid --}}
<div data-target-input="nearest" class="row">
	@if(isset($elements))
		@php
			$col = 12/$x;
			$totalCol =0;
		@endphp
		
		@foreach($elements as $key => $element)
			{{-- Start new row when col counter is greater than 12 --}}
			@if($totalCol+$col>12)
				</div>
				<div data-target-input="nearest" class="row">
				@php $totalCol =0; @endphp
			@endif
			@php $totalCol +=$col; @endphp
			
			<div class="col-{{$col}}">
				{{-- button --}}
				<button 
					id ="{{$entity}}_{{$name}}_{{$element['id']}}"
					type="button" 
					class="btn {{ $class ?? '' }} {{ $element['id']==$defaultValue ? 'btn-primary' : 'btn-outline-primary' }}"
					data-id="{{ $element['id'] }}" 
					@if (isset($element["callback"]))
						onclick="{{$element['callback']}}"
					@endif

					@if (isset($element["background_color"]) || isset($element["text_color"]))
						style="
							@if (isset($element["background_color"]) )
								border-color:{{$element['background_color']}};
							@endif
							@if (isset($element["text_color"]) )
								color:{{$element['text_color']}};
							@endif
						"
					@endif
					>
					{{-- button icon --}}
					<span>
						@if (isset($element["icon"]))
							<i class="fas fa-{{ $element['icon'] }} pr-2" aria-hidden="true"></i>
						@endif
						{{$element["title"]}}
					</span>
				</button>
			</div>
		@endforeach
	@endif
</div>