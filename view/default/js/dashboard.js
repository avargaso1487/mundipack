window.onload = function(){
    mostrarMenu();
    cargarDashboard();
    ultimosMovimientos();
}

$(function() {
    $('#addTipoCambio').on('click', function () {
        var data = new FormData();
        data.append('p_opcion', 'view_type');
        $.ajax({
            type:'POST',
            url: "../../controller/controladministrador/tipoCambio.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success:function(data){
                objeto=JSON.parse(data);
                if (objeto[2] == '1') {
                    $('#txtxPrecioCompra').val(objeto[0]);
                    $('#txtxPrecioVenta').val(objeto[1]);
                    $('#mensaje').html('(*) Ya existe un tipo de cambio registrado para hoy.');
                    $("#editarTipoCambio").css("display", "inline");
                    $("#guardarTipoCambio").css("display", "none");
                } else {
                    if (objeto[2] == '0') {
                        $('#txtxPrecioCompra').val(objeto[0]);
                        $('#txtxPrecioVenta').val(objeto[1]);
                        $('#mensaje').html('(*) Los datos son referenciales del dia de ayer.');
                        $("#guardarTipoCambio").css("display", "inline");
                        $("#editarTipoCambio").css("display", "none");
                    }
                }
            }
        });
    });

    $('#guardarTipoCambio').on('click', function () {
        var data = new FormData();
        data.append('p_opcion', 'add_type');
        data.append('p_montoCompra', $('#txtxPrecioCompra').val());
        data.append('p_montoVenta', $('#txtxPrecioVenta').val());

        $.ajax({
            type:'POST',
            url: "../../controller/controladministrador/tipoCambio.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success:function(data){
                if (data == '1') {
                    alert('Registro Correcto');
                    //console.log('Registro Correcto');
                } else {
                    if (data == '0') {
                        alert('Se ha modificado los valores del tipo de cambio');
                        //console.log('Se ha modificado los valores del tipo de cambio');
                    }

                }

            }
        });
    });

    $('#addPorcentaje').on('click', function () {
        valorPorcentaje();
        var data = new FormData();
        data.append('p_opcion', 'verificar_porcentaje');
        $.ajax({
            type:'POST',
            url: "../../controller/controladministrador/porcentajeRetorno.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success:function(data){
                if (data == '1') {
                    $("#divRegistro").css("display", "none");
                    $("#divObservacion").css("display", "inline");
                    $("#newPorcentaje").css("display", "inline");
                    $('#titulo').html('Observaciones');
                    $('#mensaje2').html('El Porcentaje Actual es de: ' + $('#txtValor').val() +'%.');

                } else {
                    if (data == '0') {
                        $("#divRegistro").css("display", "inline");
                        $("#divObservacion").css("display", "none");
                        $("#guardarPorcentaje").css("display", "inline");
                        $('#titulo').html('Registrar Porcentaje de Comisión (%)');
                    }
                }
            }
        });
    });

    $('#newPorcentaje').on('click', function () {
        $("#divRegistro").css("display", "inline");
        $("#divObservacion").css("display", "none");
        $("#guardarPorcentaje").css("display", "inline");
        $('#titulo').html('Registrar Porcentaje de Comisión (%)');
    });

    $('#guardarPorcentaje').on('click', function () {
        var data = new FormData();
        data.append('p_opcion', 'add_porcentaje');
        data.append('p_porcentaje', $('#txtxPorcentaje').val());

        $.ajax({
            type:'POST',
            url: "../../controller/controladministrador/porcentajeRetorno.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success:function(data){
                if (data == '1') {
                    $('#txtValor').val('');
                    alert('Registro Correcto');

                    //console.log('Registro Correcto');
                }

            }
        });
    });

    $('#new_venta').on('click', function () {
        cargarTipoDocumento();
        $('#ventaDni').val('');
        $('#ventaDni').attr("disabled",false)
        $('#ventaCliente').val('');

        $('#ventaClienteId').val('');
        $('#tipoDocumento').val('');
        $('#ventaSerie').val('');
        $('#ventaNumero').val('');
        $('#ventaImporte').val('');
        $('#ventaFecha').val('');

    });

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

    $('#guardarVenta').on('click', function () {
        var p_socioID = $('#ventaClienteId').val();
        var p_tipoDoc = $('#tipoDocumento').val();
        var p_serie = $('#ventaSerie').val();
        var p_numero = $('#ventaNumero').val();
        var p_importe = $('#ventaImporte').val();
        var p_fecha = $('#ventaFecha').val();

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
                    ultimosMovimientos();
                    noti_pre_registro();
                    noti_item_socio();
                    totalVentasSocio();
                    montoTotalVentasSocio();
                    nroSocios();
                    iziToast.success({
                        position: 'topRight',
                        title: 'Correcto',
                        message: 'Registro Correcto',
                    });
                },
                error: function (msg) {
                    alert(msg);
                }
            });
        }
    });

});



var ultimosMovimientos = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_ultimas_ventas_registradas');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#ultimosMovimientos').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var cargarDashboard = function () {
    noti_pre_registro();
    noti_item_socio();
    totalVentasSocio();
    montoTotalVentasSocio();
    nroSocios();
}


var totalVentasSocio = function () {
    var data = new FormData();
    data.append('p_opcion', 'total_ventas_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#totalVentasSocio').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var montoTotalVentasSocio = function () {
    var data = new FormData();
    data.append('p_opcion', 'monto_total_ventas_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#montoTotalVentasSocio').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var nroSocios = function () {
    var data = new FormData();
    data.append('p_opcion', 'total_numero_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#nroSocios').html(data);
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
                console.log(data);
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

var valorPorcentaje = function () {
    var data = new FormData();
    data.append('p_opcion', 'valor_porcentaje');
    $.ajax({
        type:'POST',
        url: "../../controller/controladministrador/porcentajeRetorno.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success:function(data){
            objeto=JSON.parse(data);
            $('#txtValor').val(objeto[0]);
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




