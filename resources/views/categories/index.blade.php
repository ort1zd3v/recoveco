@extends('crud-maker.layouts.index', [
	'title' => __('categories.title_index'), 
	'entity' => 'categories', 
	'form' => 'category',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection