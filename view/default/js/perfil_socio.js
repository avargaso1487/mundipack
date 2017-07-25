/**
 * Created by Jorge Luis on 06/07/2017.
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

var ver = function (codigo) {
    var data = new FormData();
    data.append('p_opcion', 'obtener_perfil_socio');
    $.ajax({
        type: "post",
        url: "../../controller/controlPerfiles/perfil_socio_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            objeto=JSON.parse(data);
            $('#netpartner_RazonSocial').html(objeto[0]);
            $('#netpartner_Ruc').html(objeto[1]);
            $('#netpartner_Comercial').html(objeto[2]);
            $('#netpartner_Rubro').html(objeto[3]);
            $('#netpartner_Direccion').html(objeto[4]);
            $('#netpartner_Email').html(objeto[5]);
            $('#netpartner_Contacto').html(objeto[6]);
            $('#p_contacto').val(objeto[6]);
            $('#netpartner_Atencion').html(objeto[7]);
            $('#p_atencion').val(objeto[7]);
            $('#imagen').html('<img class="img-responsive" alt="Imagen de Perfil Socio" src="../../'+objeto[8]+'" />');
            $('#netpartner_porcentaje').html(objeto[9]);
            if (objeto[10] == 0) {
                $('#carta').html('');
            } else {
                $('#carta').html('<img class="img-responsive" style="width: 120px;height: 120px;" alt="Imagen de Perfil Socio" src="../../'+objeto[10]+'" />');
                $('#fotoCarta').html('<img class="img-responsive" style="width: 120px;height: 120px;" alt="Imagen de Perfil Socio" src="../../'+objeto[10]+'" />');
            }
            $('#fotoperfil').html('<img class="img-responsive"  style="width: 120px;height: 120px;" alt="Imagen de Perfil Socio" src="../../'+objeto[8]+'" />');

        },
        error: function (msg) {
            alert(msg);
        }
    });
}
