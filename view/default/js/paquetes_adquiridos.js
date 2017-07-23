window.onload = function(){
    //$('#tblPaquetes').DataTable();
    mostrarMenu();
    mostrarPaquetes();
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


var mostrarPaquetes = function () {
    var data = new FormData();
    data.append('p_opcion', 'listado_paquetes_adquiridos');
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
                $('#paquetes').html(data)
            }

        },
        error: function (msg) {
            alert(msg);
        }
    });
}




