window.onload = function(){
	$('#socios').DataTable();
	mostrarMenu();
	mostrarDatos();
}

function nuevo()
{
	//limpiar();	
	document.getElementById('guardarSocio').style.display = 'inline';
  document.getElementById('editarSocio').style.display = 'none';
}

function limpiar()
{		
	document.getElementById('socioRazonSocial').value = "";
  	document.getElementById('socioRUC').value = "";
  	document.getElementById('socioNombreComercial').value = "";  
  	document.getElementById('socioRubro').value = "";  
  	document.getElementById('socioDireccion').value = "";  
  	document.getElementById('socioTelefonoContacto').value = "";    	
  	document.getElementById('socioTelefonoAtencion').value = "";  
  	document.getElementById('socioEmail').value = "";
  	document.getElementById('socioNroCuenta').value = "";
  	document.getElementById('socioContactoResponsable').value = "";
  	document.getElementById('socioPrctjRetorno').value = "";
  	document.getElementById('socioCategoria1').checked = false;
  	document.getElementById('socioCategoria2').checked = false;
  	document.getElementById('socioCategoria3').checked = false;
  	document.getElementById('socioCategoria4').checked = false;
  	document.getElementById('socioCategoria5').checked = false;
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
	var param_opcion = "listarSocios";
	$.ajax({
		type: 'POST',
		data: 'opcion='+param_opcion,
		url: '../../controller/controladministrador/administrador.php',
		success: function(respuesta){
			$('#socios').DataTable().destroy();
			$('#cuerpoTablaSocios').html(respuesta);
			$('#socios').DataTable({
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
			$('#cuerpoTablaSocios').html(respuesta);
		}
	});	
}

function guardar()
{
	var param_opcion = "grabarSocio";
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
  		data: $('#frm_nuevoSocio').serialize()+'&opcion='+param_opcion,
  		url: '../../controller/controladministrador/administrador.php',
  		success: function(data)
  		{
  			if(data === '1')
  			{
  				mostrarDatos();
  				swal({
  				  title: "Éxito!",
  				  text: "Se registraron los datos del nuevo Net Partner",
  				  type: "success",
  				  confirmButtonText: "OK"
  				});  						
  			}
  		}
  	});
}

function eliminar(socioID)
{
  swal({
    title: "Confirmar",
    text: "¿Desea eliminar este Net Partner?",
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
      var param_opcion = "eliminarSocio";
      $.ajax({
        type:'POST',
        data:'opcion='+param_opcion+'&socioID='+socioID,
        url: '../../controller/controladministrador/administrador.php',
        success: function(respuesta)
        {           
          mostrarDatos();
          swal({
            title: "Éxito!",
            text: "Se eliminaron los datos del Net Partner",
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

function editar(socioID)
{

}
