<?php

session_start();

include_once "../../model/modeladministrador/paquetes_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_nombre'] = '';
$param['p_descripcion'] = '';
$param['p_preciominimo'] = '';
$param['p_preciomaximo'] = '';
$param['p_preciopromedio'] = '';
$param['paqueteID'] = '';



if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];

if(isset($_POST['p_nombre']))
    $param['p_nombre'] = $_POST['p_nombre'];

if(isset($_POST['p_descripcion']))
    $param['p_descripcion'] = $_POST['p_descripcion'];

if(isset($_POST['p_preciominimo']))
    $param['p_preciominimo'] = $_POST['p_preciominimo'];

if(isset($_POST['p_preciomaximo']))
    $param['p_preciomaximo'] = $_POST['p_preciomaximo'];

if(isset($_POST['p_preciopromedio']))
    $param['p_preciopromedio'] = $_POST['p_preciopromedio'];

if(isset($_POST['paqueteID']))
    $param['paqueteID'] = $_POST['paqueteID'];

$Paquetes = new Paquetes_model();
echo $Paquetes->gestionar($param);
?>