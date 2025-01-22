@extends('crud-maker.layouts.index', [
	'title' => __('report_by_tickets.title_index'), 
	'entity' => 'report_by_tickets', 
	'form' => 'report_by_tickets',
])

@section('datatable')
	<div class="row report-by-tickets-filters mt-2 mb-3">
		@include('crud-maker.components.filters', [
			"rows" => [
				["id" => "initial_date", "name" => "initial_date", "type" => "date"],
				["id" => "final_date", "name" => "final_date", "type" => "date"],
				["id" => "selling_id", "name" => "selling_id", "type" => "text"],
				[
					"id" => "is_active",
					"name" => "is_active",
					"type" => "select",
					"defaultValue" => old("is_active") ?? 0,
					"elements" => ['Todos', 'Activos', 'Cancelados'],
				],
				[
					"id" => "payment_types",
					"name" => "payment_types",
					"type" => "select",
					"defaultValue" => old("payment_types") ?? 0,
					"elements" => $paymentTypes,
				],
				[
					"id" => "created_by",
					"name" => "created_by",
					"type" => "select",
					"defaultValue" => old("created_by") ?? 0,
					"elements" => $users,
				]
			], 
			"entity" => "report_by_tickets",
			"translations" => "report_by_tickets",
			"type" => "datatable",
		])
	</div>
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection

@push('scripts')
	<script>
		$(function() {
			window.getTicket = (sellingId) => {
				$.ajax({
					url: $('meta[name="app-url"]').attr('content')+`/report_by_tickets/getTicket/${sellingId}`,
					type: 'GET',
					success: function(response) {
						$("body").html(response)
						setTimeout(() => {
							window.print()
							location.reload()
						}, 500);
					}
				});
			}	
		})
		
	</script>
@endpush

@push('styles')
	<style>
		table tfoot th {
			border-bottom: 0;
		}
	</style>
@endpush