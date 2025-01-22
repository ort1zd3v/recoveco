<div id="table-payment-container">
	<table class="table" id="table-payments">
		<thead>
			<tr>
				<th>@lang('config_payments.type')</th>
				<th>@lang('config_payments.amount')</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>
<div class="row font-size-18">
	<div class="col-4 form-group mt-2">
		<label>@lang('config_payments.total'):</label>
		<div>
			<input id="payment_total" type="text" class="d-none">
			<input id="payment_total_text" type="text" class="form-control font-size-18 text-end" placeholder="total" readonly>
		</div>
	</div>
	<div class="col-4 form-group mt-2">
		<label>@lang('config_payments.missing'):</label>
		<div>
			<input id="missing_total_value" type="hidden">
			<input id="missing_total" type="text" class="form-control font-size-18 text-end" placeholder="Faltante" readonly>
		</div>
	</div>
	<div class="col-4 form-group mt-2">
		<label>@lang('config_payments.shift'):</label>
		<div>
			<input type="text" class="form-control font-size-18 text-end" id="shift" placeholder="Cambio" readonly>
		</div>
	</div>
</div>

@push('styles')
<style>
	#table-payment-container {
		position: absolute;
		left: -9999px;
	}
</style>
@endpush




<!-- <div id="table-payment-container" class="p-1">
	<table class="table" id="table-payments">
		<tbody>
			<tr>
				<th>@lang('config_payments.type')</th>
				<th>@lang('config_payments.amount')</th>
				<th></th>
				<th>@lang('config_payments.total'):</th>
				<th>@lang('config_payments.missing'):</th>
				<th>@lang('config_payments.shift'):</th>
			</tr>
			<tr>
				<td>
					<input type="text" class="form-control font-size-18 text-end" id="payment_type" placeholder="Tipo" readonly>
				</td>
				<td>
					<input type="text" class="form-control font-size-18 text-end" id="payment_amount" placeholder="Cantidad" readonly>
				</td>
				<td></td>
				<td>
					<input id="payment_total" type="text" class="form-control font-size-18 text-end" placeholder="Total" readonly>
				</td>
				<td>
					<input id="missing_total" type="text" class="form-control font-size-18 text-end" placeholder="Faltante" readonly>
				</td>
				<td>
					<input type="text" class="form-control font-size-18 text-end" id="shift" placeholder="Cambio" readonly>
				</td>
			</tr>
		</tbody>
	</table>
</div> -->

<!-- <div class="row font-size-18">
    <div class="col-4 form-group mt-2">
        <label>@lang('config_payments.type')</label>
    </div>
    <div class="col-4 form-group mt-2">
        <label>@lang('config_payments.amount')</label>
    </div>
    <div class="col-4 form-group mt-2">
        <label></label>
    </div>
</div>
<div class="row font-size-18">
    <div class="col-4 form-group mt-2">
        <input id="payment_total" type="text" class="d-none">
        <input id="payment_total_text" type="text" class="form-control font-size-18 text-end" placeholder="total" readonly>
        <label>@lang('config_payments.total'):</label>
    </div>
    <div class="col-4 form-group mt-2">
        <input id="missing_total_value" type="hidden">
        <input id="missing_total" type="text" class="form-control font-size-18 text-end" placeholder="Faltante" readonly>
        <label>@lang('config_payments.missing'):</label>
    </div>
    <div class="col-4 form-group mt-2">
        <input type="text" class="form-control font-size-18 text-end" id="shift" placeholder="Cambio" readonly>
        <label>@lang('config_payments.shift'):</label>
    </div>
</div> -->
