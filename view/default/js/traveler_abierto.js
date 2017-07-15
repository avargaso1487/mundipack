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
    var data = new FormData();
    data.append('p_opcion', 'listado_travelers_abiertos');
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
                    position: 'topRight',
                    title: 'Advertencia',
                    message: 'No se encontraron registros',
                });
            } else {
                $('#tblVentasReg').DataTable().destroy();
                $('#cuerpoTablaVentasReg').html(data);
                $('#tblVentasReg').DataTable({
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

