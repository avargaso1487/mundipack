window.onload = function(){
    mostrarMenu();
    cargarDashboard();
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
                    } else {
                        if (objeto[0] == 2) {
                            $('#txtxPrecioCompra').val('');
                            $('#txtxPrecioVenta').val('');
                            $("#guardarTipoCambio").css("display", "inline");
                            $("#editarTipoCambio").css("display", "none");
                        }
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

});


var cargarDashboard = function () {
    nroSocios();
    noti_pre_pago_socio();
    noti_pre_pago_traveler();
}

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
            if(objeto != null) $('#txtValor').val(objeto[0]);
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