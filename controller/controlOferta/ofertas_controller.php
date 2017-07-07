
<?php
session_start();

include_once "../../model/modelOferta/ofertas_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_descripcion'] = '';
$param['p_fechaInicio'] = '';
$param['p_fechaFin'] = '';
$param['p_stock'] = '';
$param['p_usuario'] = '';
$param['p_archivo'] = '';
$param['p_fileArchivo'] = '';
$param['p_ruta'] = '';
$param['p_codigo'] = '';



if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];

if(isset($_POST['p_codigo']))
    $param['p_codigo'] = $_POST['p_codigo'];

if(isset($_POST['p_descripcion']))
    $param['p_descripcion'] = $_POST['p_descripcion'];

if(isset($_POST['p_fechaInicio']))
    $param['p_fechaInicio'] = $_POST['p_fechaInicio'];

if(isset($_POST['p_fechaFin']))
    $param['p_fechaFin'] = $_POST['p_fechaFin'];

if(isset($_POST['p_stock']))
    $param['p_stock'] = $_POST['p_stock'];


if(isset($_FILES['p_imagen']['name'])){
    $param['p_archivo'] = $_FILES['p_imagen']['name'];
}

if(isset($_FILES['p_imagen']['tmp_name'])){
    $param['p_fileArchivo'] = $_FILES['p_imagen']['tmp_name'];
}

$param['p_ruta'] = '../../view/partners/ofertas/'.$param['p_archivo'];

if (isset($_SESSION['idusuario']))
    $param['p_usuario'] = $_SESSION['idusuario'];


$Oferta = new Ofertas_model();
echo $Oferta->gestionar($param);
?>

