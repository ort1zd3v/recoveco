@extends('crud-maker.layouts.index', [
	'title' => __('starting_founds.title_index'), 
	'entity' => 'starting_founds', 
	'form' => 'startingFound',
])

@section('datatable')
	<div class="row studies-filters mt-2 mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["name" => "initial_date", "type" => "date"],
				["name" => "final_date", "type" => "date"]
			], 
			"entity" => "starting_founds",
			"translations" => "starting_founds",
			"type" => "datatable",
		])
	</div>
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection
