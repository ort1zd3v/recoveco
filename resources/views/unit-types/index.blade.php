@extends('crud-maker.layouts.index', [
	'title' => __('unit_types.title_index'), 
	'entity' => 'unit_types', 
	'form' => 'unitType',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection