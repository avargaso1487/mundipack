<?php


include_once "../../model/modelTraveler/traveler_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_operacion'] = '';
$param['p_monto'] = '';
$param['p_fecha'] = '';
$param['p_pagoID'] = '';

$param['p_socioID'] = '';
$param['p_travelerID'] = '';

$param['p_nombre'] = '';
$param['p_apellidos'] = '';
$param['p_dni'] = '';
$param['p_fijo'] = '';
$param['p_celular'] = '';
$param['p_email'] = '';


if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];

if(isset($_POST['p_operacion']))
    $param['p_operacion'] = $_POST['p_operacion'];

if(isset($_POST['p_monto']))
    $param['p_monto'] = $_POST['p_monto'];

if(isset($_POST['p_fecha']))
    $param['p_fecha'] = $_POST['p_fecha'];

if(isset($_POST['p_pagoID']))
    $param['p_pagoID'] = $_POST['p_pagoID'];

if(isset($_POST['p_socioID']))
    $param['p_socioID'] = $_POST['p_socioID'];

if(isset($_POST['p_travelerID']))
    $param['p_travelerID'] = $_POST['p_travelerID'];



if(isset($_POST['p_nombre']))
    $param['p_nombre'] = $_POST['p_nombre'];

if(isset($_POST['p_apellidos']))
    $param['p_apellidos'] = $_POST['p_apellidos'];

if(isset($_POST['p_dni']))
    $param['p_dni'] = $_POST['p_dni'];

if(isset($_POST['p_fijo']))
    $param['p_fijo'] = $_POST['p_fijo'];

if(isset($_POST['p_celular']))
    $param['p_celular'] = $_POST['p_celular'];

if(isset($_POST['p_email']))
    $param['p_email'] = $_POST['p_email'];




$Traveler = new Traveler_model();
echo $Traveler->gestionar($param);
?>


