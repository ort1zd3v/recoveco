<div class="row datatable-filters">
	<div class="col-12 col-md-8 offset-md-2 col-lg-4 offset-lg-4">
		@php 
			$rowNumber = 1;
			$type = $type ?? 'datatable';
		@endphp
		@if($type != 'datatable')
			<input type="hidden" id="filterSource" value="{{ $filterSource }}">
		@endif
		@foreach($rows as $row)
			<div class="form-group mb-1">
				<div class="row">
					<label for="{{ $row["id"] ?? $row["name"] }}" class="col-sm-4 control-label">
						{{ __(($translations ?? $entity).".".($row["id"] ?? $row["name"])) }}
					</label>
					<div class="col-sm-8">
					@if(isset($row["fields"]))
						@foreach($row["fields"] as $field)
							@include('crud-maker.components.field-add', getParams($field, $type, $entity))
						@endforeach
					@else
						@include('crud-maker.components.field-add', getParams($row, $type, $entity))
					@endif
					</div>
				</div>
			</div>
			@php $rowNumber++; @endphp
		@endforeach
		
		<div class="row">
			<div class="col text-center d-flex justify-content-between">
				<button id="btn-clear-{{$entity}}" type="button" class="btn btn-danger font-size-16 px-3" onclick="clearFilters('{{ $type }}')">{{ __('Clear filters') }}</button>
				<button id="btn-search-{{$entity}}" type="button" class="btn btn-primary font-size-16 px-3" onclick="filterData('{{ $type }}')">{{ __('Search') }}</button>
			</div>
		</div>
	</div>
</div>
@php
function getParams($param, $type, $entity) {
	return [
		"params" => array_merge($param, [
			"class" => ($param["class"] ?? "form-control")." ".$type."-filter",
			"entity" => $entity,
		]),
	];
}
@endphp