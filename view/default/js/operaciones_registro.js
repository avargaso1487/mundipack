$(function() {
	$('#nuevoSocio').on('click', function(){
		var nombre = $('#param_nombre').val();
		var rubro = $('#param_rubro').val();
		var ruc = $('#param_ruc').val();
		var direccion = $('#param_direccion').val();
		var telefono = $('#param_telefono').val();
		var web = $('#param_web').val();
		var email = $('#param_email').val();

		if (nombre.length == '' || rubro.length == '' || ruc.length == '' || direccion.length == '') {            
            $("#mensaje").html(
            	
            	'<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>¡Advertencia!</strong> Debe llenar los campos necesarios</div>'	).show(200).delay(3500).hide(200);
        } else {
        	$.ajax({
		        type: 'POST',        
		        data: $('#frm_nuevoSocio').serialize()+'&param_opcion=nuevoSocio',
		        url: '../../../controller/controlusuario/usuario.php',
		        success: function(data){
		            $("#mensaje").html('<div class="alert alert-success" role="alert"><strong>¡Bien hecho!</strong> Registro Exitoso </div>').show()
		                        //window.location = "../index.php";
		            $('#param_opcion').val('nuevoSocio');
					$("#param_nombre").val('');
					$("#param_rubro").val('');
					$("#param_ruc").val('');
					$("#param_direccion").val('');
					$("#param_telefono").val('');
					$("#param_web").val('');
					$("#param_email").val('');
					setTimeout("location.href='../../operaciones/socios/listar_socios.php'",1000)        

		        },
		        error: function(data){
		                   
		        } 
			});
        }
		
	});

});


function editar(id){	
	
	var param_opcion = 'modificarUsuario';
	
	$.ajax({
		type: 'POST',
		data:'param_opcion='+param_opcion+'&id='+id,
		url: '../../controller/controlusuario/usuario.php',
		success: function(data){
			console.log(data);
			$('#param_opcion').val('modificarUsuario');
			$('#cabeceraRegistro').html(".:: Modificar Usuario ::.");		
		  	$('#modalUsuario').modal({
		  		show:true,
		  		backdrop:'static',
		  	});
			objeto=JSON.parse(data);
			$("#param_dni").val(objeto[0]);
			$("#param_paterno").val(objeto[1]);
			$("#param_materno").val(objeto[2]);
			$("#param_nombres").val(objeto[3]);
			$("#param_email").val(objeto[4]);
			$('#param_evento > option[value="'+objeto[5]+'"]').attr('selected', 'selected');
			$('#param_certificado > option[value="'+objeto[6]+'"]').attr('selected', 'selected');			
			$("#param_id").val(objeto[7]);		  	
		},
		error: function(data){
			
		}
	});
}

function eliminar(id){	
	
	var param_opcion = 'eliminarUsuario';
	var r = confirm("¿Esta seguro que desea eliminar esta información?");
	if (r == true) {
	    $.ajax({
			type: 'POST',
			data:'param_opcion='+param_opcion+'&id='+id,
			url: '../../controller/controlusuario/usuario.php',
			success: function(data){
				mostrarDatos();		  	
			},
			error: function(data){
				
			}
		});
	} else {
	   mostrarDatos();
	} 	
}
