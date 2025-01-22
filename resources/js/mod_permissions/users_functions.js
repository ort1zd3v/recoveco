//Código adicional
var entity = $("#entity").val();
var form = $("#form").val();

$(document).ready(function() {
	checkUserAndOpenTab("#tab4", documentsForm);
});

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
	displayRolePermissions(response.data.role.permissions);
	//Seleccionar del listado de permisos los permisos que ya tiene el usuario
	if(typeof response.data.permissions !== undefined)
		displayUserPermissions(response.data.permissions);

	$("form#"+form+"-permissions").find("input[name=user_id]").val(response.data.id);
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
					enableAcordionTab($("#tab3"), false);
					if(typeof documentsForm == 'function'){
						documentsForm(response.data);
					}else{
						displayMessage(response.message);
						moveToIndex();
						dt.ajax.reload();
					}
					//Desactivar la tab de permisos
				}
			}
		});
	});
	permissionsChecking();
}

window.documentsForm = function(response) {
	console.log(response);
	var dt = window.LaravelDataTables[entity+"-table"];
	//Activar la tab de recorridos
	enableAcordionTab($("#tab4"), true);

	$("form#documents-users").find("input[name=user_id]").val(response.id);
	$("form#documents-users").find("input[name=user_name]").val(response.full_name);
	$("form#documents-users").find("input[name=user_company]").val(response.company.description);
	$("form#documents-users").submit(function(event) {
		event.preventDefault();
		var data = $(this).serializeArray();
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/'+entity+'/savedocuments',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(response) {
				if(response.status) {
					$("form#documents-users").trigger('reset');
					displayMessage(response.message);
					moveToIndex();
					dt.ajax.reload();

					//Desactivar la tab de recorridos
					enableAcordionTab($("#tab4"), false);
				}
			}
		});
	});
}

function addRowAditional(){
	$("#imageInput").change(function() 
    {
        // Llama la función que muestra el preview.
        readURL(this);
    });
}

function editRowAditional(){
	$("#imageInput").change(function() 
    {
        // Llama la función que muestra el preview.
        readURL(this);
    });
}

function displayRolePermissions(permissions) {
	$.each(permissions, function(index, permission) {
		var el = $("#permission-"+permission.id);
		el.attr('checked', true)
			.attr('disabled', true)
			.attr('data-is-role', true);

		checkParent(el.attr("data-parent"));
	});
}

function displayUserPermissions(permissions) {
	$.each(permissions, function(index, permission) {
		var el = $("#permission-"+permission.id);
		el.attr('checked', true);

		checkParent(el.attr("data-parent"));
	});
}

function courseModal(){
	if ($('#course').is(":checked")) {
		$("#coursesModal").modal();
	}else{
		$(".coursesInputs").prop("checked", false);
	}
}

function savePermissions() {
	documentsForm = null
	$("form#"+form+"-permissions").trigger('submit');
	
}