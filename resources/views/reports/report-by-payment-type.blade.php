@extends('crud-maker.layouts.index', [
	'title' =>	"Reporte por tipos de pago", 
	'entity' => 'report_by_payment_types', 
	'form' => 'report_by_payment_types',
])

@section('datatable')
	<div class="row report-by-month-filters mt-2 mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["id" => "initial_date", "name" => "initial_date", "type" => "date", "defaultValue" => now()],
				["id" => "final_date", "name" => "final_date", "type" => "date", "defaultValue" => now()]
			], 
			"entity" => "report_by_payment_types",
			"translations" => "reports",
			"type" => "datatable",
		])
	</div>

	<div id="chart"></div>
	{{ $dataTable->table(["width" => "100%"]) }}
		
@endsection

@push('scripts')
	<script src="{{ asset('js/echarts/echarts.min.js') }}"></script>
	<script src="{{ asset('js/echarts/chart-report_payment_types.js') }}"></script>
	<script>
		$(function() {
			$("#btn-search-report_by_payment_types").trigger('click')
		})
	</script>
@endpush
@push('styles')
	<style>
		table tfoot th {
			border-bottom: 0;
		}

		#chart {
			position: relative;
			height: 50vh;
			overflow: hidden;
		}
	</style>
@endpush