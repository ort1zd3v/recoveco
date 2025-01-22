$(function() {
	var entity = $("#entity").val();

	window.customizeDatatable = (isModal = true, buttonAdd = false, addInFilter = true) => {
		$(".dataTables_length").find('select').addClass("form-select mx-2");
		//Change filter section
		var filter = $(".dataTables_wrapper .dataTables_filter");
		var dataLenght = $(".dataTables_length");

		filter.addClass('search-box me-2 mb-2 row');

		if (addInFilter) {
			if(filter.find('.button-add').length == 0) {
				if($("#allowAdd").val() == "1" || buttonAdd) {
					filter.append(getAddButton(isModal, addInFilter));
				}
			}
		}else {
			if(dataLenght.find('.button-add').length == 0) {
				if($("#allowAdd").val() == "1" || buttonAdd) {
					dataLenght.append(getAddButton(isModal, addInFilter));
				}
			}
		}
		
		filter.find("label").addClass('position-relative col-4').append(`<i class="bx bx-search-alt search-icon"></i>`);
		filter.find("input[type=search]").addClass('form-control');

		//Change pagination links
		var paginate = $(".dataTables_wrapper .dataTables_paginate");
		paginate.addClass('pagination pagination-rounded justify-content-end mb-2');
		paginate.find(".previous").html(addIcon('<i class="mdi mdi-chevron-left"></i>'));
		paginate.find(".next").html(addIcon('<i class="mdi mdi-chevron-right"></i>'));
		paginate.find("> span").css('display', 'inline-flex');
		paginate.find("span a").each(function(index, el) {
			if ($(el).find(".page-item").length == 0) {
				var classList = el.classList;
				var active = false;
				for (const key in classList) {
					if(classList[key] == 'current') {
						active = true;
					}
				}
				$(el).html(addIcon($(el).html(), active));
			}
		});
	}

	window.footerCustomize = (cols, api, putCols) => {
		var api = api;
		let totals = [];
		// Calcular el total de ventas
		$.each(cols, function(index, col) {
			var total = api.column(col).data().reduce(function(acc, val) {
				// Eliminar el símbolo $ y el punto de la cadena de valor
				var value = val.replace("$","").replace(",","");
				return acc + parseFloat(value);
			}, 0);

			// Formatear el total con el símbolo $
			var formattedTotal = "$" + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"); 
			totals.push(formattedTotal)
		})

		
		
		// Agregar una fila de pie de página para mostrar el total de ventas
		let tfoot = 
				`<tfoot><tr><th colspan="${putCols[0]}" class="text-end">` + `Total:` + `</th>`
					
		$.each(putCols, function(index, col) {
			let colspan = 1;
			if (index > 0) {
				colspan = putCols[index] - putCols[index-1]
			}
			tfoot += 
				`
					<th colspan="${colspan}" class="text-end">${totals[index]}</th>
				`
		})

		tfoot += `</tr></tfoot>`
		var $table = $(api.table().node());
		$table.find('tfoot').remove(); 
		$table.append(tfoot);
	}

	window.getAddButton = (isModal, addInFilter) => {
		var result = '';
		var params = btoa(JSON.stringify({
			"entity_source": entity,
			"entity": entity, //Este es el nombre que se le dará al quick add modal que se creará
			"saveAditionals": 'reloadDatatable'
		}));
		var attr = isModal ? `onclick="showQuickAddModal('${params}')"` : `href="${entity}/create"`;
		
		result = addInFilter ? `<div class="col-sm-8">` : `<div>`
		result += `
			<div class="text-sm-end">
				<a class="btn btn-default waves-effect mb-2 button-add" ${attr}>
					<i class="mdi mdi-plus me-1"></i>
					${window.i18n.es.Add}
				</a>
			</div>
		</div>`;
		return result;
	}

	window.addIcon = (p, a) => {
		return `
			<span class='page-item `+(a ? 'active' : '')+`'>
				<span class='page-link'>${p}</span>
			</span>
		`;
	}

	window.reloadDatatable = (response) => {
		window.LaravelDataTables[entity+"-table"].draw();
	}
});