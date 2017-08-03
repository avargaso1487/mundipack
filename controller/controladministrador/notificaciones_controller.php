<?php

include_once "../../model/modeladministrador/notificaciones_model.php";

$param = array();
$param['p_opcion'] = '';



if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];



$Notificaciones = new Notificaciones_model();
echo $Notificaciones->gestionar($param);
?>