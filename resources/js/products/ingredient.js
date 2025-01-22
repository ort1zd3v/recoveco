$(function(){
    $('#ingredient-create').on('submit', function(e){
        e.preventDefault();

        let formData = $('#ingredient-create').serialize();
        
        $.ajax({
            url: $('meta[name="app-url"]').attr('content') + `/ingredients`,
            type: 'POST',
            data: formData,
            dataType: 'json',		
            success: function(response) {
                window.LaravelDataTables['ingredients'+"-table"].draw();
                displayMessage(response.message, (response.status ? "success" : "danger"), false);
            }
        }).fail(function(response) {
            //Si hubo error en la validación
            if(typeof response.responseJSON.message !== "undefined") {
                var el = $(".message-container");
                displayMessage(response.responseJSON.errors, "danger", el);
            }
        });
    });
});