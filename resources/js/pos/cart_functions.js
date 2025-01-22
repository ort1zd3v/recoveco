$(function () {
    window.existProductInCart = (product_id) => {
        let result = { status: false, row: null };
        $("#section-carrito #table-cart tbody tr").each(function (index, el) {
            if ($(this).attr("data-id") == product_id) {
                result.status = true;
                result.row = $(this);
                return false;
            }
        });
        return result;
    };

    window.increaseAmount = (param, amount = 1) => {
        const input = $(param).closest(".cart-row").find(".amount");
        amount = parseInt(input.val()) + parseInt(amount);
        input.val(amount);
        updateRowTotal(param);
    };

    window.decreaseAmount = (param) => {
        const input = $(param).closest(".cart-row").find(".amount");
        const amount = parseInt(input.val()) - 1;
        input.val(amount >= 1 ? amount : 1);
        updateRowTotal(param);
    };

    window.updateRowTotal = (param) => {
        const row = $(param).closest(".cart-row");
        const amount = $(row).find(".amount");
        const pu = $(row).find(".price input");
        const subtotalInput = $(row).find(".subtotal input");
        const subtotal = $(row).find(".subtotal span");
        let total = parseInt(amount.val()) * parseFloat(pu.val());

        //si la siguiente fila tiene ingredientes multiplica el valor *mayormente será 0* por el amount de la fila padre
        if ($(row).next().hasClass("ingredients")) {
            const ingredients = $(row).next();
            let overpriceIngredients = 0;
            $(ingredients)
                .find(".ingredient")
                .each(function (index, el) {
                    overpriceIngredients += parseFloat(
                        $(el).find("#overprice").val()
                    );
                });
            $(ingredients)
                .find(".total-overprice-input")
                .val(overpriceIngredients * parseInt(amount.val()));
            $(ingredients)
                .find(".total-overprice")
                .text(
                    `$${(overpriceIngredients * parseInt(amount.val())).toFixed(
                        2
                    )}`
                );
        }

        subtotalInput.val(total);
        subtotal.text(`$${total.toFixed(2)}`);
        setTotal();
    };

    window.deleteProduct = (param) => {
        let id = $(param).closest("tr").attr("data-unique-id");
        $(param).closest("tbody").find(`tr[data-parent-id=${id}]`).remove();
        $(param).closest("tr").remove();
        setTotal();
    };

    window.setTotal = () => {
        let total = 0;
        $("#section-carrito #table-cart tbody tr:not(.ingredients)").each(
            function (index, el) {
                total += parseFloat($(this).find(".subtotal input").val());
            }
        );
        $("#section-carrito #table-cart tbody tr.ingredients").each(function (
            index,
            el
        ) {
            total += parseFloat($(this).find(".total-overprice-input").val());
        });

        $("#section-carrito .total").val(`$${total.toFixed(2)}`);
        $("#section-carrito #total_value").val(total.toFixed(2));

        $("#payment_total").val(total.toFixed(2));
        calculateMissing();
        // $("#payment_amount").val(total - getTotalPayment().toFixed(2));
        selectPayment(1, "Efectivo");
    };

    window.cancel = () => {
        $("#section-carrito #table-cart tbody").empty();
        $("#table-payments tbody").empty();
        setTotal();
    };

    window.cancelPayments = () => {
        $("#table-payments tbody").empty();
        calculateMissing();
    };

    window.showPaymentModal = () => {
        if ($("#table-cart tbody").has(".cart-row").length > 0) {
            let total = parseFloat(
                $("#section-carrito #total_value").val()
            ).toFixed(2);
            $("#paymentModal #payment_total").val(total);
            calculateMissing();
            // $(".payment-buttons #payment-1").trigger("click");
            $("#paymentModal").modal("show");
        } else {
            Swal.fire(
                "Sin productos.",
                "Es necesario seleccionar mínimo un producto.",
                "warning"
            );
        }
    };

    window.getSaleProducts = () => {
        let result = [];
        $("#table-cart tbody tr:not(.ingredients)").each(function () {
            const prod = JSON.parse(window.atob($(this).data("product")));
            let unique_id = $(this).data("unique-id");
            result.push({
                product_id: prod.id,
                amount: $(this).find("input").val(),
                unique_id: $(this).data("unique-id"),
            });
        });

        $("#table-cart tbody tr.ingredients").each(function () {
            //let ingredients = [];
            const parentId = $(this).data("parent-id");
            const productAmount = $(this)
                .closest("tbody")
                .find(`tr[data-unique-id=${parentId}]`)
                .find(".amount")
                .val();
            $(this)
                .find(".ingredients .detail-item")
                .each(function () {
                    let ingredient = {};
                    $(this)
                        .find("input[type=hidden]")
                        .each(function (index, el) {
                            ingredient[$(el).attr("id")] = $(el).val();
                        });
                    if (ingredient.amount ?? false) {
                        ingredient.amount =
                            parseFloat(ingredient.amount) *
                            parseFloat(productAmount);
                    }
                    //ingredients.push(ingredient);

                    $.each(result, function (index, value) {
                        if (value.unique_id == parentId) {
                            value.ingredients = value.ingredients ?? [];
                            value.ingredients.push(ingredient);
                        }
                    });
                });
        });

        return result;
    };

    window.saveSale = () => {
        let data = {
            rows: getSaleProducts(),
            payments: getSalePayments(),
            client_id: $("#container_points #client_id").val(),
        };

        if ($("#missing_total_value").val() == 0) {
            $("#pay").attr("disabled", true);
            $.ajax({
                url:
                    $('meta[name="app-url"]').attr("content") + "/pos/saveSale",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        $("body").html(response.data);
                        Swal.fire({
                            title: "Venta exitosa.",
                            text: "Se realizó la venta correctamente.",
                            icon: "success",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: true,
                            focusConfirm: true,
                            timer: 500,
                        }).then(function () {
                            setTimeout(() => {
                                window.print();
                                location.reload();
                            }, 500);
                        });
                    } else {
                        Swal.fire({
                            title: "Error en la venta.",
                            text: response.message,
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: true,
                            focusConfirm: true,
                        });
                    }
                },
                error: function (response) {
                    console.log("error");
                },
            });
        } else {
            Swal.fire("Dinero insuficiente.", "Falta dinero.", "warning");
        }
    };

    window.saveInventory = () => {
        let data = {
            rows: getSaleProducts(),
            payments: getSalePayments(),
            client_id: $("#container_points #client_id").val(),
        };

        if ($("#missing_total_value").val() == 0) {
            $("#pay").attr("disabled", true);
            $.ajax({
                url:
                    $('meta[name="app-url"]').attr("content") + "/pos/saveSale",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        $("body").html(response.data);
                        Swal.fire({
                            title: "Venta exitosa.",
                            text: "Se realizó la venta correctamente.",
                            icon: "success",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: true,
                            focusConfirm: true,
                            timer: 500,
                        }).then(function () {
                            setTimeout(() => {
                                window.print();
                                location.reload();
                            }, 500);
                        });
                    } else {
                        Swal.fire({
                            title: "Error en la venta.",
                            text: response.message,
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: true,
                            focusConfirm: true,
                        });
                    }
                },
                error: function (response) {
                    console.log("error");
                },
            });
        } else {
            Swal.fire("Dinero insuficiente.", "Falta dinero.", "warning");
        }
    };

    //Funcion para abrir la tabla de metodo de pago
    var tablaVisible = false; // Variable para controlar el estado de la tabla

    // Función para mostrar u ocultar la tabla
    function toggleTabla() {
        var tabla = document.getElementById("table-payment-container");
        if (tablaVisible) {
            tabla.style.position = "absolute";
            tabla.style.left = "-9999px";
            document.getElementById("toggleTabla").textContent =
                "Mostrar Tabla";
        } else {
            tabla.style.position = "static";
            tabla.style.left = "auto";
            document.getElementById("toggleTabla").textContent =
                "Ocultar Tabla";
        }
        tablaVisible = !tablaVisible; // Cambiar el estado de la tabla
    }

    // Asignar evento de clic al botón
    document
        .getElementById("toggleTabla")
        .addEventListener("click", toggleTabla);

    // const filter = $(".dataTables_wrapper .dataTables_filter").find("input[type=search]");
    // filter.keypress(function(e) {
    // 	var code = (e.keyCode ? e.keyCode : e.which);
    // 	if(code==13){
    // 		$('#products-table .product-table-row').first().trigger('click')
    // 		fil.val("")
    // 	}
    // });
});
