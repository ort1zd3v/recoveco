@php
	$title = "Reporte por días histórico";
	if ($year != null) {
		$title = "Reporte por días del ".$year;
		if ($month != null) {
			$title = "Reporte por días de ".$nameOfMonth." en ".$year;
		}
	}
@endphp


@extends('crud-maker.layouts.index', [
	'title' => $title, 
	'entity' => 'report_by_days', 
	'form' => 'report_by_days',
])

@section('datatable')
	<div class="row report-by-day-filters mt-2 mb-3">
		@if (!$year ?? false)
			@include('crud-maker.components.filters', [
				"rows" => [
					["id" => "initial_date", "name" => "initial_date", "type" => "date"],
					["id" => "final_date", "name" => "final_date", "type" => "date"]
				], 
				"entity" => "report_by_days",
				"translations" => "reports",
				"type" => "datatable",
			])
		@else
			<div class="d-flex justify-content-end">
				<a class="btn btn-primary" href="{{route('report_by_years.getByMonth', $year)}}">
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