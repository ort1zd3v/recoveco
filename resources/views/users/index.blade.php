@extends('crud-maker.layouts.index', [
	'title' => __('users.title_index'), 
	'entity' => 'users', 
	'form' => 'user',
])
@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection