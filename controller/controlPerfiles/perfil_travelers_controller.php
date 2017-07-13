
<?php
session_start();

include_once "../../model/modelPerfiles/travelers_perfil_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_usuario'] = '';

$param['p_archivoPerfil'] = '';
$param['p_fileArchivoPerfil'] = '';
$param['p_rutaPerfil'] = '';



if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];

if (isset($_SESSION['idusuario']))
    $param['p_usuario'] = $_SESSION['idusuario'];


// IMAGEN DE PERFIL
if(isset($_FILES['p_imagenPerfil']['name'])){
    $param['p_archivoPerfil'] = $_FILES['p_imagenPerfil']['name'];
}

if(isset($_FILES['p_imagenPerfil']['tmp_name'])){
    $param['p_fileArchivoPerfil'] = $_FILES['p_imagenPerfil']['tmp_name'];
}

$param['p_rutaPerfil'] = 'view/default/assets/images/users/'.$param['p_archivoPerfil'];


$Perfiles = new Perfiles_model();
echo $Perfiles->gestionar($param);
?>

