$(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		}
	});

	window.displayMessage = function(message, alertType = "info", el = false) {
		var content = getMessageAlert(message, alertType);

		if(content != "") {
			if(el == false) {
				el = $(".message-container");
			}

			el.html(content);
		}
	}

	window.getMessageAlert = function(message, alertType = "info") {
		var content = '';
		if(typeof message === "object") {
			$.each(message, function(index, val) {
				content += `<div class="alert alert-${alertType} dismissible">${val[0]}</div>`;
			});
		} else if (typeof message === "string") {
			content = `<div class="alert alert-${alertType} dismissible">
				<button type="button" class="btn btn-default" data-bs-dismiss="alert" aria-label="Close">
					<i class="mdi mdi-window-close icon-edit font-size-18"></i>
				</button>
				${message}
			</div>`;
		}

		return content;
	}

	/**
	 * [displayOther Muestra el campo otro cuando se selecciona la opción correspondiente]
	 * @param  {[type]} param  [Elemento desde donde se seleciona]
	 * @param  {[type]} option [Id que hará que se despliegue el campo otro]
	 * @param  {[type]} target [id del elemento de destino]
	 */
	window.displayOther = function(param, option, target) {
		console.log($(param).val());
		if($(param).val() == option) {
			$(param).prop("required", true);
			$("."+target+"_container").show();
			$("#"+target).prop("required", true);
		} else {
			$(param).prop("required", false);
			$("."+target+"_container").hide();
			$("#"+target).prop("required", false);
		}
	}
});