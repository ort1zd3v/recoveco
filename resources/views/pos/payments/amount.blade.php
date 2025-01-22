<div class="form-group mt-2" id="container_giftcard">
	<label for="giftcard">@lang('pos.gift_card')</label>
	<div class="input-container w-100">
		<input type="text" class="form-control" id="giftcard">
		<span class="clear-input btn btn-danger">
			<i class="fas fa-times"></i>
		</span>
	</div>
</div>
<div class="form-group mt-2 font-size-18">
	<label for="payment_amount">@lang('pos.amount')</label>
	<div class="d-flex gap-2">
		<input type="text" class="form-control p-2 font-size-18" id="payment_amount" placeholder="Ingrese la cantidad">
		<div class="input-container w-100">
			<input type="hidden" class="form-control" id="id_payment_type" readonly>
			<input type="text" class="form-control p-2 font-size-16" id="payment_type" readonly>
			<span class="clear-input btn btn-sm btn-success" id="confirm_payment">
				<i class="fas fa-check font-size-20 p-1"></i>
			</span>
		</div>
	</div>
</div>

<!-- <button id="toggleTabla" class="btn btn-danger">Tabla</button> -->
 