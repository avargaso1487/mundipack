<?php

include_once '../../model/modelusuario/tree_model.php';

$param = array();
$param['param_opcion']='';
$param['param_usuUsuario']='';
$param['param_usuClave']='';
$param['param_usuId']='';

if (isset($_POST['param_opcion']))
    $param['param_opcion'] = $_POST['param_opcion'];

if(isset($_SESSION['usuario']))
    $param['param_usuUsuario'] = $_SESSION['usuario'];

if(isset($_SESSION['idusuario']))
    $param['param_usuId'] = $_SESSION['idusuario'];    

$Tree = new Tree_Model();
echo $Tree->gestionar($param);
?>
