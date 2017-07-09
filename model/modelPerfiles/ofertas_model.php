<?php
//session_start();
include_once '../../model/conexion_model.php';

class Perfiles_model{

    private $param = array();
    private $conexion = null;

    function __construct()
    {
        $this->conexion = Conexion_model::getConexion();
    }

    function cerrarAbrir()
    {
        mysqli_close($this->conexion);
        $this->conexion = Conexion_model::getConexion();
    }

    function gestionar($param)
    {
        $this->param = $param;
        switch($this->param['p_opcion'])
        {
            case "obtener_perfil_socio";
                echo $this->obtener_perfil_socio();
                break;

        }
    }

    function prepararConsultaObtenerPerfil($opcion = '', $usuario = '') {
        $consultaSql = "call sp_gestion_perfiles(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$usuario."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function obtener_perfil_socio() {
        $this->prepararConsultaObtenerPerfil('opc_obtener_perfil_socio',  $this->param['p_usuario']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

}
?>
