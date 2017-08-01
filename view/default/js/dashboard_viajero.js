/**
 * Created by Jorge Luis on 15/07/2017.
 */
window.onload = function(){
    mostrarMenu();
    cargarDashboard();
    ultimosMovimientos();
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

var cargarDashboard = function () {
    comisiones();
    total_socios();
    nombre_paquete();
    noti_pagos();
}

var noti_pagos = function () {
    var data = new FormData();
    data.append('p_opcion', 'noti_pago_traveler');
    $.ajax({
        type: "post",
        url: "../../controller/controlTraveler/traveler_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 0) {
                $('#pago_traveler').addClass('hidden');
            } else {
                $('#pago_traveler').removeClass('hidden');
                dias_pago();
            }
        },
        error: function (msg) {
            alert(msg);
        }
    });
}


var dias_pago = function () {
    var data = new FormData();
    data.append('p_opcion', 'obtener_dias_faltantes');
    $.ajax({
        type: "post",
        url: "../../controller/controlTraveler/traveler_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#item_pago_traveler').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var comisiones = function () {
    var data = new FormData();
    data.append('p_opcion', 'obtener_comisiones');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#comisiones').html(parseFloat(data).toFixed(2));
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var total_socios = function () {
    var data = new FormData();
    data.append('p_opcion', 'dashboard_total_socios');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#total_socio').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var nombre_paquete = function () {
    var data = new FormData();
    data.append('p_opcion', 'dashboard_paquete_adquirido');
    $.ajax({
        type: "post",
        url: "../../controller/controlTraveler/traveler_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            if (data == 0) {
                $('#tituloCartilla').html('No tiene paquete adquirido.');
                $('#porcentaje_paquete').html('-');
            } else {
                $('#tituloCartilla').html(data);
                porcentaje_paquete();
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var porcentaje_paquete = function () {
    var data = new FormData();
    data.append('p_opcion', 'dashboard_paquete_porcentaje');
    $.ajax({
        type: "post",
        url: "../../controller/controlTraveler/traveler_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            objeto=JSON.parse(data);
            $('#porcentaje_paquete').html(objeto[0]+'%');
        },
        error: function (msg) {
            alert(msg);
        }
    });
}
var ultimosMovimientos = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_ultimos_movimientos_traveler');
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
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'No se hallaron movimientos.',
                });
            } else {
                $('#tblMovimientos').html(data);
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}