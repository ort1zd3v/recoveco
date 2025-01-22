$(function() {
	var route = $("#route").val();

//region CRUD
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	window.addRow = function(amount = null) {
		var data = {
			"rowNumber": parseFloat($(".table-body .row").length)+1,
			"amount": amount
		};
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+"/"+route+"/addrow",
			type: "GET",
			dataType: 'json',
			data: data,
			success: result => {
				$(".table-body").append(result);
				
				$(".table-body input[type=text]").keyup(function() {
					validateRow($(this));
				});

				if(typeof inputAddSettings === "function") {
					inputAddSettings();
				}
			}
		});
	}

	window.saveAll = function() {
		$(".table-body .row").each(function(index, el) {
			if($(el).find(".btn-unsaved").hasClass("d-inline")) {
				saveRow($(el).find(".btn-save"));
			}
		});
	}

	window.saveRow = function(param) {
		let row = $(param).closest(".table-row");
		let id = $(row).find("input[name=id]").val();
		let data = {};
		$(row).find(".row-input").each(function(index, el) {
			data[$(el).attr("name")] = $(el).val();
		});
		data["isAJAXRequest"] = "true";
		console.log(data);

		if(id == "") {
			$.ajax({
				url: $('meta[name="app-url"]').attr('content')+"/"+route,
				type: "POST",
				data: data,
				dataType: 'json',
				success: result => {
					if(result["status"]) {
						console.log(result["data"]["id"]);
						$(row).find("input[name=id]").val(result["data"]["id"]);
						$(row).find(".btn-unsaved").removeClass("d-inline").addClass("d-none");
						$(row).find(".btn-saved").removeClass("d-none").addClass("d-inline");
						clearErrorMessages(row);
					}
				}
			}).fail(function(response) {
				//si hubo error en la validación
				if(typeof response.responseJSON.message !== "undefined") {
					showValidationError(response.responseJSON.errors, row);
				}
			});
		} else {
			$.ajax({
				url: $('meta[name="app-url"]').attr('content')+"/"+route+"/"+id,
				type: "PUT",
				data: data,
				dataType: 'json',
				success: result => {
					if(result["status"]) {
						console.log(result["data"]["id"]);
						$(row).find("input[name=id]").val(result["data"]["id"]);
						$(row).find(".btn-unsaved").removeClass("d-inline").addClass("d-none");
						$(row).find(".btn-saved").removeClass("d-none").addClass("d-inline");
						clearErrorMessages(row);
					}
				}
			});
		}
	}

	window.deleteRow = function(param) {
		let row = $(param).closest(".table-row");
		let id = $(row).find("input[name=id]").val();
		if(id != "") {
			if(confirm("Este registro ya ha sido guardado, se borrará de la base de datos")) {
				$.ajax({
					url: $('meta[name="app-url"]').attr('content')+"/"+route+"/deleteAJAX/"+id,
					type: "DELETE",
					dataType: 'json',
					success: result => {
						removeRowElement(param);
					}
				});
			}
		} else {
			//console.log("Tiene cambios no guardados");
			removeRowElement(param);
		}
	}

	window.removeRowElement = function (param) {
		$(param).closest(".table-row").remove();
		if(typeof deleteRowAditionals === "function") {
			deleteRowAditionals();
		}
	}
//endregion CRUD



//region validations
	/**
	 * [Evento que se ejecuta cuando se escribe algo en los input generales]
	 */
	$(".table-body input[type=text]").keyup(function() {
		validateRow($(this));
	});

	/**
	 * [autocompleteAditionals Función que se ejecuta cuando se selecciona una opción del dropdown]
	 */
	window.autocompleteAditionals = function(param) {
		validateRow($(param));
	}

	/**
	 * [datepickerSelect Función que se ejecuta cuando se selecciona una fecha del datepicker]
	 */
	window.datepickerSelect = function() {
		$('.datetimepicker2').on("change.datetimepicker", (e) => {
			validateRow(e.currentTarget);
		});
	}

	/**
	 * [validateRow Revisa cada campo en el row que se esté editando
	 * y si al menos 1 tiene datos muestra el ícono de que no se ha guardado]
	 */
	window.validateRow = function(param) {
		let row = $(param).closest(".table-row");
		let allEmpty = true;
		
		clearErrorMessages(row);
		$(row).find(".row-input").each(function(index, el) {
			if($(el).val() != "") {
				allEmpty = false;
				return;
			}
		});
		if(!allEmpty) {
			$(row).find(".btn-unsaved").removeClass("d-none").addClass("d-inline");
			$(row).find(".btn-saved").removeClass("d-inline").addClass("d-none");
		}
		else {
			$(row).find(".btn-unsaved").removeClass("d-inline").addClass("d-none");
		}
	}

	/**
	 * [showValidationError Muestra mensaje de error debajo del input correspondiente]
	 */
	window.showValidationError = function(message, row) {
		$.each(message, function(index, val) {
			$(row).find("."+index+"-error").html(val);
		});
	}

	/**
	 * [clearErrorMessages Quita todos los mensajes de error del row que se esté editando]
	 */
	window.clearErrorMessages = function(row) {
		$(row).find(".validation-error").html("");
	}
//endregion validations



	/**
	 * [autocompleteLoad Crea un componente autocomplete dropdown]
	 */
	window.autocompleteLoad = function() {
		$( ".input-autocomplete" ).comboboxUI();
		$( "#toggle" ).on( "click", function() {
			$( ".input-autocomplete" ).toggle();
		});
	}

	/**
	 * [inputAddSettings Esta función se encarga de cargar las funcionalidades de los input 
	 * (datepicker, dropdown, etc)]
	 * Se manda llamar también después de que se agrega un nuevo row
	 */
	window.inputAddSettings = function() {
		loadDateTimePicker();
		datepickerSelect();
		//autocompleteLoad();
	}

	inputAddSettings();
});