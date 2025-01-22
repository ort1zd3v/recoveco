$(function() {
	$("#import_excel_inventories").on('click', () => {

		var result = true;
		$("#file-message").addClass('d-none');

		//Get form data and delete empty fields
		var data = new FormData(document.getElementById("excel_file_inventories"));
		
		for (var value of data.entries()) {
			if(value[0] == "file_input") {
				if(value[1]["type"] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
					$("#file-message").removeClass('d-none').find(".alert").html("El archivo seleccionado no es un archivo excel válido");
					result = false;
				}
			}
		}

		if(result) {
			$.ajax({
				url: $('meta[name="app-url"]').attr('content')+'/inventories/insertOrUpdateInventory',
				type: 'POST',
				data: data,
				contentType: false,
				processData: false,
				dataType: 'json',
				beforeSend: function () {
					$('#modal-carga').modal('show');
					$("#modal-carga").removeClass("d-none");
                },
				success: function(response) {
					$('#modal-carga').modal('hide');
					Swal.fire({
						title: response.message,
						html: `Porductos con inventario modificado: ${response.inventories.updated } <br>Productos agregados: ${response.inventories.added}`,
						icon: response.icon,
	
					})
				}
			});
		}
		return result;


	})
});