/**
 * Created by Jorge Luis on 11/07/2017.
 */

window.onload = function(){
    mostrarMenu();
    ver();
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

$(function() {
    $('#editarPerfil').on('click', function () {
        $('#modalPerfilModificar').modal('show');
    });

    $('#modificarPerfil').on('click', function () {
        var data = new FormData($("#frm_updatePerfil")[0]);
        data.append('p_opcion', 'update_perfil_travelers');
        $.ajax({
            type: "post",
            url: "../../controller/controlPerfiles/perfil_travelers_controller.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success: function (data) {
                if ($('#p_password').val() == "") {
                    $('#modalPerfilModificar').modal('hide');
                    $('#p_imagenPerfil').val('');
                    ver();
                    iziToast.success({
                        position: 'topRight',
                        title: 'Correcto',
                        message: 'Registro modificado correctamente',
                    });
                } else {
                    $('#modalPerfilModificar').modal('hide');
                    $('#modalPerfilConfirmacion').modal('show');
                }

            },
            error: function (msg) {
                alert(msg);
            }
        });
    });

    $('#confirmarCambios').on('click', function () {
        $('#modalPerfilConfirmacion').modal('hide');
        location.href = "../../view/controlusuario/logout.php";

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

var ver = function (codigo) {
    var data = new FormData();
    data.append('p_opcion', 'obtener_perfil_travelers');
    $.ajax({
        type: "post",
        url: "../../controller/controlPerfiles/perfil_travelers_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            objeto=JSON.parse(data);
            $('#traveler_nombres').html(objeto[0]+'' +objeto[1]);
            $('#traveler_direccion').html(objeto[2]);
            $('#traveler_dni').html(objeto[3]);
            $('#traveler_email').html(objeto[4]);
            $('#traveler_nacimiento').html(objeto[5]);
            $('#traveler_fijo').html(objeto[6]);
            $('#traveler_movil').html(objeto[7]);
            $('#traveler_pasaporte').html(objeto[8]);
            $('#imagen').html('<img class="img-responsive" alt="Imagen de Perfil Socio" src="../../'+objeto[9]+'" />');

            $('#p_fijo').val(objeto[6]);
            $('#p_movil').val(objeto[7]);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

