@extends('crud-maker.layouts.index', [
	'title' => __('suppliers.title_index'), 
	'entity' => 'suppliers', 
	'form' => 'supplier',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection