@extends('crud-maker.layouts.index', [
	'title' => __('inventories.title_index'), 
	'entity' => 'inventories', 
	'form' => 'inventory',
])

@section('datatable')

	<div class="mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["id" => "supplier_name", "name" => "supplier_name", "type" => "text"],
				["id" => "product_name", "name" => "product_name", "type" => "text"],
			], 
			"entity" => "inventories",
			"translations" => "inventories",
			"type" => "datatable",
		])
	</div>
	<div id="modal-carga" class="modal2 fade d-none" tabindex="-1" role="dialog" >
		<div class="modal-dialog modal-dialog-centered" role="document">
			<i class="fa fa-spinner fa-spin fa-3x px-3"></i>
			<h2>Cargando inventario...</h2>
		</div>
	</div>
	<div class="d-flex justify-content-end mb-2">
		<div class="row">
			<div class="col-6">
				<form id="excel_file_inventories">
					<input class="form-control form-control d-inline" name="file_input" id="file_input" type="file" accept=".xlsx">
				</form>
			</div>
			<div class="col-6">
				<button id="import_excel_inventories" type="button" class="btn btn-success w-100"><i class='bx bxs-spreadsheet'></i>Importar desde excel</button>
			</div>
		</div>
	</div>

	{{ $dataTable->table(["width" => "100%"]) }}
@endsection