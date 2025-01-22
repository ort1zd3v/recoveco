@extends('crud-maker.layouts.index', [
	'title' =>	$year == null ? "Reporte por meses histórico" : "Reporte por meses del ".$year, 
	'entity' => 'report_by_months', 
	'form' => 'report_by_months',
])

@section('datatable')
	<div class="row report-by-month-filters mt-2 mb-3">
		@if (!$year ?? false)
			@include('crud-maker.components.filters', [
				"rows" => [
					["id" => "initial_date", "name" => "initial_date", "type" => "month"],
					["id" => "final_date", "name" => "final_date", "type" => "month"]
				], 
				"entity" => "report_by_months",
				"translations" => "reports",
				"type" => "datatable",
			])
		@else
			<div class="d-flex justify-content-end">
				<a class="btn btn-primary" href="{{route('report_by_years.index')}}">
					<i class='bx bx-left-arrow-alt'></i> Regresar
				</a>
			</div>
		@endif

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