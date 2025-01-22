$(function(){
    // $('#product-create').on('submit', function(e){
    //     e.preventDefault();

    //     let formData = $('#product-create').serialize();

    //     $.ajax({
    //         url: $('meta[name="app-url"]').attr('content') + `/products`,
    //         type: 'POST',
    //         data: formData,
    //         dataType: 'json',		
    //         success: function(response) {
    //             let product = response.data;

    //             $('#product_id').val(product.id);
    //             $('.ingredient-field').prop('disabled', false);

    //             window.LaravelDataTables['ingredients'+"-table"]
    //                 .ajax.url($('meta[name="app-url"]').attr('content') + `/ingredients/getdatatable/${product.id}`).load();
                
    //             displayMessage(response.message, (response.status ? "success" : "danger"), false);
    //         }
    //     }).fail(function(response) {
    //         //Si hubo error en la validación
    //         if(typeof response.responseJSON.message !== "undefined") {
    //             var el = $(".message-container");
    //             displayMessage(response.responseJSON.errors, "danger", el);
    //         }
    //     });
    // });
});