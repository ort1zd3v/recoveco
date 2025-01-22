<div class="row table-row mb-3" 
@foreach($attrs as $key => $value)
	{{ $key }} = "{{ $value }}" 
@endforeach
>
	@php 
		$cols = $cols ?? count($params);
		$colSize = 12/$cols;
	@endphp
	@for ($i = 0; $i < $cols; $i++)
		@if(isset($params[$i]))
			<div class="col-12 col-md-{{ $params[$i]["cols"] ?? $colSize }} table-col">
				@if($params[$i]["type"] == 'raw')
					{!! $params[$i]["content"] !!}
				@else
					@include('crud-maker.components.field-add', ['params' => $params[$i]])
				@endif
			</div>
		@endif
	@endfor

	<div class="col">
		@if($saveButton ?? false)
			{{ Form::button($saveButton["value"], $saveButton) }}
		@endif
		<button type='button' class='btn text-danger btn-unsaved d-none'>
			<i class='fas fa-exclamation'></i>
		</button>
		<button type='button' class='btn text-success btn-saved d-none'>
			<i class='fas fa-check'></i>
		</button>
		@if($hasDeleteButton ?? true)
			<button type='button' class='btn text-danger btn-delete' onclick="deleteRow(this)">
				<i class='fa fa-times actions_icon'></i>
			</button>
		@endif
	</div>
</div>