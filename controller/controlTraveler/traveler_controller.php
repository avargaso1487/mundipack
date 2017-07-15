
<?php
session_start();

include_once "../../model/modelTraveler/traveler_model.php";

$param = array();
$param['p_opcion'] = '';


if(isset($_POST['p_opcion']))
    $param['p_opcion'] = $_POST['p_opcion'];


$Traveler = new Traveler_model();
echo $Traveler->gestionar($param);
?>

