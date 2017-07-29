window.onload = function(){
    mostrarMenu();
    cargarDashboard();
    ultimosMovimientos();
}

$(function() {

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
                    ventaNeta();
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
    ventaNeta();
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

var ventaNeta = function () {
    var data = new FormData();
    data.append('p_opcion', 'venta_neta_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            var montoTotal =$('#txtMontoTotal').val();
            var monto_neto = parseFloat(montoTotal).toFixed(2) - (parseFloat(montoTotal).toFixed(2)*(parseFloat(data).toFixed(2)/100));
            console.log(monto_neto);
            $('#ventaNeta').html(parseFloat(monto_neto).toFixed(2));
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
            $('#montoTotalVentasSocio').html(parseFloat(data).toFixed(2));
            $('#txtMontoTotal').val(data);
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