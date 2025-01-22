@extends('crud-maker.layouts.index', [
	'title' => "Reporte del año ".$year, 
	'entity' => 'report_by_years', 
	'form' => 'report_by_years',
])

@section('datatable')
	<div class="row font-size-16">
		@include('reports.table-sellings-users')

		<div class="d-flex justify-content-end">
			<a class="btn btn-primary" href="{{route('report_by_years.index')}}">
				<i class='bx bx-left-arrow-alt'></i> Regresar
			</a>
		</div>
	</div>
		
	<div class="mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["id" => "supplier_name", "name" => "supplier_name", "type" => "text"],
				["id" => "product_name", "name" => "product_name", "type" => "text"],
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