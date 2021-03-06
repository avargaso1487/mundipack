window.onload = function(){
    $('#tblVentasReg').DataTable();
    mostrarMenu();
    mostrarPagos();
    cargarSocio();
    noti_pre_pago_socio();
    noti_pre_pago_traveler();
}

$(function() {

    $('#guardarPago').on('click', function () {
        var p_operacion = $('#nroOperacion').val();
        var p_monto = $('#montoPago').val();
        var p_fecha = $('#pagoFecha').val();
        var p_pagoID = $('#pagoID').val();
        var p_socioID = $('#cboSocio').val();



        if (p_operacion.length == 0 || p_monto.length == 0 || p_fecha.length == 0 ) {
            iziToast.warning({
                position: 'bottomCenter',
                title: 'Advertencia',
                message: 'Debe ingresar todos los datos obligatorios.',
            });
        } else {
            var data = new FormData();
            data.append('p_opcion', 'add_pago_partners_admin');
            data.append('p_operacion', p_operacion);
            data.append('p_monto', p_monto);
            data.append('p_fecha', p_fecha);
            data.append('p_socioID', p_socioID);
            $.ajax({
                type: "post",
                url: "../../controller/controlTraveler/traveler_controller.php",
                contentType: false,
                data: data,
                processData: false,
                cache: false,
                success: function (data) {
                    if (data == 0) {
                        iziToast.warning({
                            position: 'topRight',
                            title: 'Advertencia',
                            message: 'El número de operación ya ha sido registrdo',
                        });
                        $('#modalVenta').modal('hide');
                    } else {
                        $('#modalVenta').modal('hide');
                        $('#nroOperacion').val('');
                        $('#montoPago').val('');
                        $('#pagoFecha').val('');
                        mostrarPagos();
                        iziToast.success({
                            position: 'topRight',
                            title: 'Correcto',
                            message: data,
                        });
                    }
                },
                error: function (msg) {
                    alert(msg);
                }
            });
        }
    });

    $('#aceptarPago').on('click', function () {
        var p_pagoID = $('#pagoID').val();

        var data = new FormData();
        data.append('p_opcion', 'aprobar_pago_partners');
        data.append('p_pagoID', p_pagoID);
        $.ajax({
            type: "post",
            url: "../../controller/controlTraveler/traveler_controller.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success: function (data) {
                $('#modalAprobacion').modal('hide');
                iziToast.success({
                    position: 'topRight',
                    title: 'Correcto',
                    message: 'El pago seleccionado ha sido confirmado.',
                });
                mostrarPagos();
                noti_pre_pago_socio();
            },
            error: function (msg) {
                alert(msg);
            }
        });


    });


});

var noti_pre_pago_socio = function () {
    var data = new FormData();
    data.append('p_opcion', 'noti_pre_pago_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controladministrador/notificaciones_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            if (data == 0) {
                $('#pago_socios').addClass('hidden');
            } else {
                $('#pago_socios').removeClass('hidden');
                $('#noti_pagos_pre_socios').html(data);
                item_noti_pago_socio();
            }
            //$('#btnMail').addClass('hidden');

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var noti_pre_pago_traveler = function () {
    var data = new FormData();
    data.append('p_opcion', 'noti_pre_pago_traveler');
    $.ajax({
        type: "post",
        url: "../../controller/controladministrador/notificaciones_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            if (data == 0) {
                $('#pago_traveler').addClass('hidden');
            } else {
                $('#pago_traveler').removeClass('hidden');
                $('#noti_pagos_pre_travelers').html(data);
                item_noti_pago_traveler();
            }
            //$('#btnMail').addClass('hidden');

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var item_noti_pago_socio = function () {
    var data = new FormData();
    data.append('p_opcion', 'item_noti_pago_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controladministrador/notificaciones_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#item_noti_pago_socio').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var item_noti_pago_traveler = function () {
    var data = new FormData();
    data.append('p_opcion', 'item_noti_pago_traveler');
    $.ajax({
        type: "post",
        url: "../../controller/controladministrador/notificaciones_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#item_noti_pago_traveler').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}


var mostrarMenu = function () {
    var menu = document.getElementById('Menu').value;
    $.ajax({
        type:'POST',
        data: 'opcion=mostrarMenu&menu='+menu,
        url: "../../controller/controlusuario/usuario.php",
        success:function(data){
            $('#permisos').html(data);
        }
    });
}

var cargarSocio = function () {
    var data = new FormData();
    data.append('p_opcion', 'cbo_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#divSocio').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var aceptar = function (p_pagoID) {

    var data = new FormData();
    data.append('p_opcion', 'obtener_pago_partners');
    data.append('p_pagoID', p_pagoID);
    $.ajax({
        type: "post",
        url: "../../controller/controlTraveler/traveler_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#modalAprobacion').modal('show');
            objeto=JSON.parse(data);
            $('#spanCliente').html(objeto[6]);
            $('#spanOperacion').html(objeto[2]);
            $('#spanMonto').html(objeto[3]);
            $('#spanFecha').html(objeto[4]);
            $('#pagoID').val(p_pagoID);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var mostrarPagos = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_pagos_pendientes_partner');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            if (data == 0) {
                iziToast.warning({
                    position: 'topRight',
                    title: 'Advertencia',
                    message: 'No se encontraron registros',
                });
            } else {
                $('#tblVentasReg').DataTable().destroy();
                $('#cuerpoTablaVentasReg').html(data);
                $('#tblVentasReg').DataTable({
                    "dom": '<"top"fl<"clear">>rt<"bottom"ip<"clear">>',
                    "oLanguage": {
                        "sSearch": "",
                        "sLengthMenu": "_MENU_"
                    },
                    "initComplete": function initComplete(settings, json) {
                        $('div.dataTables_filter input').attr('placeholder', 'Buscar...');
                        // $(".dataTables_wrapper select").select2({
                        //   minimumResultsForSearch: Infinity
                        // });
                    }
                });
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}


var editarPago = function (p_pagoID) {
    var data = new FormData();
    data.append('p_opcion', 'obtener_pago_partners');
    data.append('p_pagoID', p_pagoID);
    $.ajax({
        type: "post",
        url: "../../controller/controlTraveler/traveler_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#modalVenta').modal('show');
            objeto=JSON.parse(data);
            $('#pagoID').val(objeto[0]);
            $('#nroOperacion').val(objeto[2]);
            $('#montoPago').val(objeto[3]);
            $('#pagoFecha').val(objeto[4]);


        },
        error: function (msg) {
            alert(msg);
        }
    });
}




/**
 * Created by Jorge Luis on 16/07/2017.
 */

