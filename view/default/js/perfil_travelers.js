/**
 * Created by Jorge Luis on 11/07/2017.
 */

window.onload = function(){
    mostrarMenu();
    noti_pre_registro();
    noti_item_socio();
    ver();
}

$(function() {
    $('#editarPerfil').on('click', function () {
        $('#modalPerfilModificar').modal('show');
    });

    $('#modificarPerfil').on('click', function () {
        var data = new FormData($("#frm_updatePerfil")[0]);
        data.append('p_opcion', 'update_perfil_socio');
        $.ajax({
            type: "post",
            url: "../../controller/controlPerfiles/perfil_socio_controller.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success: function (data) {
                if ($('#p_paswword').val() == "") {
                    $('#modalPerfilModificar').modal('hide');
                    $('#p_imagenPerfil').val('');
                    $('#p_imagenCarta').val('');
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
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

