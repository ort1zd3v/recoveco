$(function() {
	window.selectProduct = (product, amount, ingredients) => {
		product = JSON.parse(atob(product))
		if (amount == "") amount = 1

		const {id, name, price_base} = product;
		const dataProduct = btoa(JSON.stringify({id, name, price_base}))
		let productExistsInCart = false

		$("#table-cart tbody tr").each(function(){
			const data = ($(this).data('product'));
			if (data == dataProduct) {
				productExistsInCart = true
				const amountInput = $(this).find("input.amount")
				amountInput.val(parseInt(amountInput.val()) + parseInt(amount)) 
				updateTotal(amountInput)
				$(this)[0].animate({
					"transform": "scaleY(1.15)"
				}, 150, function() {
					$(this).animate({
						"transform": "scaleY(1)"
					}, 150);
				});
			}
		})
		
		if (!productExistsInCart) {
			let element = $(`<tr data-product='${dataProduct}' class="product-row">
				<td>
					<button type="button" class='btn btn-danger' onclick="deleteProduct(this)">X</button>
				</td>
				<td>${product['name']}</td>
				<td>
					<div class="input-group">
						<div class="input-group-prepend">
							<button type="button" class="btn btn-primary" onclick="decreaseAmount(this)">-</button>
						</div>
						<input class="form-control amount" type="number" value="${amount}" min="1" max="100">
						<div class="input-group-append">
							<button type="button" class="btn btn-primary" onclick="increaseAmount(this)">+</button>
						</div>
					</div>
				</td>
				<td class="price">${product['price_base']}</td>
				<td class="subTotal">${product['price_base'] * amount}</td>
			</tr>`)

			element.hide()
			$("#table-cart tbody").append(element)
			element.fadeIn('slow')
		}

		$("#amount").val("")
		setTotal()
	}

	window.deleteProduct = (param) => {
		$(param).closest('.product-row').remove()
		setTotal()
	}

	window.setTotal = () => {
		let total = 0;
		$(".subTotal").each(function() {
			total += parseInt($(this).text());
		})
		$(".total").val(total)
		$("#missing_total").val(total - totalPayment())
		$("#shift").val($("#missing_total").val() * -1)
	}

	window.cancel = () => {
		$("#table-cart tbody").empty()
		$("#table-payments tbody").empty()
		setTotal()
	}

	

	


	// <tr class="comments product-${rnd}">
	// 				<td colspan="5">
	// 					<ul>
	// 						<li>Característica 1</li>
	// 						<li>Característica 2</li>
	// 						<li>Característica 3</li>
	// 					</ul>
	// 				</td>
	// 		</tr>
});