$(function() {

	//header datatables
	$("#datatableHeaderBackgroundColor").change(function(){
		const background_color =  $("#datatableHeaderBackgroundColor").val();
		$("#datatableHeaderPreview th").stop().animate({backgroundColor: background_color}, 300);
	});
	$("#datatableHeaderColor").change(function(){
		const color =  $("#datatableHeaderColor").val();
		$("#datatableHeaderPreview th").stop().animate({color: color}, 300);
	});

	//boton agregar y page
	$("#datatableAddBackgroundColor").change(function(){
		const color =  $("#datatableAddBackgroundColor").val();
		$("#btnAddPreview").stop().animate({backgroundColor: color}, 300);
		$("#btnPagePreview").stop().animate({backgroundColor: color}, 300);

	});
	$("#datatableAddColor").change(function(){
		const color =  $("#datatableAddColor").val();
		$("#btnAddPreview").stop().animate({color: color}, 300);
		$("#btnPagePreview").stop().animate({color: color}, 300);

	});
	
	//icono editar
	$("#datatableEditColor").change(function(){
		const color =  $("#datatableEditColor").val();
		$("#datatableBodyPreview .icon-edit").stop().animate({color: color}, 300);
	});
	
	//icono eliminar
	$("#datatableDeleteColor").change(function(){
		const color =  $("#datatableDeleteColor").val();
		$("#datatableBodyPreview .icon-delete").stop().animate({color: color}, 300);
	});

	function rgbToHex(rgbString) {
		const rgbArray = rgbString.split(',').map(Number);
		const [r, g, b] = rgbArray;
		const hex = ((r << 16) | (g << 8) | b).toString(16);
		return "#" + "0".repeat(6 - hex.length) + hex;
	}


	//cuando cambia de theme en el select
	$("#template_id").change(function(){
		$("#name_template").val($('#template_id option:selected').text());
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/templates/updateTheme/' + $("#template_id").val(),
			type: 'GET',
			success: function(response) {
				const data = JSON.parse(response['data'])
				//logo
				var image = $("#logoPreview");
				image.fadeOut('slow', function () {
					image.attr('src', data['logo']);
					image.fadeIn('slow');
				});

				//header
				$('#headerBackgroundColor').val(data['general_header_background_color'])
				$('#headerColor').val(data['general_header_font_color'])
				$("#headerPreview").animate({backgroundColor: data['general_header_background_color']}, 300);
				$("#headerPreview").animate({color: data['general_header_font_color']}, 300);
				$("#headerPreview").css('font-family', data['general_header_font']);

				//menu
				$('#menuBackgroundColor').val(data['general_menu_background_color'])
				$('#menuColor').val(data['general_menu_font_color'])
				$('#menuHoverColor').val(data['general_menu_font_hover_color'])
				$("#menu").animate({backgroundColor: data['general_menu_background_color']}, 300);
				$("#menu").animate({color: data['general_menu_font_color']}, 300);
				$("#menu").css('font-family', data['general_menu_font']);

				//body
				$('#contentBackgroundColor').val(data['general_body_background_color'])
				$('#contentColor').val(data['general_body_font_color'])
				$("#contentPreview").animate({backgroundColor: data['general_body_background_color']}, 300);
				$("#contentPreview").animate({color: data['general_body_font_color']}, 300);
				$("#contentPreview").css('font-family', data['general_body_font']);

				//footer
				$('#footerBackgroundColor').val(data['general_footer_background_color'])
				$('#footerColor').val(data['general_footer_font_color'])
				$("#footerPreview").animate({backgroundColor: data['general_footer_background_color']}, 300);
				$("#footerPreview").animate({color: data['general_footer_font_color']}, 300);
				$("#footerPreview").css('font-family', data['general_footer_font']);

				//datatables
				//header
				$('#datatableHeaderBackgroundColor').val(rgbToHex(data['datatables_header_backround_color']))
				$('#datatableHeaderColor').val(data['datatables_header_font_color'])
				$("#datatableHeaderPreview th").animate({backgroundColor: rgbToHex(data['datatables_header_backround_color'])}, 300);
				$("#datatableHeaderPreview th").animate({color: data['datatables_header_font_color']}, 300);

				//botón agregar
				$('#datatableAddBackgroundColor').val(data['datatables_add_background_color'])
				$('#datatableAddColor').val(data['datatables_add_font_color'])
				$("#btnAddPreview").animate({backgroundColor: data['datatables_add_background_color']}, 300);
				$("#btnPagePreview").animate({backgroundColor: data['datatables_add_background_color']}, 300);
				$("#btnAddPreview").animate({color: data['datatables_add_font_color']}, 300);
				$("#btnPagePreview").animate({color: data['datatables_add_font_color']}, 300);

				//botón editar
				$('#datatableEditColor').val(data['datatables_edit_font_color'])
				$("#datatableBodyPreview .icon-edit").animate({color: data['datatables_edit_font_color']}, 300);

				//botón eliminar
				$('#datatableDeleteColor').val(data['datatables_delete_font_color'])
				$("#datatableBodyPreview .icon-delete").animate({color: data['datatables_delete_font_color']}, 300);

			}
		});

	});
});