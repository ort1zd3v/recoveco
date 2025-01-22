@extends('crud-maker.layouts.index', [
	'title' => __('report_by_tickets.title_index'), 
	'entity' => 'report_by_tickets', 
	'form' => 'report_by_tickets',
])

@section('datatable')
	{{ $dataTable->table(["width" => "100%"]) }}
@endsection

@push('styles')
	<style>
		table tfoot th {
			border-bottom: 0;
		}
	</style>
@endpush