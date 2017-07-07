<?php

  session_start();
  if (!isset($_SESSION['usuario']))
  {
    header("Location:view/controlusuario/login.php");
  } else {


$mi_usuario='root';
$mi_password='';

$dir_destino = 'profile/';
$imagen_subida = $dir_destino . basename($_FILES['foto']['name']);

$tipo=$_SESSION['usuarioTipo'];
$nuevoNombre = 'profile/profile'.$tipo.'.jpg';

//Variables del metodo POST
//$codigo=$_POST['codigo'];
//$descripcion=$_POST['descripcion'];

if(!is_writable($dir_destino)){
	echo "no tiene permisos";
}else{
	if(is_uploaded_file($_FILES['foto']['tmp_name'])){
		/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
		echo "Mostrar contenido\n";
		echo $imagen_subida;*/
		if (move_uploaded_file($_FILES['foto']['tmp_name'], $nuevoNombre)) {
			$link = mysql_connect('localhost', $mi_usuario, $mi_password)
				or die('Uyy!!!: ' . mysql_error());
			mysql_select_db('bdmundipack') or die('No pudo selecionar la BD');
			//Creamos nuestra consulta sql
			$query= 'UPDATE usuario SET `img` ="'.$nuevoNombre.'" where `idusuario`="'.$_SESSION['idusuario'].'";';
			//$query="insert into producto(codigo, descripcion, imagen) value ('$codigo', '$descripcion', '$imagen_subida')";
			//Ejecutamos la consutla
			mysql_query($query) or die(' Error al procesar consulta: ' . mysql_error());

			echo "El archivo es fue cargado exitosamente.\n";
			echo $query;

			//echo "<p>$codigo</p>";
			//echo "<p>$descripcion</p>";
			echo "<img src='http://localhost/mundipack/view/controlusuario/guardar/profile". basename($imagen_subida) ."' />";
		} else {
			echo "Posible ataque de carga de archivos!\n";
		}
	}else{
		echo "Posible ataque del archivo subido: ";
		echo "nombre del archivo '". $_FILES['archivo_usuario']['tmp_name'] . "'.";
	}
}
}
?>
