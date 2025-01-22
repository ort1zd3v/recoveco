<div class="d-flex justify-content-evenly align-items-center payment-buttons mt-4">
	@if ($configPayments->with_cash)
		<button type="button" id="payment-1" onclick="selectPayment(1,'Efectivo')" class="btn">
			<img class="img-fluid" src="{{asset('images/cash.png')}}">
		</button>
	@endif
	@if ($configPayments->with_credit)
		<button type="button" id="payment-2" onclick="selectPayment(2,'Tarjeta de crédito')" class="btn">
			<img class="img-fluid" src="{{asset('images/credit-card.png')}}">
		</button>
	@endif
	@if ($configPayments->with_gift_card)
		<button type="button" id="payment-3" onclick="selectPayment(3,'Depósito')" class="btn">
			<img class="img-fluid" src="{{asset('images/gift-card.png')}}">
		</button>
	@endif
	@if ($configPayments->with_points == "true")
		<button type="button" id="payment-4" onclick="selectPayment(4,'Tarjeta de puntos')" class="btn">
			<img class="img-fluid" src="{{asset('images/points.png')}}">
		</button>
	@endif
</div>


@push('styles')
<style>
	#payment-1, #payment-2, #payment-3 {
		width: 100px;
	}
</style>
@endpush