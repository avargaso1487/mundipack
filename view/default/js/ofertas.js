/**
 * Created by Jorge Luis on 06/07/2017.
 */

window.onload = function(){
    $('#tblOfertas').DataTable();
    mostrarMenu();
    noti_pre_registro();
    noti_item_socio();
    listarOfertas();
}

$(function() {

    $('#new_oferta').on('click', function () {
        $('#titulo').html('Registrar - Oferta');
        $('#p_codigo').val('');
        $('#p_descripcion').val('');
        $('#p_fechaInicio').val('');
        $('#p_fechaFin').val('');
        $('#p_stock').val('');
        $('#p_imagen').val('');
        $('#p_porcentaje').prop('checked', false).parent().addClass('checked');
    });

    $('#guardarOferta').on('click', function () {
        var p_descripcion = $('#p_descripcion').val();
        var p_fechaInicio = $('#p_fechaInicio').val();
        var p_fechaFin = $('#p_fechaFin').val();
        var p_stock = $('#p_stock').val();
        var p_imagen = $('#p_imagen').val();
        var p_codigo = $('#p_codigo').val();
        if ($('#p_porcentaje').is(":checked")) {
            var p_porcentaje = '1';
        } else {
            var p_porcentaje = '0';
        }

        if (p_codigo != '') {
            //console.log('Modificar datos');
            if (p_descripcion.length == 0 || p_fechaInicio.length == 0 || p_fechaFin.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });
            } else {
                var data = new FormData($("#frm_nuevoOferta")[0]);
                data.append('p_opcion', 'update_oferta');
                data.append('p_porcentaje', p_porcentaje);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlOferta/ofertas_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            //alert('Registro Correcto');
                            $('#modalOferta').modal('hide');
                            $('#p_descripcion').val('');
                            $('#p_fechaInicio').val('');
                            $('#p_fechaFin').val('');
                            $('#p_stock').val('');
                            $('#p_imagen').val('');
                            noti_pre_registro();
                            noti_item_socio();
                            listarOfertas();
                            iziToast.success({
                                position: 'topRight',
                                title: 'Correcto',
                                message: 'Registro modificado correctamente',
                            });
                        }

                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        } else {
            if (p_descripcion.length == 0 || p_fechaInicio.length == 0 || p_fechaFin.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });
            } else {
                var data = new FormData($("#frm_nuevoOferta")[0]);
                data.append('p_opcion', 'add_oferta');
                data.append('p_porcentaje', p_porcentaje);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlOferta/ofertas_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            //alert('Registro Correcto');
                            $('#modalOferta').modal('hide');
                            $('#p_descripcion').val('');
                            $('#p_fechaInicio').val('');
                            $('#p_fechaFin').val('');
                            $('#p_stock').val('');
                            $('#p_imagen').val('');
                            noti_pre_registro();
                            noti_item_socio();
                            listarOfertas();
                            iziToast.success({
                                position: 'topRight',
                                title: 'Correcto',
                                message: 'Registro Correcto',
                            });
                        }

                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        }


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

var listarOfertas = function () {
    var data = new FormData();
    data.append('p_opcion', 'listar_ofertas');
    $.ajax({
        type: "post",
        url: "../../controller/controlOferta/ofertas_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#tblOfertas').DataTable().destroy();
            $('#cuerpoTablaOfertas').html(data);
            $('#tblOfertas').DataTable({
                "dom": '<"top"fl<"clear">>rt<"bottom"ip<"clear">>',
                "oLanguage": {
                    "sSearch": "",
                    "sLengthMenu": "_MENU_"
                },
                "initComplete": function initComplete(settings, json) {
                    $('div.dataTables_filter input').attr('placeholder', 'Buscar...');
                    // $(".dataTables_wrapper select").select2({
                    //   minimumResultsForSearch: Infinity
                    // });
                }
            });
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var eliminar = function (codigo) {
    var data = new FormData();
    data.append('p_opcion', 'eliminar_ofertas');
    data.append('p_codigo', codigo);
    $.ajax({
        type: "post",
        url: "../../controller/controlOferta/ofertas_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            if (data == 1) {
                listarOfertas();
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var activar = function (codigo) {
    var data = new FormData();
    data.append('p_opcion', 'activar_ofertas');
    data.append('p_codigo', codigo);
    $.ajax({
        type: "post",
        url: "../../controller/controlOferta/ofertas_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            if (data == 1) {
                listarOfertas();
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var editar = function (codigo) {
    $('#titulo').html('Editar - Oferta');
    var data = new FormData();
    data.append('p_opcion', 'obtener_ofertas');
    data.append('p_codigo', codigo);
    $.ajax({
        type: "post",
        url: "../../controller/controlOferta/ofertas_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            objeto=JSON.parse(data);
            //$('#txtValor').val(objeto[0]);
            $('#p_codigo').val(objeto[0]);
            $('#p_descripcion').val(objeto[1]);
            $('#p_fechaInicio').val(objeto[2]);
            $('#p_fechaFin').val(objeto[3]);
            $('#p_stock').val(objeto[4]);

            if (objeto[7] == '1') {
                $('#p_porcentaje').prop('checked', true).parent().addClass('checked');
            } else {
                $('#p_porcentaje').prop('checked', false).parent().addClass('checked');
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var ver = function (codigo) {
    var data = new FormData();
    data.append('p_opcion', 'obtener_ofertas');
    data.append('p_codigo', codigo);
    $.ajax({
        type: "post",
        url: "../../controller/controlOferta/ofertas_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            objeto=JSON.parse(data);
            //$('#txtValor').val(objeto[0]);
            $('#descripcion').html(objeto[1]);
            $('#fechaInicio').html(objeto[2]);
            $('#fechaFin').html(objeto[3]);
            if (objeto[4] == '') {
                $('#stock').html(' - ');
            } else {
                $('#stock').html(objeto[4]);
            }

            if (objeto[7] == 1) {
                $('#retorno').html('SI');
            } else {
                $('#retorno').html('NO');

            }


            //$('#imagen').html('<img class="img-responsive" alt="Imagen de Oferta" src="../default/assets/images/profile.png" />');
            $('#imagen').html('<img class="img-responsive" alt="Imagen de Oferta" src="'+objeto[5]+'" />');

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

