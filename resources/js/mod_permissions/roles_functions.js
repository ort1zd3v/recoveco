//Código adicional
var entity = $("#entity").val();
var form = $("#form").val();
function saveAditional(response) {
	permissionsForm(response);
}

function editAditional(response) {
	permissionsForm(response);
}

function permissionsForm(response) {
	var dt = window.LaravelDataTables[entity+"-table"];
	//Activar la tab de permisos
	enableAcordionTab($("#tab3"), true);

	//Seleccionar del listado de permisos los permisos que ya tiene el rol
	if(typeof response.data.permissions !== undefined)
		displayRolePermissions(response.data.permissions);

	$("form#"+form+"-permissions").find("input[name=role_id]").val(response.data.id);
	$("form#"+form+"-permissions").submit(function(event) {
		event.preventDefault();
		var data = $(this).serializeArray();
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/'+entity+'/savepermissions',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(response) {
				if(response.status) {
					$("form#"+form+"-permissions").trigger('reset');
					displayMessage(response.message);
					moveToIndex();
					dt.ajax.reload();

					//Desactivar la tab de permisos
					enableAcordionTab($("#tab3"), false);
				}
			}
		});
	});
	permissionsChecking();
}

function displayRolePermissions(permissions) {
	$.each(permissions, function(index, permission) {
		el = $("#permission-"+permission.id);
		el.attr('checked', true);
		checkParent(el.attr("data-parent"));
	});
}