$(function(){
	$('#btnLogin').on('click', function() {
		var usuario = $('#usuario').val();
		var password = $('#password').val();
		var opcion = $('#opcion').val();		
		$.ajax({
			type: 'POST',
			url: 'controller/controlusuario/usuario.php',
			data: 'usuario='+usuario+'&password='+password+'&opcion='+opcion,
			dataType: 'json',
			encode: true,
			success: function(data){
				//cargarDashboard();
				location.href = "view/dashboard/";
			}
		});
	});
});

function cargarDashboard()
{
  $.ajax({
      type:'POST',
      data: 'opcion=cargarDashboard',
      url: "../../controller/controlusuario/usuario.php",
      success:function(data){          
      }
  });
}