
<?php
session_start();

include_once "../../model/modelPerfiles/socio_perfil_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_contacto'] = '';
$param['p_atencion'] = '';
$param['p_paswword'] = '';


$param['p_archivoPerfil'] = '';
$param['p_fileArchivoPerfil'] = '';
$param['p_rutaPerfil'] = '';

$param['p_archivoCarta'] = '';
$param['p_fileArchivoCarta'] = '';
$param['p_rutaCarta'] = '';


if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];

if(isset($_POST['p_contacto']))
    $param['p_contacto'] = $_POST['p_contacto'];

if(isset($_POST['p_atencion']))
    $param['p_atencion'] = $_POST['p_atencion'];

if(isset($_POST['p_paswword']))
    $param['p_paswword'] = md5($_POST['p_paswword']);


// IMAGEN DE PERFIL
if(isset($_FILES['p_imagenPerfil']['name'])){
    $param['p_archivoPerfil'] = $_FILES['p_imagenPerfil']['name'];
}

if(isset($_FILES['p_imagenPerfil']['tmp_name'])){
    $param['p_fileArchivoPerfil'] = $_FILES['p_imagenPerfil']['tmp_name'];
}

$param['p_rutaPerfil'] = 'view/default/assets/images/users/'.$param['p_archivoPerfil'];


// IMAGEN DE CARTA
if(isset($_FILES['p_imagenCarta']['name'])){
    $param['p_archivoCarta'] = $_FILES['p_imagenCarta']['name'];
}

if(isset($_FILES['p_imagenCarta']['tmp_name'])){
    $param['p_fileArchivoCarta'] = $_FILES['p_imagenCarta']['tmp_name'];
}

$param['p_rutaCarta'] = 'view/partners/carta/'.$param['p_archivoCarta'];




$Perfiles = new Perfiles_model();
echo $Perfiles->gestionar($param);
?>

