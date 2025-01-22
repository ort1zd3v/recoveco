@extends('crud-maker.layouts.index', [
	'title' => __('report_by_suppliers.title_index'), 
	'entity' => 'report_by_suppliers', 
	'form' => 'report_by_suppliers',
])

@section('datatable')
	<div class="row report-by-day-filters mt-2 mb-3">

		@if (!$year ?? false)
			@include('crud-maker.components.filters', [
				"rows" => [
					["id" => "initial_date", "name" => "initial_date", "type" => "date"],
					["id" => "final_date", "name" => "final_date", "type" => "date"],
					["id" => "supplier_name", "name" => "supplier_name", "type" => "text"],
					[
						"id" => "is_active",
						"name" => "is_active",
						"type" => "select",
						"defaultValue" => old("is_active") ?? 0,
						"elements" => ['Sí', 'No'],
					]
				], 
				"entity" => "report_by_suppliers",
				"translations" => "reports",
				"type" => "datatable",
			])
			<div id="modal-carga" class="modal2 fade d-none" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-dialog-centered" role="document">
					<i class="fa fa-spinner fa-spin fa-3x px-3"></i>
					<h2>Descargando excel...</h2>
				</div>
			</div>
		{{-- {{ Form::open(['id' => 'excekl-export', 'route' => "report_by_suppliers.exportExcel", 'method' => 'POST', 'enctype' => 'multipart/form-data']) }} --}}
			<div class="d-flex justify-content-end">
				<button id="export_excel_suppliers" type="submit" class="btn btn-success"><i class='bx bxs-spreadsheet'></i>Exportar reporte completo personalizado</button>
			</div>
		{{-- {{ Form::close() }} --}}

			
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