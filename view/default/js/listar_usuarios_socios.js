
window.onload = function(){
	mostrarDatos();	
}

function mostrarDatos(){
	$.ajax({
		type: 'POST',
		data:{param_opcion: 'listarUsuariosSocios'},
		url: '../../../controller/controlusuario/usuario.php',
		success: function(respuesta){
			$('#uSocios').DataTable().destroy();
			$('#cuerpoUSocios').html(respuesta);
			$('#uSocios').DataTable();
		},
		error: function(respuesta){
			$('#cuerpoUSocios').html(respuesta);
		}
	});	
}



