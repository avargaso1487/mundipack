window.onload = function(){
    $('#tblPaquetes').DataTable();
    mostrarMenu();
    mostrarPaquetes();
    cargarTravler();
}

$(function() {

    $('#guardarPaquete').on('click', function () {
        var p_nombre = $('#p_nombre').val();
        var p_descripcion = $('#p_descripcion').val();
        var p_precio = $('#p_precio').val();
        var paqueteID = $('#paqueteID').val();


        if (paqueteID != '') {
            if (p_nombre.length == 0 || p_descripcion.length == 0 || p_precio.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });
            } else {
                var data = new FormData();
                data.append('p_opcion', 'update_paquete_admin');
                data.append('p_nombre', p_nombre);
                data.append('p_descripcion', p_descripcion);
                data.append('p_precio', p_precio);
                data.append('paqueteID', paqueteID);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlAdministrador/paquetes_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        $('#modalVenta').modal('hide');
                        $('#p_nombre').val('');
                        $('#p_descripcion').val('');
                        $('#p_precio').val('');
                        $('#paqueteID').val('');
                        mostrarPaquetes();
                        iziToast.success({
                            position: 'topRight',
                            title: 'Correcto',
                            message: data,
                        });
                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        } else {
            if (p_nombre.length == 0 || p_descripcion.length == 0 || p_precio.length == 0 ) {
                iziToast.warning({
                    position: 'bottomCenter',
                    title: 'Advertencia',
                    message: 'Debe ingresar todos los datos obligatorios.',
                });
            } else {
                var data = new FormData();
                data.append('p_opcion', 'add_paquete_admin');
                data.append('p_nombre', p_nombre);
                data.append('p_descripcion', p_descripcion);
                data.append('p_precio', p_precio);
                $.ajax({
                    type: "post",
                    url: "../../controller/controlAdministrador/paquetes_controller.php",
                    contentType: false,
                    data: data,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        $('#modalVenta').modal('hide');
                        $('#p_nombre').val('');
                        $('#p_descripcion').val('');
                        $('#p_precio').val('');

                        mostrarPaquetes();
                        iziToast.success({
                            position: 'topRight',
                            title: 'Correcto',
                            message: data,
                        });
                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            }
        }


    });


    $('#eliminarPaquete').on('click', function () {
        var p_paqueteID = $('#p_paqueteID').val();
        var data = new FormData();
        data.append('p_opcion', 'eliminar_paquete_admin');
        data.append('paqueteID', p_paqueteID);
        $.ajax({
            type: "post",
            url: "../../controller/controlAdministrador/paquetes_controller.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success: function (data) {
                $('#modalAprobacion').modal('hide');
                $('#p_paqueteID').val('');

                mostrarPaquetes();
                iziToast.success({
                    position: 'topRight',
                    title: 'Correcto',
                    message: data,
                });
            },
            error: function (msg) {
                alert(msg);
            }
        });

    });

    $('#activarPaquete').on('click', function () {
        var p_paqueteID = $('#p_paqueteID').val();
        var data = new FormData();
        data.append('p_opcion', 'activar_paquete_admin');
        data.append('paqueteID', p_paqueteID);
        $.ajax({
            type: "post",
            url: "../../controller/controlAdministrador/paquetes_controller.php",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success: function (data) {
                $('#modalAprobacion').modal('hide');
                $('#p_paqueteID').val('');

                mostrarPaquetes();
                iziToast.success({
                    position: 'topRight',
                    title: 'Correcto',
                    message: data,
                });
            },
            error: function (msg) {
                alert(msg);
            }
        });
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

var cargarTravler = function () {
    var data = new FormData();
    data.append('p_opcion', 'cbo_traveler');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#divSocio').html(data);
        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var aceptar = function (p_pagoID) {
    $('#p_pagoID').val(p_pagoID);
    var data = new FormData();
    data.append('p_opcion', 'obtener_pago_traveler');
    data.append('p_pagoID', p_pagoID);
    $.ajax({
        type: "post",
        url: "../../controller/controlTraveler/traveler_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#modalAprobacion').modal('show');
            objeto=JSON.parse(data);
            $('#spanCliente').html(objeto[6]);
            $('#spanOperacion').html(objeto[2]);
            $('#spanMonto').html(objeto[3]);
            $('#spanFecha').html(objeto[4]);

        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var mostrarPaquetes = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_paquetes');
    $.ajax({
        type: "post",
        url: "../../controller/controlAdministrador/paquetes_controller.php",
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
                $('#tblPaquetes').DataTable().destroy();
                $('#cuerpoTablaPaquetes').html(data);
                $('#tblPaquetes').DataTable({
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
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}


var editarPaquete = function (p_paqueteID) {
    var data = new FormData();
    data.append('p_opcion', 'obtener_paquete');
    data.append('paqueteID', p_paqueteID);
    $.ajax({
        type: "post",
        url: "../../controller/controlAdministrador/paquetes_controller.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#modalVenta').modal('show');
            objeto=JSON.parse(data);
            $('#paqueteID').val(objeto[0]);
            $('#p_nombre').val(objeto[1]);
            $('#p_descripcion').val(objeto[2]);
            $('#p_precio').val(objeto[3]);


        },
        error: function (msg) {
            alert(msg);
        }
    });
}

var eliminar = function (p_paqueteID) {
    $('#modalAprobacion').modal('show');
    $('#mensaje').html('¿Esta seguro en desactivar este Paquete?');
    $('#p_paqueteID').val(p_paqueteID);
    $("#activarPaquete").css("display", "none");
    $('#eliminarPaquete').css('display','inline');
}

var activar = function (p_paqueteID) {
    $('#modalAprobacion').modal('show');
    $('#mensaje').html('¿Esta seguro en activar nuevamente este Paquete?');
    $('#p_paqueteID').val(p_paqueteID);
    $("#activarPaquete").css("display", "inline");
    $('#eliminarPaquete').css('display','none');
}


