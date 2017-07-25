/**
 * Created by Jorge Luis on 05/07/2017.
 */

window.onload = function(){
    $('#tblVentasReg').DataTable();
    mostrarMenu();
    mostrarVentas();
    cargarTipoDocumento();
    cargarSocio();
}

$(function() {

    $('#new_venta').on('click', function () {
        $('#titulo').html('Nuevo Consumo - Pre Registrar ');
        $('#tipoDocumento').val('');
        $('#ventaSerie').val('');
        $('#ventaNumero').val('');
        $('#ventaImporte').val('');
        $('#ventaFecha').val('');
        $('#cboSocio').val('');
        $('#transaccionID').val('');
    });

    $('#guardarVenta').on('click', function () {
        var p_tipoDoc = $('#tipoDocumento').val();
        var p_serie = $('#ventaSerie').val();
        var p_numero = $('#ventaNumero').val();
        var p_importe = $('#ventaImporte').val();
        var p_fecha = $('#ventaFecha').val();
        var p_transaccionID = $('#transaccionID').val();

        var p_socio = $('#cboSocio').val();



        if (p_transaccionID != '') {
            if (p_socio.length == 0 || p_tipoDoc.length == 0 || p_serie.length == 0 || p_numero.length == 0 || p_importe.length == 0 || p_fecha.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });

            } else {
                var data = new FormData();
                data.append('p_opcion', 'update_pre_transaccion');
                data.append('p_tipoDoc', p_tipoDoc);
                data.append('p_serie', p_serie);
                data.append('p_numero', p_numero);
                data.append('p_importe', p_importe);
                data.append('p_fecha', p_fecha);
                data.append('p_codigo', p_transaccionID);
                data.append('p_socio', p_socio);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlSocio/ventasRegistradas.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        //alert(data);
                        if (data == 0) {
                            iziToast.warning({
                                position: 'bottomCenter',
                                title: 'Advertencia',
                                message: 'El Documento ingresado ya existe',
                            });
                        } else {
                            $('#modalVenta').modal('hide');
                            $('#ventaClienteId').val('');
                            $('#tipoDocumento').val('');
                            $('#cboSocio').val('');
                            $('#ventaSerie').val('');
                            $('#ventaNumero').val('');
                            $('#ventaImporte').val('');
                            $('#ventaFecha').val('');
                            mostrarVentas();
                            iziToast.success({
                                position: 'topRight',
                                title: 'Correcto',
                                message: 'Registro modificado correctamente.',
                            });
                        }

                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        } else {
            if (p_socio.length == 0 || p_tipoDoc.length == 0 || p_serie.length == 0 || p_numero.length == 0 || p_importe.length == 0 || p_fecha.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });
            } else {
                var data = new FormData();
                data.append('p_opcion', 'add_pre_registro');
                data.append('p_tipoDoc', p_tipoDoc);
                data.append('p_serie', p_serie);
                data.append('p_numero', p_numero);
                data.append('p_importe', p_importe);
                data.append('p_fecha', p_fecha);
                data.append('p_socio', p_socio);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlSocio/ventasRegistradas.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            iziToast.warning({
                                position: 'bottomCenter',
                                title: 'Advertencia',
                                message: 'El Documento ingresado ya existe',
                            });
                        } else {
                            $('#modalVenta').modal('hide');
                            $('#ventaClienteId').val('');
                            $('#tipoDocumento').val('');
                            $('#ventaSerie').val('');
                            $('#ventaNumero').val('');
                            $('#ventaImporte').val('');
                            $('#ventaFecha').val('');
                            $('#cboSocio').val('');
                            mostrarVentas();
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

var cargarTipoDocumento = function () {
    var data = new FormData();
    data.append('p_opcion', 'cbo_documento');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#divTipDoc').html(data);
        },
        error: function (msg) {
            alert(msg);
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

var mostrarVentas = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_consumo_traveler');
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

var editar = function (codigo) {
    $('#titulo').html('Editar Consumo - Pre Registrar ');
    var data = new FormData();
    data.append('p_opcion', 'obtener_venta_registrada');
    data.append('p_codigo', codigo);
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            objeto=JSON.parse(data);
            $('#transaccionID').val(objeto[0]);
            $('#tipoDocumento').val(objeto[5]);
            $('#ventaSerie').val(objeto[1]);
            $('#ventaNumero').val(objeto[2]);
            $('#ventaImporte').val(objeto[3]);
            $('#ventaFecha').val(objeto[4]);
            $('#cboSocio').val(objeto[8]);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}


