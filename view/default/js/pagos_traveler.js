/**
 * Created by Jorge Luis on 05/07/2017.
 */

window.onload = function(){
    $('#tblVentasReg').DataTable();
    mostrarMenu();
    mostrarPagos();
}

$(function() {

    $('#new_venta').on('click', function () {
        $('#titulo').html('Pago Realizado');
        $('#nroOperacion').val('');
        $('#montoPago').val('');
        $('#pagoFecha').val('');
        $('#pagoID').val('');
    });


    $('#guardarPago').on('click', function () {
        var p_operacion = $('#nroOperacion').val();
        var p_monto = $('#montoPago').val();
        var p_fecha = $('#pagoFecha').val();
        var p_pagoID = $('#pagoID').val();

        if (p_pagoID != '') {
            if (p_operacion.length == 0 || p_monto.length == 0 || p_fecha.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });

            } else {
                var data = new FormData();
                data.append('p_opcion', 'update_pago');
                data.append('p_operacion', p_operacion);
                data.append('p_monto', p_monto);
                data.append('p_fecha', p_fecha);
                data.append('p_pagoID', p_pagoID);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlTraveler/traveler_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 0){
                            iziToast.warning({
                                position: 'topRight',
                                title: 'Advertencia',
                                message: 'El número de operación ya ha sido registrdo',
                            });
                            $('#modalVenta').modal('hide');
                        } else {
                            //alert(data);
                            $('#modalVenta').modal('hide');
                            $('#nroOperacion').val('');
                            $('#montoPago').val('');
                            $('#pagoFecha').val('');
                            $('#pagoID').val('');
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
        } else {
            if (p_operacion.length == 0 || p_monto.length == 0 || p_fecha.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });
            } else {
                var data = new FormData();
                data.append('p_opcion', 'add_pago');
                data.append('p_operacion', p_operacion);
                data.append('p_monto', p_monto);
                data.append('p_fecha', p_fecha);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlTraveler/traveler_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 0){
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
                            $('#pagoID').val('');
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
        }


    });

});

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

var mostrarPagos = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_pagos_traveler');
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
    $('#titulo').html('Editar Pago Realizado');
    var data = new FormData();
    data.append('p_opcion', 'obtener_pago');
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




