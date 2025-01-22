@if ($configCarts->in_modal)
<!-- <div class="mb-2 d-flex justify-content-between">
	<div class="d-flex">
		<button id="config_view_tile" type="button" class="btn button-add configView px-4 font-size-18" onclick="showPaymentModal(this)">
			@lang('config_carts.pay')
		</button>
		<input type="hidden" id="total_value">
		<input type="text" class="total form-control mx-2 font-size-16 text-end" readonly>
	</div>
	<button type="button" onclick="cancel()" class="btn button-add px-3 font-size-18">@lang('config_carts.cancel_sale')</button>
</div> -->
<!-- <button id="toggleTabla" class="btn btn-danger">Tabla</button> -->
@endif

<div id="table-cart-content">
	<table id="table-cart" class="table">
		<thead class="thead">
			<tr>
				<th></th>
				<th>@lang('config_carts.nr')</th>
				<th>@lang('config_carts.name')</th>
				<th>@lang('config_carts.amount')</th>
				<th>@lang('config_carts.unit_price')</th>
				<th>@lang('config_carts.total')</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>

@if ($configCarts->pay_inline)
@include('components.windows.pago')
@endif

@if ($configCarts->in_modal)
<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content border-0">
			<div class="modal-header" style="background-color: rgb({{$template->datatables_header_backround_color}})">
				<h5 class="modal-title" id="paymentModalLabel" style="color:  {{$template->datatables_header_font_color}}">@lang('config_carts.pay')</h5>
				<a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
			</div>
			<div class="modal-body">
				@include('components.windows.pago')
			</div>

		</div>
	</div>
</div>
@endif


@push('styles')
<style>
	@if ($configCarts->pay_inline) #table-cart-content {
		height: 58vh;
	}

	#payment-content {
		height: 50vh;
	}

	@else #table-cart-content {
		height: 80vh;
	}

	@endif
</style>
@endpush