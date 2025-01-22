$(function() {
	//$('#container_points').hide();
	$('#container_giftcard').hide();
	
	window.addNumberPayment = (number) => {
		$("#payment_amount").val($("#payment_amount").val() + number)
	}

	window.offNumberPayment = () => {
		$("#payment_amount").val($("#payment_amount").val().slice(0, -1))
	}

	window.selectPayment = (id, type) => {
		$("#id_payment_type").val(id)
		$("#payment_type").val(type)

		$('#container_giftcard').hide('fast')
		//$('#container_points').hide('fast')
		
		if (id == 3) {
			// $('#container_giftcard').show('slow')
		}
		if (id == 4) {
			//$('#container_points').show('slow')
		}
	}

	window.showAlert = (title, message, type = 'warning') => {
		Swal.fire(
			title,
			message,
			type
		)
	}

	window.addPayment = () => {
		let total = parseFloat($("#payment_amount").val());
		let payment_type = $("#payment_type").val();
		let payment_type_type_id = $("#id_payment_type").val();
		let paymentTotal = parseFloat($("#payment_total").val());
		let missingTotal = parseFloat($("#missing_total_value").val());
		
		total = isNaN(total) ? 0 : total;
		
		let isValid = true;
		//#region validations
		if ($("#payment_type").val() == "") {
			showAlert('Error', 'Seleccione el tipo de pago.');
			isValid = false;
		}

		if (total == 0 && isValid) {
			showAlert('Cantidad no válida', 'La cantidad a pagar no puede ser cero.');
			isValid = false;
		}

		if (payment_type_type_id == 4 && isValid) {
			let client_points = parseFloat($("#container_points #client_points").val());
			let min_required = parseFloat($("#container_points #min_required").val());
			client_points = isNaN(client_points) ? 0 : client_points;
			min_required = isNaN(min_required) ? 0 : min_required;
			
			if ($("#container_points #client_id").val() == "") {
				showAlert('Cliente no válido', 'No ha seleccionado un cliente válido.');
				isValid = false;
			}

			if (total > client_points && isValid) {
				showAlert('Puntos insuficientes', 'La cantidad de puntos a gastar no es válida.');
				isValid = false;
			}

			if (total < min_required && isValid) {
				showAlert('Cantidad no válida', 'La cantidad de puntos a gastar no puede ser menor a '+min_required+'.');
				isValid = false;
			}
		}

		if (payment_type_type_id != 1 && total > missingTotal && isValid) {
			showAlert('Cantidad no válida', 'No se puede usar más del dinero faltante.');
			isValid = false;
		}
		//#endregion



		if (isValid) {
			let existCash = false;
			$("#table-payments tbody tr .paymentValues").each(function() {
				if($(this).find('.payment_type_value').val() == 1 && payment_type_type_id == 1){
					existCash = true;
					let amount = $(this).find('.payment_amount_value')
					amount.val(parseFloat(total) + parseFloat(amount.val()))
					const paymentAmount = $(this).parent().find('.payment_amount')
					paymentAmount.text(`$${parseFloat(amount.val()).toFixed(2)}`)
				}
			})

			if (!existCash) {
				$("#table-payments").append(
					`<tr class='font-size-18' style="vertical-align: middle">
						<td class="d-none paymentValues">
							<input class="payment_type_value" type="hidden" value="${payment_type_type_id}">
							<input class="payment_amount_value" type="hidden" value="${total}">
						</td>
						<td>${payment_type}</td>
						<td class="payment_amount text-end">$${total.toFixed(2)}</td>
						<td><button type="button" class="btn btn-danger btn-sm delete-payment p-2"><i class="fas fa-times font-size-22"></i></button></td>
					</tr>`
				);
			}
			
			calculateMissing();
			//$("#payment_amount").val("");
			//$("#payment_type").val("");
		}
	}
	
	window.calculateMissing = () => {
		let total = parseFloat($("#payment_total").val());
		let mTotal = parseFloat(total) - getTotalPayment();
		$("#payment_total_text").val(`$${total.toFixed(2)}`)
		$("#missing_total").val(`$${(mTotal >= 0) ? mTotal.toFixed(2) : 0}`);
		$("#missing_total_value").val((mTotal >= 0) ? mTotal.toFixed(2) : 0);
		$("#shift").val(`$${(mTotal * -1) >= 0 ? (mTotal * -1).toFixed(2) : 0}`);

		$("#payment_amount").val('');
		selectPayment(1,'Efectivo');
	}

	window.getTotalPayment = () => {
		let result = 0;
		$("#table-payments tr .payment_amount_value").each(function() {
			result += parseFloat($(this).val())
		})
		return result
	}
	
	window.getSalePayments = () => {
		let result = [];

		$("#table-payments tbody tr").each(function(){
			const paymentType = $(this).find('.payment_type_value').val()
			const paymentAmount = $(this).find('.payment_amount_value').val()
			result.push({"payment_type_id": paymentType, "amount": paymentAmount})
		});
		return result;
	}

	//de ser posible mejor cambiarlo a una función al onclick del elemento
	$("body").on('click','.delete-payment', function() {
		$(this).closest('tr').remove()
		calculateMissing()
	});

	$("#confirm_payment").on("click", function(){
		addPayment();
	});

	$("#pay").on("click", function() {
		saveSale();
	});

	selectPayment(1, 'Efectivo')
});