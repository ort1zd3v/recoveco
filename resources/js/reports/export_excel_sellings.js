
$(function() {
	$("#export_excel_sellings").on('click', () => {

		data = {
			'initial_date': $("#initial_date").val(),
			'final_date': $("#final_date").val(),
			'supplier_name': $("#supplier_name").val(),
			'product_name': $("#product_name").val(),
			'selling_id': $("#selling_id").val(),
		}

		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+`/report_by_sellings/exportExcel`,
			method: 'GET',
			data: data,
			xhrFields: {
				responseType: 'blob' // Indicar que la respuesta es un archivo binario
			},
			beforeSend: function () {
				//Mostrar el spinner antes de mandar la petición 
				$('#modal-carga').modal('show');
				$("#modal-carga").removeClass("d-none");
			},
			success: function(data) {
				// Crear un enlace temporal para descargar el archivo
				var url = window.URL.createObjectURL(data);
				var a = document.createElement('a');
				a.href = url;
				a.download = 'reporte_ventas.xlsx'; // Nombre del archivo
				document.body.appendChild(a);
				a.click();

				$('#modal-carga').modal('hide');
			}
		});
	})
});