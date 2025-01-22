@extends('crud-maker.layouts.index', [
	'title' => __('report_by_sellings.title_index'), 
	'entity' => 'report_by_sellings', 
	'form' => 'report_by_sellings',
])

@section('datatable')
	<div class="row report-by-month-filters mt-2 mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["id" => "initial_date", "name" => "initial_date", "type" => "date", "defaultValue" => now()],
				["id" => "final_date", "name" => "final_date", "type" => "date", "defaultValue" => now()],
				["id" => "selling_id", "name" => "selling_id", "type" => "text"],
				["id" => "supplier_name", "name" => "supplier_name", "type" => "text"],
				["id" => "product_name", "name" => "product_name", "type" => "text"],
			], 
			"entity" => "report_by_sellings",
			"translations" => "report_by_sellings",
			"type" => "datatable",
		])
	</div>
	<div id="modal-carga" class="modal2 fade d-none" tabindex="-1" role="dialog" >
		<div class="modal-dialog modal-dialog-centered" role="document">
			<i class="fa fa-spinner fa-spin fa-3x px-3"></i>
			<h2>Descargando excel...</h2>
		</div>
	</div>
	<div class="d-flex justify-content-end">
		<button id="export_excel_sellings" type="submit" class="btn btn-success"><i class='bx bxs-spreadsheet'></i>Exportar reporte personalizado</button>
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