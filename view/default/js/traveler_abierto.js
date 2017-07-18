/**
 * Created by Jorge Luis on 05/07/2017.
 */

window.onload = function(){
    $('#tblVentasReg').DataTable();
    mostrarMenu();
    mostrarTraveler();
}

$(function() {


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

var mostrarTraveler = function () {
    //var data = new FormData();
    //data.append('p_opcion', 'listado_travelers_abiertos');

    var data = new FormData();
    data.append('p_opcion', 'listado_four_travelers_abiertos');
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
                    message: 'No se encontraron registros',
                });
            } else {
                $('#listTravelers').html(data);
            }

        },
        error: function (msg) {
            alert(msg);
        }
    })
}

var all_traveler_abierto = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_travelers_abiertos');
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
                    message: 'No se encontraron registros',
                });
            } else {
                $('#listTravelers').html(data);
            }

        },
        error: function (msg) {
            alert(msg);
        }
    })
}




