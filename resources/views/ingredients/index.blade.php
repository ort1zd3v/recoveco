@extends('crud-maker.layouts.index', [
	'title' => __('ingredients.title_index'), 
	'entity' => 'ingredients', 
	'form' => 'ingredient',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection