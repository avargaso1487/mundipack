
<?php
session_start();

include_once "../../model/modelPerfiles/ofertas_model.php";

$param = array();
$param['p_opcion'] = '';


if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];



if (isset($_SESSION['idusuario']))
    $param['p_usuario'] = $_SESSION['idusuario'];


$Perfiles = new Perfiles_model();
echo $Perfiles->gestionar($param);
?>

