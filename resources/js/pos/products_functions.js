$(function() {
	let dtLang = '';
	var isEnter = false;


	fetch($('meta[name="app-url"]').attr('content')+"/js/datatables/datatables_Spanish.json").then((json) => dtLang = json);
	//Set every tab table as datatable
	$(".table-products").each(function (index, el) {
		let currentTab = $(this).closest(".tab-pane").attr("id");
		window.productDatatables = window.productDatatables ?? {};
		window.productDatatables[currentTab] = $(this).DataTable({
			"pageLength":16,
			"dom":"rtip",
			"responsive":"true",
			"language": dtLang,
			"drawCallback": function() {
				customizeDatatable(false)
			},
			"columns": [
				{"name": "id", "visible": false},
				{"name": "key"},
				{"name": "name"},
				{"name": "price"},
			]
		});
	});

	
	//Retrieve the active category in products
	window.getActiveCategory = () => {
		let r = $("#section-productos .nav-item > button.active").attr("data-bs-target");
		return (r.substring(1, r.length));
	}

	//When user writes down in filter input filter the active table
	$('#section-productos #filter').on("keyup", function() {

		if(!$("#Todos-tab").hasClass("active")) {
			$("#Todos-tab").trigger("click");
		}
		let table = window.productDatatables[getActiveCategory()];
		table.search($(this).val()).draw();

		let filtered = table.rows( { filter : 'applied'} ).data();
		if (filtered["length"] > 0) {
			$(`.productsGrid .product`).addClass("d-none").removeClass('d-inline-block');
			for (let i = 0; i < filtered["length"]; i++) {
				$(`.productsGrid .p-grid-${filtered[i][0]}`).removeClass("d-none").addClass('d-inline-block');
			}
		}
	});

	/** Calculator section */
	//Writhe the given number
	window.addNumber = (target, number) => {
		$(target).val($(target).val() + number)
	}

	//Backspace
	window.offNumber = (target) => {
		$(target).val($(target).val().slice(0, -1))
	}

	/**
	 * selectProduct: When user adds a product to the sale. 
	 * -If product have ingredients display modal to select ingredients
	 * -Else check if product is already in sale to add a new row or only update the amount field
	 * @param Object product 
	 * @param Boolean hasIngredients 
	 */
	window.selectProduct = (param, product, hasIngredients = false) => {
		if (!($(param).attr('disabled'))) {
			$(param).attr('disabled', true)
			product = JSON.parse(window.atob(product));
			let amount = $('#section-productos #amount').val() != "" ? $('#section-productos #amount').val() : 1;
			
			if (!hasIngredients) {
				//CART FUNCTION: existProductInCart 
				//Check if product is already in cart
				let exist = existProductInCart(product.id);
				if (!exist.status) {
					$.ajax({
						url: $('meta[name="app-url"]').attr('content')+`/pos/${product.id}/addcartproduct`,
						type: 'POST',
						data: {amount: amount},
						dataType: 'json',
						success: function(response) {
							$("#table-cart tbody").append(response);
							//CART FUNCTION: setTotal
							$(param).attr('disabled', false);
							setTotal();
						}
					});
				} else {
					//CART FUNCTION: increaseAmount
					$(param).attr('disabled', false);
					increaseAmount($(exist.row).find("input.amount"), amount);
				}
			} else {
				$.ajax({
					url: $('meta[name="app-url"]').attr('content')+`/pos/${product.id}/getingredientsmodal`,
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						$(".ingredients-modal").remove();
						$("#selected_product").val(response.product.id);
						$("body").append(response.content);
						$(".ingredients-modal").first().css('z-index', getModalZIndex()).modal('show');
						$(param).attr('disabled', false);
					}
				});
			}
			$("#amount").val('');
		}
	}

	/**
	 * selectIngredient: When user Select an ingredient from ingredients modal. 
	 * -If product have ingredients display modal to select ingredients
	 * -Else check if product is already in sale to add a new row or only update the amount field
	 * @param DOM object param Ingredient clicked
	 * @param Object product Selected ingredient
	 */
	window.selectIngredient = (param, product) => {
		product = JSON.parse(window.atob(product));
		let id = $(param).closest(".tab-pane").find(".id").val();
		let category_id = $(param).closest(".tab-pane").find(".category_id").val();
		let amount = $(param).closest(".tab-pane").find(".amount").val();
		let pos = $("body").find(".ingredients-modal:first").find("button.active").attr("data-name");
		let val = product.id;


		selectedTab =$(param).closest(".ingredients-modal").find(".ingredients-selected > .active").append(`
		<div onclick="deleteSelectedIngredient(this)" class="ingredient" data-toggle="tooltip" data-placement="top" title="${product.name}">
			<span>x</span>
			<img class="img-fluid w-100" src="${product.url_image == 'no-image.png' ? $('meta[name="app-url"]').attr('content')+"/images/no-image.png" : product.url_image}" style="background-color: ${product.color == "" ? "#26a9e1" : product.color}; aspect-ratio: 1/1">
			<input type="hidden" class="id" value="${id}">
			<input type="hidden" class="category_id" value="${category_id}">
			<input type="hidden" class="amount" value="${amount}">
			<input type="hidden" class="product_id" value="${product.id}">
			<input type="hidden" class="product_name" value="${product.name}">
			<input type="hidden" class="overprice" value="${product.overprice}">
			<input type="hidden" class="pos" value="${pos}">
			<p class="m-0 mt-1 product-text">${product.name}</p>
		</div>`);

		console.log(selectedTab)


		updateAmountIngredients(param);

		
		//Hide current category and show next
		$(param).closest(".tab-pane").removeClass("active").addClass("selected");
		let el = getNextElement($(param).closest(".tab-pane"));
		if (el != null) {
			$(el).addClass("active");
		} else {
			//addPackToSale();
			showNextProductModal(param);
		}
	}

	window.updateAmountIngredients = (param, isDelete = false) => {
		let modal = $(param).closest(".ingredients-modal");
		let tIng = $(modal).find(".ingredients-content #product_ingredients").val();
		let sIng = $(modal).find(".ingredients-content .ingredients-selected .ingredient").length;
		let rIng = parseFloat(tIng) - parseFloat(sIng);
		$(modal).find(".ingredients-content .r-ingredients").html(isDelete ? rIng + 1 : rIng);

	}

	window.getNextElement = (el) => {
		let result = null;
		let next = $(el).next();
		if ($(next).length > 0) {
			if (!$(next).hasClass("selected")) {
				result = next;
			} else {
				result = getNextElement(next);
			}
		}
		return result;
	}

	/**
	 * Remove item from selected list and make active the list to select ingredient again
	 * @param {*} param Selected ingredient to delete
	 */
	window.deleteSelectedIngredient = (param) => {
		updateAmountIngredients(param, true)

		let id = $(param).closest(".ingredient").find(".id").val();
		$(param).closest(".ingredient").remove(); //Remove from selected list
		
		//Make the ingredient we just removed be able to select again
		//and set the first ingredient pane as active
		let cont = $(".ingredients-content .tab-content");
		$(cont).find(".tab-pane").removeClass("active");
		$(cont).find(`#ingredient-${id}`).removeClass("selected");
		$(cont).find("> div:not(.selected)").first().removeClass("active").addClass("active");
	}
	

	window.showNextProductModal = (param) => {
		let modal = $(param).closest(".ingredients-modal");
		$(modal).modal('hide');
		if ($(modal).next().hasClass("ingredients-modal")) {
			$(modal).next().modal('show');
		} else {
			addPackToSale(param);
		}
	}

	window.addPackToSale = (param) => {
		let product_id = $("#selected_product").val();
		let amount = $('#section-productos #amount').val() != "" ? $('#section-productos #amount').val() : 1;
		const uniqueId = $(".modal-body #product_unique_id").val()
		let allIngredients = [];
		$(".ingredients-modal").each(function (index, element) {
			let ingredients = [];
			$(this).find(".ingredients-selected .ingredient").each(function (index, row) {
				let item = {};
				$(this).find("input[type=hidden]").each(function (index, el) {
					item[$(this).attr("class")] = $(this).val();
				});
				ingredients.push(item);
			});

			allIngredients.push({
				product_id: $(this).find("#product_id").val(),
				product_name: $(this).find("#product_name").val(),
				product_ingredients: $(this).find("#product_ingredients").val(),
				ingredients: ingredients,
			});
		});

		let url, data;

		if (uniqueId != false) {
			url = `${product_id}/${uniqueId}/addIngredientProduct`
			amount = $(this).find("#product_amount").val()
			data = {
				amount: amount,
				allIngredients: allIngredients
			}
		}else{
			url = `${product_id}/addcartproduct`
			data = {
				amount: amount,
				allIngredients: allIngredients
			}
		}

		
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+`/pos/${url}`,
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(response) {
				//en caso de que uniqueId sea diferente de false quiere decir que se está llamando desde el edit
				if (uniqueId != false) {
					const buttonId = $("#button_edit_id").val()
					$(`#table-cart tbody`).find(`button[data-id="${buttonId}"]`).closest(`tr[data-parent-id=${uniqueId}]`).remove()
					$(`#table-cart tbody tr[data-unique-id=${uniqueId}]`).after(response);
				}else{
					$("#table-cart tbody").append(response);
				}
				setTotal();
				$(".ingredients-modal").remove();
				$(".modal-backdrop").remove();
			}
		});
	}

	window.editProduct = (param, buttonId) => {
		let ingredients = [];

		const product_id = $(param).closest(".cart-row").data("product-id")
		const product_unique_id = $(param).closest(".cart-row").data("parent-id")
		const amount = $("#table-cart-content tbody").find(`tr[data-unique-id=${product_unique_id}]`).find(".amount").val()

		$(param).closest('.cart-row').find(".ingredients").find(".detail-item").each(function() {
			let item = {};
			$(this).find("input[type=hidden]").each(function (index, el) {
				item[$(this).attr("id")] = $(this).val();
			});
			ingredients.push(item);
		})
		
		const data = {
			product_id: product_id,
			amount: parseInt(amount),
			ingredients: {
				bottom: ingredients.filter(item => item.pos == "Abajo"),
				middle: ingredients.filter(item => item.pos == "En medio"),
				top: ingredients.filter(item => item.pos == "Arriba")
			}
		}
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+`/pos/${product_unique_id}/${buttonId}/updateingredientsmodal`,
			type: 'GET',
			data: data,
			dataType: 'json',
			success: function(response) {
				$(".ingredients-modal").remove();
				$("#selected_product").val(response.product.id);
				$("body").append(response.content);
				$(".ingredients-modal").first().css('z-index', getModalZIndex()).modal('show');
				$(param).attr('disabled', false);
			}
		});


	}

	window.resetIngredients = (param) => {
		let modal = $(param).closest(".ingredients-modal");
		$(modal).find(".ingredients-selected .ingredient").each(function (index, row) {
			$(this).trigger('click')
		});
		$(modal).find('#myTab .nav-link').first().trigger('click')
		selectTab('Abajo-tab')
	}

	window.selectTab = (tabId) => {
		let tab = $(`#${tabId}`);
		tab.trigger("click");
		$(".ingredients-selected").find('.tab-ingredients').each(function()  {
			$(this).removeClass('active')
		})
		$(`.tab-ingredients[data-tab=${tabId}]`).addClass("active")
	}


	//Busca por codigo de barras o nombre de producto via ajax
	window.searchProducts = (param, addFirstProduct = false) => {
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+`/pos/search/${param}`,
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				console.log(response)
				if (response) {
					let counter = 0;
					$("#message-search-scan").addClass('d-none').removeClass('d-block')
					$("#pos-products-table-body").html('')
					response.forEach((element, index) => {
						if ($("#with_inventory").prop('checked')) {
							if (element.amount > 0) {
								addProduct(element, counter, addFirstProduct)
								counter++
							}
						}else{
							addProduct(element, index, addFirstProduct)
						}
						
					});
				}
			}
		});
	}

	$("#with_inventory").on('change', () => {
		let filter = $("#filter").val();
		searchProducts(filter)
	})

	function addProduct(element, index, addFirstProduct) {
		const rowClass = index % 2 === 0 ? 'product-table-row even' : 'product-table-row odd';
		$("#pos-products-table-body").append(`
		<tr class="${rowClass}" data-id="${element.id}" onclick="selectProduct(this, '${btoa(JSON.stringify(element))}')">
			<td>${element.supplier_name} - ${element.barcode}</td>
			<td>${element.amount}</td>
			<td>${element.name}</td>
			<td class='text-end'>$${element.price_base.toFixed(2).toLocaleString()}</td>
		</tr>
		`);

		if (index == 0 && addFirstProduct) {
			$("#pos-products-table-body tr").first().trigger('click')
			$("#filter").val('')
		}
	}

	//Evento para detectar cuando pulsa enter
	$('#filter').off('keyup').on('keyup', function(event) {
		let filter = $("#filter").val();
		if (event.keyCode === 13) {
			searchProducts(filter, true)
		}
	});

	$("#btnSearch").on('click', () => {
		let filter = $("#filter").val();
		searchProducts(filter)
	})

	$("#btnClearSearch").on('click', () => {
		$("#pos-products-table-body").html('')
		$("#filter").val('')
		$("#message-search-scan").removeClass('d-none').addClass('d-block')
	})
	
	
	//Products: Select first tab
	$("#section-productos .nav-tabs .nav-link").first().trigger("click");

});