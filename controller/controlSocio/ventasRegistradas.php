<?php


include_once "../../model/modelSocio/ventasRegistradas_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_dni'] = '';
$param['p_socioID'] = '';
$param['p_tipoDoc'] = '';
$param['p_serie'] = '';
$param['p_numero'] = '';
$param['p_importe'] = '';
$param['p_fecha'] = '';
$param['p_usuario'] = '';

$param['p_codigo'] = '';
$param['p_socio'] = '';

if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];

if(isset($_POST['p_dni']))
    $param['p_dni'] = $_POST['p_dni'];

if(isset($_POST['p_socioID']))
    $param['p_socioID'] = $_POST['p_socioID'];

if(isset($_POST['p_socio']))
    $param['p_socio'] = $_POST['p_socio'];

if(isset($_POST['p_tipoDoc']))
    $param['p_tipoDoc'] = $_POST['p_tipoDoc'];

if(isset($_POST['p_serie']))
    $param['p_serie'] = $_POST['p_serie'];

if(isset($_POST['p_numero']))
    $param['p_numero'] = $_POST['p_numero'];

if(isset($_POST['p_importe']))
    $param['p_importe'] = $_POST['p_importe'];

if(isset($_POST['p_fecha']))
    $param['p_fecha'] = $_POST['p_fecha'];

if(isset($_POST['p_codigo']))
    $param['p_codigo'] = $_POST['p_codigo'];



$VentaRegistrada = new VentaRegistrada_model();
echo $VentaRegistrada->gestionar($param);
?>