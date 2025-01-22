@extends('crud-maker.layouts.index', [
	'title' => __('report_by_years.title_index'), 
	'entity' => 'report_by_years', 
	'form' => 'report_by_years',
])

@section('datatable')
	<div class="row report-by-year-filters mt-2 mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["id" => "initial_date", "name" => "initial_date", "type" => "number"],
				["id" => "final_date", "name" => "final_date", "type" => "number"]
			], 
			"entity" => "report_by_years",
			"translations" => "report_by_years",
			"type" => "datatable",
		])
	</div>
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection

@push('styles')
	<style>
		table tfoot th {
			border-bottom: 0;
		}
	</style>
@endpush
