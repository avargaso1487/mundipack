/**
 * Created by Jorge Luis on 07/07/2017.
 */
window.onload = function () {
    $('#tblVentasPreReg').DataTable();
    mostrarMenu();
    mostrarPreVentas();
    noti_pre_registro();
    noti_item_socio();
}

$(function () {
    $('#aceptarVenta').on('click', function () {
        confirmarTransaccion()
    });
});

var mostrarMenu = function () {
    var menu = document.getElementById('Menu').value;
    $.ajax({
        type: 'POST',
        data: 'opcion=mostrarMenu&menu=' + menu,
        url: "../../controller/controlusuario/usuario.php",
        success: function (data) {
            $('#permisos').html(data);
        }
    });
}

var mostrarPreVentas = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_ventas_pre_registradas');
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#tblVentasPreReg').DataTable().destroy();
            $('#cuerpoTablaVentasPreReg').html(data);
            $('#tblVentasPreReg').DataTable({
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

var aceptarTransaccion = function (codigo) {
    $('#modalAprobacion').modal('show');
    $('#transaccionID').val(codigo);

    var data = new FormData();
    data.append('p_opcion', 'obtener_venta_registrada');
    data.append('p_codigo', codigo);
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            objeto=JSON.parse(data);
            $('#spanDni').html(objeto[6]);
            $('#spanCliente').html(objeto[7]);
            $('#spanDoc').html(objeto[1]+'-'+objeto[2]);
            $('#spanMonto').html(objeto[3]);
        },
        error: function (msg) {
            alert(msg);
        }
    });

}

var confirmarTransaccion = function () {
    var data = new FormData();
    data.append('p_opcion', 'aceptar_transacion');
    data.append('p_codigo', $('#transaccionID').val());
    $.ajax({
        type: "post",
        url: "../../controller/controlSocio/ventasRegistradas.php",
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (data) {
            $('#modalAprobacion').modal('hide');
            iziToast.success({
                position: 'topRight',
                title: 'Correcto',
                message: 'Aprobación Correcta',
            });
            $('#tblVentasPreReg').DataTable().destroy();
            $('#cuerpoTablaVentasPreReg').html(data);
            $('#tblVentasPreReg').DataTable({
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
            noti_pre_registro();
            noti_item_socio();
        },
        error: function (msg) {
            alert(msg);
        }
    });
}