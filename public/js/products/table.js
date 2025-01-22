 //Evitar varias consultas al mismo tiempo 
 function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
        callback.apply(context, args);
        }, ms || 0);
    };
}

$(function(){
    //Se utiliza la función delay (400ms) on keyup para poder buscar el elemento en la tabla
    $('#search-input').on('keyup', delay(function(e){
        //Limpiar la categoría si se dispara el evento
        window.LaravelDataTables['products'+"-table"]
        .on('preXhr.dt', function ( e, settings, data ) {
                delete data['category_id'];
            });
        //Buscar el elemento
        window.LaravelDataTables['products'+"-table"].search($(this).val()).draw();

        //Removar la clase active al tab
        $('.category-tabs li a').removeClass('active');
    }, 400));

    //Al dar click al tab traerá los elementos filtrados por categoría
    $('.category-tabs li').on('click', function(){
        let value = $(this).attr('data-id');

        //Si el valor es undefined quiere decir que hizo clic en el icono de limpiar
        if(value == undefined){
            $('#search-input').val('').trigger('keyup');
        }else{
            //Evento para mandar en el request donde se consulta la data la variable
            window.LaravelDataTables['products'+"-table"]
            .on('preXhr.dt', function ( e, settings, data ) {
                    data.category_id = value;
                });
            //Se dibuja la tabla
            window.LaravelDataTables['products'+"-table"].draw();
        }
    });
});