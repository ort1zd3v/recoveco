@php
	setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'es');
	$title = '';
	if ($final_date == 0 && $initial_date == 0) {
		$title = $supplier->name;
	}elseif ($final_date != 0 && $initial_date != 0){
		$title = $supplier->name.' - Desde '.strftime("%d %B %Y", strtotime($initial_date)). ' hasta  '.strftime("%d %B %Y", strtotime($final_date));
	}elseif ($initial_date != 0) {
		$title = $supplier->name.' - Desde '.strftime("%d %B %Y", strtotime($initial_date));
	}elseif ($final_date != 0) {
		$title = $supplier->name.' - Hasta '.strftime("%d %B %Y", strtotime($final_date));
	}
	
@endphp

@extends('crud-maker.layouts.index', [
	'title' => $title, 
	'entity' => 'report_by_suppliers', 
	'form' => 'report_by_suppliers',
])
@section('datatable')
	@if ($final_date == 0 && $initial_date == 0)
		<div class="report-by-suppliers-filters mt-4 mb-2">
			@include('crud-maker.components.filters', [
				"rows" => [
					["id" => "initial_date", "name" => "initial_date", "type" => "date"],
					["id" => "final_date", "name" => "final_date", "type" => "date"],
					["id" => "product_name", "name" => "product_name", "type" => "text"]
				], 
				"entity" => "report_by_suppliers",
				"translations" => "report_by_suppliers",
				"type" => "datatable",
			])
		</div>
	@endif

	<div class="d-flex justify-content-end mb-2">
		<a class="btn btn-primary" href="{{route('report_by_suppliers.index')}}">
			<i class='bx bx-left-arrow-alt'></i> Regresar
		</a>
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