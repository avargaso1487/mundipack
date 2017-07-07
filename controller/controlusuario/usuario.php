<?php 
    session_start();
    include_once '../../model/modelusuario/usuario_model.php';

    $param = array();
    $param['opcion'] = '';
    $param['menu'] = '';
    $param['usuario'] = '';
    $param['password'] = '';

    if(isset($_POST['opcion']))
    {
        $param['opcion'] = $_POST['opcion'];
    }
    if(isset($_POST['menu']))
    {
        $param['menu'] = $_POST['menu'];
    }

    if(isset($_POST['usuario']))
    {
        $param['usuario'] = $_POST['usuario'];  
    }

    if(isset($_POST['password']))
    {
        $param['password'] = md5($_POST['password']);
    }

    $Usuario = new Usuario_model();
    echo $Usuario->gestionar($param);
 ?>