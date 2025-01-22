@extends('crud-maker.layouts.index', [
	'title' => "Reporte de ".$nameOfMonth." del año ".$year, 
	'entity' => 'report_by_months', 
	'form' => 'report_by_months',
])

@section('datatable')
	<div class="row font-size-16">
		@include('reports.table-sellings-users')

		<div class="d-flex justify-content-end">
			<a class="btn btn-primary" href="{{route('report_by_years.getByMonth', $year)}}">
				<i class='bx bx-left-arrow-alt'></i> Regresar
			</a>
		</div>
	</div>

	@include('crud-maker.components.filters', [
			"rows" => [
				["id" => "supplier_name", "name" => "supplier_name", "type" => "text"],
				["id" => "product_name", "name" => "product_name", "type" => "text"],
			], 
			"entity" => "report_by_months",
			"translations" => "report_by_months",
			"type" => "datatable",
		])

	{{ $dataTable->table(["width" => "100%"]) }}
@endsection

@push('styles')
	<style>
		table tfoot th {
			border-bottom: 0;
		}
	</style>
@endpush