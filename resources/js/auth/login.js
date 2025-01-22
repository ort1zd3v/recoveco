$(document).ready(function() {
	$("#passwordResetButton").click(function() {
		var form = $("#passwordResetForm").serializeArray();
		$.ajax({
			url: $("meta[name=app-url]").attr("content")+'/password/email',
			type: 'POST',
			dataType: 'json',
			data: form,
			success: function(response) {
				console.log(response);
				$("#passwordResetForm #email").removeClass('is-invalid');
				$(".invalid-feedback").html('');
				$("#passwordResetModal").modal('hide');
				$(".alert-success").html(response.message).removeClass('d-none');
			},
			error: function(response) {
				$("#passwordResetForm #email").addClass('is-invalid');
				$("#passwordResetModal .email-row .invalid-feedback").html('<strong>'+response.responseJSON.errors.email[0]+'</strong>');
			}
		});
		
	});


	$("#registerButton").click(function() {
		var form = $("#registerForm").serializeArray();
		$.ajax({
			url: $("meta[name=app-url]").attr("content")+'/register',
			type: 'POST',
			dataType: 'json',
			data: form,
			success: function(response) {
			},
			error: function(response) {
				console.log(response);
				if(response.status == 201) {
					$("#registerForm #name,#registerForm #email,#registerForm #password").removeClass('is-invalid');
					$("#registerForm .invalid-feedback").html('');
					$("#registerModal").modal('hide');

					window.location.href = $("meta[name=app-url]").attr("content");
				} else {
					if(response.responseJSON.errors.name[0] != undefined) {
						$("#registerForm #name").addClass('is-invalid');
						$("#registerForm .name-row .invalid-feedback").html('<strong>'+response.responseJSON.errors.name[0]+'</strong>');
					}
					if(response.responseJSON.errors.email[0] != undefined) {
						$("#registerForm #email").addClass('is-invalid');
						$("#registerForm .email-row .invalid-feedback").html('<strong>'+response.responseJSON.errors.email[0]+'</strong>');
					}
					if(response.responseJSON.errors.password[0] != undefined) {
						$("#registerForm #password").addClass('is-invalid');
						$("#registerForm .password-row .invalid-feedback").html('<strong>'+response.responseJSON.errors.password[0]+'</strong>');
					}
				}
			}
		});
		
	});
});