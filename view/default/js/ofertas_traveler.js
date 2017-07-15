/**
 * Created by Jorge Luis on 11/07/2017.
 */

window.onload = function(){
    mostrarMenu();
    mostrarOfertas();
}

$(function() {


});

var all_socio = function () {
    var data = new FormData();
    data.append('p_opcion', 'get_all_ofertas');
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
                $('#listSocios').html(data);
            }


        },
        error: function (msg) {
            alert(msg);
        }
    })
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

var mostrarOfertas = function () {
    var data = new FormData();
    data.append('p_opcion', 'get_four_all_ofertas');
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
                $('#listSocios').html(data);
            }

        },
        error: function (msg) {
            alert(msg);
        }
    })
}


