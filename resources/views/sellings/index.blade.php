@extends('crud-maker.layouts.index', [
	'title' => __('sellings.title_index'), 
	'entity' => 'sellings', 
	'form' => 'selling',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection