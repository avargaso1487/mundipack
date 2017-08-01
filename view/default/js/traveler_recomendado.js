window.onload = function(){
    $('#viajeros').DataTable();
    mostrarMenu();
    mostrarDatos();
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

    $('#guardarViajero').on('click', function () {
        guardar();
    });


});


function nuevo()
{
    //limpiar();
    document.getElementById('guardarViajero').style.display = 'inline';
    document.getElementById('editarViajero').style.display = 'none';
}


function limpiar()
{
    document.getElementById('viajeroNombre').value = "";
    document.getElementById('viajeroApellidos').value = "";
    document.getElementById('viajeroDNI').value = "";
    document.getElementById('viajeroDireccion').value = "";
    document.getElementById('viajeroNacimiento').value = "";
    document.getElementById('viajeroTelefonoFijo').value = "";
    document.getElementById('viajeroTelefonoCelular').value = "";
    document.getElementById('viajeroEmail').value = "";
    document.getElementById('viajeroNroPasaporte').value = "";
    document.getElementById('viajeroAbierto').value = "";
}

function mostrarMenu(){
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

function mostrarDatos(){
    var param_opcion = "listar_viajeros_recomendados";
    $.ajax({
        type: 'POST',
        data: 'opcion='+param_opcion,
        url: '../../controller/controladministrador/administrador.php',
        success: function(respuesta){

            if (respuesta == 0) {
                iziToast.warning({
                    position: 'topRight',
                    title: 'Advertencia',
                    message: 'No se encontraron registros',
                });
            } else {
                $('#viajeros').DataTable().destroy();
                $('#cuerpoTablaViajeros').html(respuesta);
                $('#viajeros').DataTable({
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
        error: function(respuesta){
            $('#cuerpoTablaViajeros').html(respuesta);
        }
    });
}

function guardar()
{
    var param_opcion = "grabar_viajero_recomendado";

    var viajeroNombre = $('#viajeroNombre').val();
    var viajeroApellidos = $('#viajeroApellidos').val();
    var viajeroDNI = $('#viajeroDNI').val();
    var viajeroNacimiento = $('#viajeroNacimiento').val();
    var viajeroTelefonoFijo = $('#viajeroTelefonoFijo').val();
    var viajeroTelefonoCelular = $('#viajeroTelefonoCelular').val();
    var viajeroEmail = $('#viajeroEmail').val();

     /*var = document.getElementById('param_email').value;
     var = document.getElementById('param_nroCuenta').value;
     var = document.getElementById('param_contactoResponsable').value;
     var = document.getElementById('param_prctjRetorno').value;
     var = document.getElementById('param_categoria1').checked;
     var = document.getElementById('param_categoria2').checked;
     var = document.getElementById('param_categoria3').checked;
     var = document.getElementById('param_categoria4').checked;
     var = document.getElementById('param_categoria5').checked;*/

    //HACER VALIDACIÓN DE CAMPOS
    if (viajeroNombre.length ==  0 || viajeroApellidos.length ==  0 || viajeroDNI.length ==  0 ||  viajeroTelefonoFijo.length ==  0 || viajeroTelefonoCelular.length ==  0 || viajeroEmail.length ==  0) {
        iziToast.warning({
            position: 'topRight',
            title: 'Advertencia',
            message: 'No se encontraron registros',
        });
    } else {
        $.ajax({
            type: 'POST',
            data: $('#frm_nuevoViajero').serialize()+'&opcion='+param_opcion,
            url: '../../controller/controladministrador/administrador.php',
            success: function(data)
            {
                if(data === '1')
                {
                    $('#modalViajero').modal('hide');
                    mostrarDatos();
                    iziToast.success({
                        position: 'topRight',
                        title: 'Correcto',
                        message: 'Se registro correctamente.',
                    });
                }
            }
        });
    }
}

function eliminar(viajeroID)
{
    swal({
            title: "Confirmar",
            text: "¿Desea eliminar este Traveler?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "SÍ",
            cancelButtonText: "NO",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                var param_opcion = "eliminarViajero";
                $.ajax({
                    type:'POST',
                    data:'opcion='+param_opcion+'&viajeroID='+viajeroID,
                    url: '../../controller/controladministrador/administrador.php',
                    success: function(respuesta)
                    {
                        mostrarDatos();
                        swal({
                            title: "Éxito!",
                            text: "Se eliminaron los datos del Traveler",
                            type: "success",
                            confirmButtonText: "OK"
                        });
                    },
                    error: function(respuesta)
                    {
                        swal("ERROR", "No se pudo realizar la eliminación.", "error");
                    }
                });
            } else {
                swal("CANCELADO", "Se canceló la acción de eliminación.", "error");
            }
        });
}

function editar(viajeroID)
{

}