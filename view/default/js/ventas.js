/**
 * Created by Jorge Luis on 05/07/2017.
 */

window.onload = function(){
    $('#tblVentasReg').DataTable();
    mostrarMenu();
    noti_pre_registro();
    noti_item_socio();
    mostrarVentas();
    cargarTipoDocumento();
}

$(function() {
    $('#searchSocio').on('click', function () {
        var dni = $('#ventaDni').val();
        if ( dni == '') {
            alert('Ingrese Dni');
        } else {
            if (dni.length < 8) {
                alert('Ingrese 8 digitos en el dni.');
            } else {
                var data = new FormData();
                data.append('p_opcion', 'buscar_socio');
                data.append('p_dni', dni);
                $.ajax({
                    type:'POST',
                    url: "../../controller/controlSocio/ventasRegistradas.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success:function(data){
                        objeto=JSON.parse(data);
                        if (objeto[0] == '0') {
                            alert('La persona no se encuentra registrada');
                            $('#ventaDni').val('');
                            $('#ventaCliente').val('');
                            $('#ventaCliente').val('');
                        } else {
                            $("#ventaDni").attr("disabled", true);
                            $("#searchSocio").attr("disabled", true);
                            $('#ventaClienteId').val(objeto[0]);
                            $('#ventaCliente').val(objeto[1]);
                        }


                    }
                });
            }
        }
    });

    $('#new_venta').on('click', function () {
        $('#ventaDni').val('');
        $('#ventaDni').attr("disabled",false)
        $('#ventaCliente').val('');

        $('#ventaClienteId').val('');
        $('#tipoDocumento').val('');
        $('#ventaSerie').val('');
        $('#ventaNumero').val('');
        $('#ventaImporte').val('');
        $('#ventaFecha').val('');
        $('#transaccionID').val('');
    });


    $('#guardarVenta').on('click', function () {
        var p_socioID = $('#ventaClienteId').val();
        var p_tipoDoc = $('#tipoDocumento').val();
        var p_serie = $('#ventaSerie').val();
        var p_numero = $('#ventaNumero').val();
        var p_importe = $('#ventaImporte').val();
        var p_fecha = $('#ventaFecha').val();
        var p_transaccionID = $('#transaccionID').val();

        if (p_transaccionID != '') {
            if (p_socioID.length == 0 || p_tipoDoc.length == 0 || p_serie.length == 0 || p_numero.length == 0 || p_importe.length == 0 || p_fecha.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });

            } else {
                var data = new FormData();
                data.append('p_opcion', 'update_transaccion');
                data.append('p_socioID', p_socioID);
                data.append('p_tipoDoc', p_tipoDoc);
                data.append('p_serie', p_serie);
                data.append('p_numero', p_numero);
                data.append('p_importe', p_importe);
                data.append('p_fecha', p_fecha);
                data.append('p_codigo', p_transaccionID);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlSocio/ventasRegistradas.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        //alert(data);
                        $('#modalVenta').modal('hide');
                        $('#ventaClienteId').val('');
                        $('#tipoDocumento').val('');
                        $('#ventaSerie').val('');
                        $('#ventaNumero').val('');
                        $('#ventaImporte').val('');
                        $('#ventaFecha').val('');
                        mostrarVentas();
                        noti_pre_registro();
                        noti_item_socio();
                        iziToast.success({
                            position: 'topRight',
                            title: 'Correcto',
                            message: 'Registro modificado correctamente.',
                        });
                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        } else {
            if (p_socioID.length == 0 || p_tipoDoc.length == 0 || p_serie.length == 0 || p_numero.length == 0 || p_importe.length == 0 || p_fecha.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });
            } else {
                var data = new FormData();
                data.append('p_opcion', 'add_transaccion');
                data.append('p_socioID', p_socioID);
                data.append('p_tipoDoc', p_tipoDoc);
                data.append('p_serie', p_serie);
                data.append('p_numero', p_numero);
                data.append('p_importe', p_importe);
                data.append('p_fecha', p_fecha);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlSocio/ventasRegistradas.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        $('#modalVenta').modal('hide');
                        $('#ventaClienteId').val('');
                        $('#tipoDocumento').val('');
                        $('#ventaSerie').val('');
                        $('#ventaNumero').val('');
                        $('#ventaImporte').val('');
                        $('#ventaFecha').val('');
                        mostrarVentas();
                        noti_pre_registro();
                        noti_item_socio();
                        iziToast.success({
                            position: 'topRight',
                            title: 'Correcto',
                            message: data,
                        });
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
    data.append('p_opcion', 'listado_ventas_registradas');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
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
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var noti_pre_registro = function () {
    var data = new FormData();
    data.append('p_opcion', 'noti_pre_regitro');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            if (data == 0) {
                $('#ventas_pre_registradas').addClass('hidden');
            } else {
                $('#ventas_pre_registradas').removeClass('hidden');
                $('#noti_ventas_pre_registradas').html(data);
            }
            //$('#btnMail').addClass('hidden');

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var noti_item_socio = function () {
    var data = new FormData();
    data.append('p_opcion', 'noti_pre_regitro_item');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#item_noti').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var editar = function (codigo) {
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
            $('#ventaDni').val(objeto[6]);
            $('#searchSocio').click()
        },
        error: function (msg) {
            alert(msg);
        }
    });
}


