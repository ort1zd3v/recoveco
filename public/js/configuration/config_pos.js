$(function() {
	drawPreview($('#total_rows option:selected').text(), $('#total_columns option:selected').text())

	//Obtener views
	setTimeout(() => {
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/config_pos/getViews',
			type: 'GET',
			success: function(response) {
				Object.keys(response).forEach(key => {
					getView(key, response[key])
				});
			}
		});
	}, 500);

	//Obtener view por petición ajax, regresa la vista como html
	function getView(tile, view) {
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/config_pos/getView/' + view,
			type: 'GET',
			success: function(response) {
				$(`#${tile} .content`).fadeOut("slow", function() {
					$(`#${tile} .content`).html(response)
					$(`#${tile} .content`).fadeIn("slow");
				});
				$(`#input_${tile}`).val(view)
				$(`#input_${tile}`).text(view)
				$(`#views option[value='${view}']`).remove()
				$(`#config_view_${tile}`).attr('id', `view_${view}`)
			}
		});
	}

	//Obtener pantalla de configuración de la view por petición ajax, regresa la vista como html
	function getConfigView(view) {
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/config_pos/getConfigView/' + view,
			type: 'GET',
			success: function(response) {
				$("#configView").fadeOut("slow", function() {
					$("#configView").html(response)
					$("#configView").fadeIn("slow");
				});
			}
		});
	}

	$("#contentPreviewPOS").on('click','a.configView', function(e) {
		const view = (e.currentTarget.id.replace('view_', ''))
		getConfigView(view)
	});


	$("#total_rows").change(function(){
		drawPreview($('#total_rows option:selected').text(), $('#total_columns option:selected').text())
	})
	$("#total_columns").change(function(){
		drawPreview($('#total_rows option:selected').text(), $('#total_columns option:selected').text())
	})

	$("#background_color_views").change(function(){
		$("#contentPreviewPOS .col").css("background-color", $("#background_color_views").val())
	})

	$("#font_color_views").change(function(){
		$("#contentPreviewPOS").css("color", $("#font_color_views").val())
	})

	//Dibuja el preview con las columnas y filas de manera proporcional
	function drawPreview(rows, columns) {
		let col1, col2
		if (columns.includes(":")) {
			[col1, col2] = columns.split(":")
			columns = col1 > col2 ? col1 : col2;
		}
		let content = "";
		let cont = 0;
		for (let i = 0; i < rows; i++) {
			content += `<div class="row">`;
			for (let j = 0; j < columns; j++) {
				let classColumns = 'col w-100'
				if (col1 != null) {
					classColumns = "col-"
					classColumns += j == 0 ? col1 == 1 ? 4 : 8 : col2 == 1 ? 4 : 8
				}
				content += `
					<div class="${classColumns} p-2" id="tile${++cont}" style="min-height: ${750 / rows}px; border-radius: 10px; border: 4px solid white">
						<div class="text-center w-100 bg-white d-flex justify-content-between align-items-center p-1">
							<h3 class="m-0">Sección ${cont}</h3>
							<div class="d-block">
								<a class="btn btn-danger" onclick="deleteView('${cont}')">X</a>
								<a id="config_view_tile${cont}" type="button" class="btn btn-success configView" data-bs-toggle="modal" data-bs-target="#configModal2">
									<i class="fas fa-cog"></i>
								</a>
							</div>
						</div>
						<input id="input_tile${cont}" name="tiles[tile${cont}]" class="input d-none" type="text">
						<div class="w-100 mt-2 content">
							
						</div>
					</div>
				`;
			}
			content += '</div>'
		}
		$("#contentPreviewPOS").fadeOut("slow", function() {
			$("#contentPreviewPOS").html(content);
			$("#contentPreviewPOS").fadeIn("slow");
		});
		$("#views").html(
			`
				<option value="productos">productos</option>
				<option value="carrito">carrito</option>
				<option value="pago">pago</option>
			`
		)
	}

	window.setView = function() {
		let numSection = $("#num_section option:selected").val()

		if ($(`#tile${numSection} .input`).text() == '') {
			let removed = $('#views option:selected').remove()
			$(`#tile${numSection} .input`).val(removed.text())
			$(`#tile${numSection} .input`).text(removed.text())
			$(`#tile${numSection} .content`).html(`<h1>${removed.text()}</h1>`)
		}
	}

	window.deleteView = function(numTile){
		let text = $(`#tile${numTile} .input`).text()

		if (text != '') {
			$(`#tile${numTile} .content`).html('')
			$(`#tile${numTile} .input`).val('')
			$(`#tile${numTile} .input`).text('')
			$('#views').append(`<option value="${text}">${text}</option>`)
		}
	}

	function saveConfig(view){
		alert(view)
	}

});