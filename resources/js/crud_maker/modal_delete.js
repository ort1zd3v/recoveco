$(function() {
	window.showDeleteModal = (entity, id) => {
		//$('#deleterowForm').attr('action', $('meta[name="app-url"]').attr('content')+"/"+entity+"/"+id);
		
		var title = '';
		var message = '';
		if(window.i18n[entity] !== undefined) {
			title = window.i18n[entity]['title_delete'] ?? '';
			message = window.i18n[entity]['confirm_delete'] ?? '';
		}
		if(title != '') {
			$('#deleterowModal .modal-title').html();
		}
		if(message != '') {
			$('#deleterowModal .alert .alert-message').html(message);
		}
		$('#deleterowModal .button-delete').attr('onclick', `deleteRow('${entity}', ${id})`);
		$('#deleterowModal').modal('show');
	}

	window.deleteRow = (entity, id) => {
		$.ajax({
			url:  $('meta[name="app-url"]').attr('content')+'/'+entity+'/'+id,
			type: 'DELETE',
			dataType: 'json',
			success: function(response) {
				console.log(response);
				$('#deleterowModal').modal('hide');
				displayMessage(response.message, (response.status ? "success" : "danger"));
				window.LaravelDataTables[entity+"-table"].draw();
			}
		}).fail(function(response) {
			//si hubo error en la validación
			if(typeof response.responseJSON.message !== "undefined") {
				var el = $(".message-container");
				displayMessage(response.responseJSON.errors, "danger", el);
			}
		});
	}

	//eliminar venta


	window.showCancelSelling = (id) => {
		//$('#deleterowForm').attr('action', $('meta[name="app-url"]').attr('content')+"/"+entity+"/"+id);
		
		var title = 'Cancelar venta';
		var message = 'Seguro de cancelar la venta?';
		
		if(title != '') {
			$('#deleterowModal .modal-title').html();
		}
		if(message != '') {
			$('#deleterowModal .alert .alert-message').html(message);
		}
		$('#deleterowModal .button-delete').attr('onclick', `cancelSelling(${id})`);
		$('#deleterowModal').modal('show');
	}

	window.cancelSelling = (id) => {
		$.ajax({
			url:  $('meta[name="app-url"]').attr('content')+'/report_by_tickets/cancelSelling/'+id,
			type: 'DELETE',
			dataType: 'json',
			success: function(response) {
				console.log(response);
				$('#deleterowModal').modal('hide');
				displayMessage(response.message, (response.status ? "success" : "danger"));
				window.LaravelDataTables["report_by_tickets-table"].draw();
			}
		}).fail(function(response) {
			//si hubo error en la validación
			if(typeof response.responseJSON.message !== "undefined") {
				var el = $(".message-container");
				displayMessage(response.responseJSON.errors, "danger", el);
			}
		});
	}

});