<?php

session_start();

include_once "../../model/modeladministrador/paquetes_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_nombre'] = '';
$param['p_descripcion'] = '';
$param['p_precio'] = '';
$param['paqueteID'] = '';



if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];

if(isset($_POST['p_nombre']))
    $param['p_nombre'] = $_POST['p_nombre'];

if(isset($_POST['p_descripcion']))
    $param['p_descripcion'] = $_POST['p_descripcion'];

if(isset($_POST['p_precio']))
    $param['p_precio'] = $_POST['p_precio'];

if(isset($_POST['paqueteID']))
    $param['paqueteID'] = $_POST['paqueteID'];

$Paquetes = new Paquetes_model();
echo $Paquetes->gestionar($param);
?>