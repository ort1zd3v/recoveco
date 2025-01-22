@extends('layouts.app', [
	'title' => __('starting_founds.title_show'), 
])
@section('content')
<input type="hidden" id="starting_found_id" value="{{$starting_found->id}}">
<div class="card p-3 text-center">
	<div>
		<img class="logo mx-auto d-block" src="{{asset('')}}/{{$configTicket->url_logo}}" alt="">
	</div>
	<br>
	<div class="info">
		<div class="header">
			{!! $configTicket->header !!}
		</div>
		<div class="text-center">
			<p>Atendió: {{$user->name}}</p>
			<p>Fecha: {{date("d/m/Y h:i A")}}</p>
		</div>
	</div>

	<div class="container">
		<div class="row font-size-16">
			<div class="d-flex gap-2">
				<p>@lang('starting_founds.starting_found')</p>
				<p class="text-success"><b>${{number_format($starting_found->amount, 2)}}</b></p>
			</div>
			
			@include('reports.table-sellings-users')

			@php
				$total = $starting_found->amount;
			@endphp
			@foreach ($totalPayments as $key => $payments)
				@php
					$total += $payments->sum('total_amount')
				@endphp
			@endforeach
			<p class="mt-2">Total con fondo de caja: <b>${{number_format($total,2)}}</b></p>
		</div>

		<hr>
		<div class="w-100">
			<p class="font-size-16 mb-0">@lang('starting_founds.selling_product')</p>
			<table class="table" id="table-report">
				<thead>
					<th>@lang('products.supplier_id')</th>
					<th>@lang('starting_founds.description')</th>
					<th class="text-center">@lang('starting_founds.quantity')</th>
					<th class="text-end">@lang('starting_founds.import')</th>
					<th class="text-end">@lang('suppliers.commission_percentage')</th>
					<th class="text-end">@lang('suppliers.commission_shop')</th>
					<th class="text-end">@lang('suppliers.commission_supplier')</th>

				</thead>
				<tbody>
					@foreach($sellingProducts as $sp)
						<tr>
							<td class="text-start">{{ optional($sp->product->supplier)->id ? $sp->product->supplier->id . " - " : "" }}	{{$sp->product->supplier->name ?? "N/A"}}</td>
							<td class="text-start">{{$sp->product->name}}</td>
							<td class="text-center">{{$sp->total_amount}}</td>
							<td class="text-end">${{number_format($sp->total_product_amount, 2)}}</td>
							<td class="text-center">{{$sp->commission_percentage}}%</td>
							<td class="text-end">${{number_format((($sp->commission_percentage * $sp->total_product_amount) / 100), 2)}}</td>
							<td class="text-end">${{number_format($sp->total_product_amount - ($sp->commission_percentage * $sp->total_product_amount / 100), 2)}}</td>

						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@if($starting_found->final_date == null)
				<div class="d-flex gap-2">
					<button type="bbutton" id="closeDay" class="btn btn-primary">@lang('starting_founds.close_day')</button>
					@include("crud-maker.components.form-row", ["params" => [
						[
							"name" => "final_user_id",
							"id" => "final_user_id",
							"class" => "form-select",
							"entity" => "starting_founds",
							"type" => "select",
							"elements" => $users,
							"defaultValue" => auth()->id() ?? "",
							"required" => "true",
						]
					]])
				</div>
		@endif
	</div>
</div>


@endsection

@push('styles')
	<style>
		.info h1,.info h2,.info h3,.info h4,.info h5,.info h6,.info p{
			margin: 0px;
			padding: 0px;
		}
		.logo {
			max-width: 100px;
			width: 40%;
		}

		.dt-buttons.btn-group {
			display: flex;
			width: 400px;
		}
	</style>
@endpush

@push('scripts')
	<script>
		$(function() {
			const starting_found_id = $("#starting_found_id").val()
			let data = {
				"final_user_id": $("#final_user_id").val()
			};

			$("#closeDay").click(function() {
				$.ajax({
				url: `{{ route('starting_founds.closeDay', $starting_found->id) }}`,
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function(response) {
					if (response.status) {
						$("body").html(response.data)
						Swal.fire({
							title: 'Cierre exitoso.',
							text: 'Se realizó el cierre correctamente.',
							icon: 'success',
							allowOutsideClick: false,
							allowEscapeKey: false,
							allowEnterKey: true,
							focusConfirm: true,
							timer: 500
						}).then(function() {
							setTimeout(() => {
								window.print()
								location.reload()
							}, 500);
						});
						
					} else {
						Swal.fire({
							title: 'Error en el cierre.',
							text: response.message,
							icon: 'error',
							allowOutsideClick: false,
							allowEscapeKey: false,
							allowEnterKey: true,
							focusConfirm: true
						});
					}
				},
				error: function(response) {
					console.log("error")
				}
			});
			})

			window.productDatatables = $("#table-report").DataTable({
				"pageLength":-1,
				"dom":"fBrtip",
				"responsive":"true",
				"language":{"url": $('meta[name="app-url"]').attr('content')+"/js/datatables/datatables_Spanish.json"},
				"drawCallback": function() {
					customizeDatatable(false)
				},
				"footerCallback": function() {
					footerCustomize([3,5,6], this.api(), [3,5,6])
				},
				"columns": [
					{"name": "supplier"},
					{"name": "name"},
					{"name": "amount"},
					{"name": "import"},
					{"name": "commission_percentage"},
					{"name": "commission_shop"},
					{"name": "commission_supplier"},
				],
				"buttons": [
					{'extend' : 'colvis', 'text' : 'Mostrar/Ocultar Columnas', 'className' : 'btn btn-primary'},
					{'extend' : 'excel', 'text' : '<i class="fas fa-file-excel"></i> Exportar a excel', 'className' : 'btn btn-success'},
				],
			});
		});
	</script>
@endpush