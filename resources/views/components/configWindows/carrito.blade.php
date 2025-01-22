<h3>Configuración de carrito</h3>
<div class="mb-2">
	<label for="pay_inline">@lang('config_carts.pay_inline')</label>
	<input type="checkbox" name="pay_inline" id="pay_inline" {{$configCarts->pay_inline == true ? 'checked' : false}}>
</div>
<div class="mb-2">
	<label for="in_modal">@lang('config_payments.in_modal')</label>
	<input type="checkbox" name="in_modal" id="in_modal" {{$configCarts->in_modal == true ? 'checked' : false}}>
</div>

<script>
	$("#saveConfig").click(function(){
		var formData = new FormData();
		formData.append('view', 'carrito');
		formData.append("data[pay_inline]", $("#pay_inline").prop('checked'));
		formData.append("data[in_modal]", $("#in_modal").prop('checked'));

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