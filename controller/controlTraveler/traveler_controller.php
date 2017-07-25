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


$Traveler = new Traveler_model();
echo $Traveler->gestionar($param);
?>


