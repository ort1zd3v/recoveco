{{-- Este componente devuelve un input de tipo dropodown con autocomplete --}}
<div data-target-input="nearest" class="d-inline">
	<input type="hidden" name="placeholder" value="{{ isset($placeholder) ? (__("Select")." ".$placeholder) : '' }}" />
	<input type="hidden" name="required" value="{{ isset($required) ? ($required === true ? "true" : "false") : "false" }}" />
	<select class="{{ $class }} input-autocomplete" name="{{ $name }}">
		<option value=""></option>
		@if(isset($elements))
			@foreach($elements as $key => $element)
				@php $isSelected = false; @endphp
				@if(isset($value))
					@if($value != null)
						@if($value == $key)
							<option value="{{ $key }}" selected>{{ $element }}</option>
							@php $isSelected = true; @endphp
						@endif
					@endif
				@endif
				@if(!$isSelected)
					<option value="{{ $key }}">{{ $element }}</option>
				@endif
			@endforeach
		@endif
	</select>
</div>