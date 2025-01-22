@extends('crud-maker.layouts.index', [
	'title' => __('roles.title_index'), 
	'entity' => 'roles', 
	'form' => 'role',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection
@section('form')
@endsection