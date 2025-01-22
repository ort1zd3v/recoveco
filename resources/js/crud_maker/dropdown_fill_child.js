/**
 * [fillDropdownChild Esta función llena un combobox cuando se ejecuta una acción, el fin es filtrar por el parámetro seleccionado]
 * @param  {[type]} route          [Ruta a donde vamos a consultar los datos del hijo]
 * @param  {[type]} filterColumn   [Columna de por la que queremos filtrar]
 * @param  {[type]} param          [Valor del que vamos a partir]
 * @param  {[type]} target         [Combobox objetivo que se rellenará]
 */
window.fillDropdownChild = (route, filterColumn, value, target) => {
	$.ajax({
		url: $('meta[name="app-url"]').attr('content')+"/"+route,
		type: 'GET',
		data: {[filterColumn]: value},
		dataType: 'json',
		success: function(response) {
			$("#"+target).html(getDropdownContent(response)).trigger('change');
		}
	});
}

window.getDropdownContent = (response) => {
	let result = '';
	result += '<option value=""></option>';
	$.each(response, function(index, val) {
		result += '<option value="'+index+'">'+val+'</option>';
	});
	return result;
}