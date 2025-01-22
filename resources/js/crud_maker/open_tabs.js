//Código adicional
var entity = $("#entity").val();
var form = $("#form").val();
//Al cargar la pantalla revisar si tiene el parámetro de usuario en la url tipo query string, 
//busca la información del usuario y abre la tab editar
window.checkUserAndOpenTab = function(tabToOpen, functionToLoad = null) {
	var userId = $('#userId').val();
	if (userId != "" && entity != undefined) {
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/'+entity+'/create',
			data: {userId: userId},
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				//En el controlador puede haber varios tipos de respuesta:
				//String: es una sola vista que desplegaremos en la tab 2 
				//Array: Son varias vistas que desplegaremos en la tab que le corresponda
				if(typeof response === "string") {
					$(".accordion .accordion-item:nth-child(2) .accordion-content").html(response);
				} else {
					$.each(response, function(index, val) {
						$(".accordion #"+index+" .accordion-content").html(val);
					});
				}
				if(typeof addRowAditional === "function") {
					addRowAditional(response);
				}
				
				//Activar la tab editar y llenar la información que le corresponda
				enableAcordionTab($(tabToOpen), true);
				$(".accordion "+tabToOpen+" .accordion-header").trigger('click');
				if(functionToLoad != null)
					functionToLoad(response.data);
			}
		});
	}
}