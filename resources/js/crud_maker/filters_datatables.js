$(function() {
	var entity = $("#entity").val();

	window.filterData = function(type) {
		if(type == "datatable") {
			filterDatatable();
		} else {
			filterTable(type);
		}
	}

	window.clearFilters = function(type) {
		//Clear filter elements by type
		$('.'+type+'-filter').each(function (index, el) {
			switch ($(el)[0].nodeName.toLowerCase()) {
				case "input":
					$(el).val("");
					$(el).prop("checked", false);
					break;
				case "select":
					$(el).val("").trigger("change");
					break;
				default:
					$(el).val("");
					break;
			}
		});
		
		if(type == "datatable") {
			clearDatatable();
		} else {
			filterTable();
		}
	}

	/** Filter Table */
		window.filterTable = function(type) {
			var filterSource = $("#filterSource").val();
			var params = {};
			$('.'+type+'-filter').each(function(index, el) {
				if($(el).attr('source') !== undefined) {
					let dataSource = $(el).attr('source').split(".");
					params[$(el).prop('name')+"[type]"] = "relation";
					params[$(el).prop('name')+"[table]"] = dataSource[0];
					params[$(el).prop('name')+"[field]"] = dataSource[1];
					params[$(el).prop('name')+"[value]"] = $(el).val();
				} else {
					params[$(el).prop('name')] = $(el).val();
				}
			});
			$.ajax({
				url: $('meta[name="app-url"]').attr('content')+"/"+filterSource,
				type: 'GET',
				data: params,
				dataType: 'json',
				success: function(response) {
					$(".studies-body").html(response);
					if(typeof filterAditionals === "function") {
						filterAditionals(response);
					}
				}
			});
		}
	/** Filter Table */


	/** Filter Datatable */
		window.filterDatatable = function() {
			if(window.LaravelDataTables != undefined) {
				loadDatatable();
				window.LaravelDataTables[entity+"-table"].draw();
			}
		}

		window.clearDatatable = function() {
			if(window.LaravelDataTables != undefined) {
				window.LaravelDataTables[entity+"-table"].draw();
			}
		}

		// Agrega los valores de los filtros a la request de ajax.
		window.loadDatatable = function() {
			if(window.LaravelDataTables != undefined) {
				window.LaravelDataTables[entity+"-table"].on('preXhr.dt', function ( e, settings, data ) {
					$('.datatable-filter').each(function(index, el) {
						data[$(el).prop('name')] = $(el).val();
					});
				});
			}
		}
	/** Filter Datatable */

});