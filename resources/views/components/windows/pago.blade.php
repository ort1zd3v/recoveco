<div id="payment-content" class="container p-2 border">
	<div class="bg-white p-2 pb-5">
		{{-- Client --}}
		<div class="d-none">
			@include('pos.payments.client')
		</div>

		<div class="row mb-2">
			<div class="col-12">
				<div class="row">
					{{-- payment amount input --}}
					<div class="col-6">
						@include('pos.payments.amount')
					</div>

					{{-- Payment types --}}
					<div class="col-6">
						@include('pos.payments.payment-buttons')
					</div>
				</div>

				<div class="row">
					{{-- ON SCREEN KEYBOARD --}}
					<!-- <div class="col-6">
                        @include('pos.payments.keyboard')
                    </div> -->

					{{-- Payments table --}}
					<div class="col-11">
						@include('pos.payments.payments-table')
					</div>
				</div>
			</div>
		</div>


		{{-- Action buttons --}}
		<div class="d-flex justify-content-between">
			<button id="toggleTabla" class="btn btn-danger mx-2">Mostrar Tabla</button>

			<button type="button" data-bs-dismiss="modal" class="btn btn-danger p-1 font-size-15" style="width: 200px">
				@lang('Cancel')
			</button>
			<button type="button" data-bs-dismiss="modal" onclick="cancel()" class="btn btn-danger p-1 font-size-15 mx-2" style="width: 200px">
				@lang('config_payments.cancel_selling')
			</button>
			<button type="button" onclick="cancelPayments()" class="btn btn-danger p-1 font-size-15 mx-2" style="width: 200px">
				@lang('config_payments.cancel_payment')
			</button>
			<button type="button" id="pay" class="btn button-add p-1 font-size-18 mx-2" style="width: 200px">
				@lang('config_payments.pay')
			</button>
		</div>

	</div>
</div>