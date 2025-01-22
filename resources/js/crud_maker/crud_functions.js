$(function() {
	var entity = $("#entity").val();
	var form = $("#form").val();
	var dt = window.LaravelDataTables[entity+"-table"];
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		}
	});

	window.moveToIndex = function() {
		//Remove parameters from url
		var url = location.href;
		var urlSplit = url.split("?");
		window.history.replaceState('', document.title, urlSplit[0]);

		$(".accordion .accordion-item:first-child .accordion-header").trigger('click');
	}

	window.addRow = function() {
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/'+entity+'/create',
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				if(typeof response === "string") {
					$(".accordion .accordion-item:nth-child(2) .accordion-content").html(response);
				} else {
					$.each(response, function(index, val) {
						console.log(val);
						$(".accordion #"+index+" .accordion-content").html(val);
					});
				}
				if(typeof addRowAditional === "function") {
					addRowAditional(response);
				}
				
				enableAcordionTab($("#tab2"), true);
				$(".accordion .accordion-item:nth-child(2) .accordion-header").trigger('click');
				saveAdd();
			}
		});
	}

	window.editRow = function(id) {
		$.ajax({
			url: $('meta[name="app-url"]').attr('content')+'/'+entity+'/'+id+'/edit',
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				if(typeof response === "string") {
					$(".accordion .accordion-item:nth-child(2) .accordion-content").html(response);
				} else {
					$.each(response, function(index, val) {
						$(".accordion #"+index+" .accordion-content").html(val);
					});
				}
				if(typeof editRowAditional === "function") {
					editRowAditional(response);
				}
				enableAcordionTab($("#tab2"), true);
				$(".accordion .accordion-item:nth-child(2) .accordion-header").trigger('click');
				saveEdit();
			}
		});
	}

	window.saveAdd = function() {
		$("form#"+form+"-create").submit(function(event) {
			event.preventDefault();
			//var data = $(this).serializeArray();
			var data = new FormData(document.getElementById(""+form+"-create"));
			$("form#"+form+"-create").find("input[type=file]").each(function(index, el){
				var files = $(this)[0].files;
				
				if(files.length > 0 ){
					data.append('file',files[0]);
				}	
			});
			$.ajax({
				url: $('meta[name="app-url"]').attr('content')+'/'+entity+'',
				type: 'POST',
				data: data,
				contentType: false,
				processData: false,
				dataType: 'json',
				success: function(response) {
					if(response.status) {
						if(typeof saveAditional === "function") {
							saveAditional(response);
						} else {
							$("form#"+form+"-create").trigger('reset');
							moveToIndex();
							displayMessage(response.message, "success");
							dt.ajax.reload();
						}
					}
				}
			}).fail(function(response) {
				//si hubo error en la validación
				if(typeof response.responseJSON.message !== "undefined") {
					var el = $("form#"+form+"-create").closest("li.accordion-item").find(".message-container");
					displayMessage(response.responseJSON.errors, "danger", el);
				}
			});
		});
	}

	window.saveEdit = function() {
		$("form#"+form+"-edit").submit(function(event) {
			event.preventDefault();
			var id = $("form#"+form+"-edit").find("input[name=id]").val();
			var data = new FormData(document.getElementById(""+form+"-edit"));
			$("form#"+form+"-edit").find("input[type=file]").each(function(index, el){
				var files = $(this)[0].files;
				if(files.length > 0 ){
					data.append('file',files[0]);
				}	
			});
			for (var i of data){
				console.log(i[0],i[1]);
			}
			$.ajax({
				url: $('meta[name="app-url"]').attr('content')+'/'+entity+'/'+id,
				type: 'POST',
				data: data,
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function(response) {
					if(response.status) {
						if(typeof editAditional === "function") {
							editAditional(response);
						} else {
							moveToIndex();
							displayMessage(response.message, "success");
							dt.ajax.reload();
						}
					}
				}
			}).fail(function(response) {
				//si hubo error en la validación
				if(typeof response.responseJSON.message !== "undefined") {
					var el = $("form#"+form+"-edit").closest("li.accordion-item").find(".message-container");
					displayMessage(response.responseJSON.errors, "danger", el);
				}
			});
		});
	}
});