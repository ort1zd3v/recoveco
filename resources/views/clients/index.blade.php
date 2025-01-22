@extends('crud-maker.layouts.index', [
	'title' => __('clients.title_index'), 
	'entity' => 'clients', 
	'form' => 'client',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection