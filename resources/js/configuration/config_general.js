$(function() {

	//logo
	$("#logoFile").change(function(){
		var TmpPath = URL.createObjectURL($('#logoFile').prop('files')[0]);
		$('#logoPreview').attr('src', TmpPath);
	})

	//header
	$("#headerBackgroundColor").change(function(){
		const background_color =  $("#headerBackgroundColor").val();
		$("#headerPreview").stop().animate({backgroundColor: background_color}, 300);
	});
	$("#headerColor").change(function(){
		const color =  $("#headerColor").val();
		$("#headerPreview").stop().animate({color: color}, 300);
	});
	$("#general_header_font_id").change(function(){
		const font =  $("#general_header_font_id option:selected").text();
		$("#headerPreview").css('font-family', font);
	});

	//menu
	$("#menuBackgroundColor").change(function(){
		const color =  $("#menuBackgroundColor").val();
		$("#menu").stop().animate({backgroundColor: color}, 300);
	});
	$("#menuColor").change(function(){
		const color =  $("#menuColor").val();
		$("#menu").stop().animate({color: color}, 300);
	});
	$("#general_menu_font_id").change(function(){
		const font =  $("#general_menu_font_id option:selected").text();
		$("#menu").css('font-family', font);
	});
	$("#iconsCheck").change(function(){
		if( $('#iconsCheck').prop('checked') ) {
			$(".icon").css('display', 'block')
		}else{
			$(".icon").css('display', 'none')
		}
	});

	//contenido
	$("#contentBackgroundColor").change(function(){
		const background_color =  $("#contentBackgroundColor").val();
		$("#contentPreview").stop().animate({backgroundColor: background_color}, 300);
	});
	$("#contentColor").change(function(){
		const color =  $("#contentColor").val();
		$("#contentPreview").stop().animate({color: color}, 300);
	});
	$("#general_body_font_id").change(function(){
		const font =  $("#general_body_font_id option:selected").text();
		$("#contentPreview").css('font-family', font);
	});
	
	//footer
	$("#footerBackgroundColor").change(function(){
		const background_color =  $("#footerBackgroundColor").val();
		$("#footerPreview").stop().animate({backgroundColor: background_color}, 300);
	});
	$("#footerColor").change(function(){
		const color =  $("#footerColor").val();
		$("#footerPreview").stop().animate({color: color}, 300);
	});
	$("#general_footer_font_id").change(function(){
		const font =  $("#general_footer_font_id option:selected").text();
		$("#footerPreview").css('font-family', font);
	});

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

			}
		});

	});
});