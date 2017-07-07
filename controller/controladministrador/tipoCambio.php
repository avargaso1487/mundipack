<?php
session_start();

include_once "../../model/modeladministrador/tipoCambio_model.php";

$param = array();
$param['p_opcion'] = '';
$param['p_montoCompra'] = '';
$param['p_montoVenta'] = '';


if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];


if(isset($_POST['p_montoCompra']))
    $param['p_montoCompra'] = $_POST['p_montoCompra'];

if(isset($_POST['p_montoVenta']))
    $param['p_montoVenta'] = $_POST['p_montoVenta'];


$TipoCambio = new TipoCambio_model();
echo $TipoCambio->gestionar($param);
?>