<?php
session_start();

include_once "../../model/modeladministrador/porcentajeRetorno_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_porcentaje'] = '';
$param['p_usuario'] = '';


if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];


if(isset($_POST['p_porcentaje']))
    $param['p_porcentaje'] = $_POST['p_porcentaje'];

if (isset($_SESSION['idusuario']))
    $param['p_usuario'] = $_SESSION['idusuario'];


$Porcentaje = new Porcentaje_model();
echo $Porcentaje->gestionar($param);
?>