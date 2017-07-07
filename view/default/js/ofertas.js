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
        $('#p_codigo').val('');
        $('#p_descripcion').val('');
        $('#p_fechaInicio').val('');
        $('#p_fechaFin').val('');
        $('#p_stock').val('');
        $('#p_imagen').val('');
    });

    $('#guardarOferta').on('click', function () {
        var p_descripcion = $('#p_descripcion').val();
        var p_fechaInicio = $('#p_fechaInicio').val();
        var p_fechaFin = $('#p_fechaFin').val();
        var p_stock = $('#p_stock').val();
        var p_imagen = $('#p_imagen').val();
        var p_codigo = $('#p_codigo').val();

        if (p_codigo != '') {
            //console.log('Modificar datos');
            if (p_descripcion.length == 0 || p_fechaInicio.length == 0 || p_fechaFin.length == 0 ) {
                alert('Ingrese todos lo datos');
            } else {
                var data = new FormData($("#frm_nuevoOferta")[0]);
                data.append('p_opcion', 'update_oferta');
                $.ajax({
                    type: "post",
                    url: "../../controller/controlOferta/ofertas_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            alert('Registro Correcto');
                            $('#p_descripcion').val('');
                            $('#p_fechaInicio').val('');
                            $('#p_fechaFin').val('');
                            $('#p_stock').val('');
                            $('#p_imagen').val('');
                            noti_pre_registro();
                            noti_item_socio();
                            listarOfertas();
                        }

                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        } else {
            if (p_descripcion.length == 0 || p_fechaInicio.length == 0 || p_fechaFin.length == 0 ) {
                alert('Ingrese todos lo datos');
            } else {
                var data = new FormData($("#frm_nuevoOferta")[0]);
                data.append('p_opcion', 'add_oferta');
                $.ajax({
                    type: "post",
                    url: "../../controller/controlOferta/ofertas_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            alert('Registro Correcto');
                            $('#p_descripcion').val('');
                            $('#p_fechaInicio').val('');
                            $('#p_fechaFin').val('');
                            $('#p_stock').val('');
                            $('#p_imagen').val('');
                            noti_pre_registro();
                            noti_item_socio();
                            listarOfertas();
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
            $('#noti_ventas_pre_registradas').html(data);
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
            $('#stock').html(objeto[4]);
            //$('#imagen').html('<img class="img-responsive" alt="Imagen de Oferta" src="../default/assets/images/profile.png" />');
            $('#imagen').html('<img class="img-responsive" alt="Imagen de Oferta" src="'+objeto[5]+'" />');

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

/*var ofertas = function () {
    var plugins = function () {
        $('#tblOfertas').DataTable();
    }

    var eventoComtroles = function () {
        $('#guardarOferta').on('click', function () {
            var p_descripcion = $('#p_descripcion').val();
            var p_fechaInicio = $('#p_fechaInicio').val();
            var p_fechaFin = $('#p_fechaFin').val();
            var p_stock = $('#p_stock').val();
            var p_imagen = $('#p_imagen').val();

            if (p_descripcion.length == 0 || p_fechaInicio.length == 0 || p_fechaFin.length == 0 ) {
                alert('Ingrese todos lo datos');
            } else {
                var data = new FormData($("#frm_nuevoOferta")[0]);
                data.append('p_opcion', 'add_oferta');
                $.ajax({
                    type: "post",
                    url: "../../controller/controlOferta/ofertas_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            alert('Registro Correcto');
                            $('#p_descripcion').val('');
                            $('#p_fechaInicio').val('');
                            $('#p_fechaFin').val('');
                            $('#p_stock').val('');
                            $('#p_imagen').val('');
                            noti_pre_registro();
                            noti_item_socio();
                        }

                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        });

        $('#btnEliminar').on('click', function () {
            console.log('dsfsdagf');

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
                $('#noti_ventas_pre_registradas').html(data);
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

    return {
        init: function () {
            plugins();
            eventoComtroles();
            mostrarMenu();
            noti_pre_registro();
            noti_item_socio();
            listarOfertas();
        }
    };
}();*/


