class DatatablesGrid {
	drawDatatable(dt, gridColumns = null) {
		//var dt = window.LaravelDataTables[entity + "-table"];
		var dtSettings = dt.settings();
		if (dtSettings != undefined) {
			//Obtener el HTML de la datatable
			var dtContent = $(".dataTable")[0];
			//console.log(dtContent);
			$(".dataTable").remove();

			//HTML que va a reemplazar la tabla actual
			var tabsContent = $("#tabsContainer").html();
			$(".accordion-content .w-100").append(tabsContent);

			//Insertar el HTML de la datatable en la primera tab
			$("#tableTabContent").html(dtContent);

			//Agregar evento al dar clic en un row para que despliegue la pestaña de editar el registro
			if ($("#allowEdit").val() == 1) {
				$("#" + entity + "-table tbody").on('click', '>tr:not(.details-table) td:not(:last-child)', function() {
					editRow(dt.row(this).data().id);
				});
			}
			var cc = this;
			dt.on('draw', function () {
				cc.drawGrid(dtSettings[0].aoData , gridColumns);
			});
		}
	}

	drawGrid(data, columnsToDisplay = null) {
		//console.log(i18n);
		if (data != undefined) {
			var cI = 0; //Contador para cada row del datatables para controlar cuantos se desplegarán en cada fila del grid
			var cR = 1; //Contador de filas del grid
			//Limpiar el contenedor que mostrará la tabla en forma de grid
			$(".grid-content").html('<div class="container-fluid"></div>');
			var cc = this;
			$.each(data, function(index, row) {
				//Si no existe el row lo crea
				if ($(".grid-content").find(".row" + cR).html() == undefined)
					$(".grid-content .container-fluid").append('<div class="row row' + cR + '"></div>');


				//Sacar todos los datos del objeto para mostrarlos en el elemento del grid correspondiente
				var content = '<ul>';
				var hasImage = false;
				var image = null;
				//console.log(i18n.users.name);
				$.each(row._aData, function(index, val) {
					//Si encuentra la columna action en el registro no la agrega al grid
					if (index.toLowerCase() != "action") {
						//Revisa si se recibe datos en el array columnsToDisplay
						//De ser así solo muestra las columnas indicadas
						if (columnsToDisplay != null) {
							if ($.inArray(index, columnsToDisplay) >= 0) {
								content += '<li><label class="font-weight-bold">' + cc.searchTranslation(entity, index) + ':</label> ' + val + '</li>';
							}
						} else {
							content += '<li><label class="font-weight-bold">' + cc.searchTranslation(entity, index) + ': </label>' + val + '</li>';
						}
						//Busca si en el objeto hay un campo con nombre image para ponerlo en el grid
						if (index == "picture") {
							hasImage = true;
							image = val;
						}
					}
				});
				content += '</ul>';

				//Crea cada uno de los elementos del grid
				var isFirstCol = $(".grid-content").find(".row" + cR).html() == "" ? true : false;
				$(".grid-content").find(".row" + cR).append(`
					<div class="col-12 col-md-12 col-lg-4 my-auto pl-3` + `" data-id="` + row._aData.id + `">

						<div class="grid-item mt-2 mb-2">
							<div class="item-content d-table w-100">
								<div class="d-table-row">
									<div class="d-table-cell w-100" onclick="editRow('` + row._aData.id + `')">
										<div class="item-image float-left ` + (hasImage ? 'd-table-cell' : 'd-none') + `">
											<img class=" pt-2 pl-2" src="public/` + (image != null ? image : 'images/user.png') + `" />
										</div>
										<div class="item-info d-table-cell w-100">` + content + `</div>
									</div>
									
									<div class="item-info d-table-cell cell-icons align-middle my-auto">` + row._aData.action + `</div>
								</div>
							</div>
						</div>
					</div>
					
				`);
				//Pone solo 5 elementos en cada fila en el grid
				cI++;
				if (cI == 3) {
					cR++;
					cI = 0;
				}
			});
		}
	}

	searchTranslation(entity, index) {
		var result = '';
		if(i18n[entity] !== undefined) {
			if(i18n[entity][index] !== undefined)
				result = i18n[entity][index];
		}
		if(result === '')
			result = entity+'.'+index;
		return result;
	}
}