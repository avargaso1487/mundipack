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
    total_viajeros();
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

var total_viajeros = function () {
    var data = new FormData();
    data.append('p_opcion', 'dashboard_total_viajeros');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#total_viajeros').html(data);
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