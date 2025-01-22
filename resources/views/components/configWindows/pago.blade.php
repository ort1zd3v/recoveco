<h3>Configuración de pago</h3>
<div class="mb-2">
	<label for="with_cash">@lang('config_payments.with_cash')</label>
	<input type="checkbox" name="with_cash" id="with_cash" {{$configPayments->with_cash == true ? 'checked' : false}}>
</div>
<div class="mb-2">
	<label for="with_credit">@lang('config_payments.with_credit')</label>
	<input type="checkbox" name="with_credit" id="with_credit" {{$configPayments->with_credit == true ? 'checked' : false}}>
</div>
<div class="mb-2">
	<label for="with_gift_card">@lang('config_payments.with_gift_card')</label>
	<input type="checkbox" name="with_gift_card" id="with_gift_card" {{$configPayments->with_gift_card == true ? 'checked' : false}}>
</div>
<div class="mb-2">
	<label for="with_points">@lang('config_payments.with_points')</label>
	<input type="checkbox" name="with_points" id="with_points" {{$configPayments->with_points == true ? 'checked' : false}}>
</div>

<script>
	$("#saveConfig").click(function(){
		var formData = new FormData();
		formData.append('view', 'pago');
		formData.append("data[with_cash]", $("#with_cash").prop('checked'));
		formData.append("data[with_credit]", $("#with_credit").prop('checked'));
		formData.append("data[with_gift_card]", $("#with_gift_card").prop('checked'));
		formData.append("data[with_points]", $("#with_points").prop('checked'));

		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+"/config_pos/saveConfigView",
			type: 'POST',
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response)
				location.reload()
			},
			error: function(response) {
				console.log(response)
			}
		});
	})

</script>