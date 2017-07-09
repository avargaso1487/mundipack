window.onload = function(){
	$('#viajeros').DataTable();
	mostrarMenu();
	mostrarDatos();
}

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
	var param_opcion = "listarViajeros";
	$.ajax({
		type: 'POST',
		data: 'opcion='+param_opcion,
		url: '../../controller/controladministrador/administrador.php',
		success: function(respuesta){      
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
				});;
		},
		error: function(respuesta){
			$('#cuerpoTablaViajeros').html(respuesta);
		}
	});	
}

function guardar()
{
	var param_opcion = "grabarViajero";
	/*
	var = document.getElementById('param_razonSocial').value;
  	var = document.getElementById('param_ruc').value;
  	var = document.getElementById('param_nombre').value 
  	var = document.getElementById('param_rubro').value 
  	var = document.getElementById('param_direccion').value 
  	var = document.getElementById('param_telefonoContacto').value	
  	var = document.getElementById('param_telefonoAtencion').value 
  	var = document.getElementById('param_email').value;
  	var = document.getElementById('param_nroCuenta').value;
  	var = document.getElementById('param_contactoResponsable').value;
  	var = document.getElementById('param_prctjRetorno').value;
  	var = document.getElementById('param_categoria1').checked;
  	var = document.getElementById('param_categoria2').checked;
  	var = document.getElementById('param_categoria3').checked;
  	var = document.getElementById('param_categoria4').checked;
  	var = document.getElementById('param_categoria5').checked;
	*/
  	//HACER VALIDACIÓN DE CAMPOS
  	
  	$.ajax({
  		type: 'POST',
  		data: $('#frm_nuevoViajero').serialize()+'&opcion='+param_opcion,
  		url: '../../controller/controladministrador/administrador.php',
  		success: function(data)
  		{
  			if(data === '1')
  			{
  				mostrarDatos();
  				swal({
  				  title: "Éxito!",
  				  text: "Se registraron los datos del nuevo Traveler",
  				  type: "success",
  				  confirmButtonText: "OK"
  				});  						
  			}
  		}
  	});
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