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
            case "obtener_perfil_travelers";
                echo $this->obtener_perfil_travelers();
                break;

            case "update_perfil_socio";
                echo $this->update_perfil_socio();
                break;

            case "update_perfil_travelers";
                echo $this->update_perfil_travelers();
                break;

        }
    }

    function prepararConsultaObtenerPerfil($opcion = '', $usuario = '', $fijo = '', $movil = '', $password = '', $fotoperfil = '') {
        $consultaSql = "call sp_gestion_perfil_travelers(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$usuario."',";
        $consultaSql.= "'".$fijo."',";
        $consultaSql.= "'".$movil."',";
        $consultaSql.= "'".$password."',";
        $consultaSql.= "'".$fotoperfil."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function obtener_perfil_travelers() {
        $this->prepararConsultaObtenerPerfil('opc_obtener_perfil_travelers', $_SESSION['idusuario'],'','','','');
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function update_perfil_travelers() {
        if ($this->param['p_archivoPerfil'] == '') {
            $this->prepararConsultaObtenerPerfil('opc_update_perfil_socio', $_SESSION['idusuario'], $this->param['p_fijo'], $this->param['p_movil'], $this->param['p_password'], '');
            $this->cerrarAbrir();
            echo 1;
        } else {
            $this->prepararConsultaObtenerPerfil('opc_update_perfil_socio', $_SESSION['idusuario'], $this->param['p_fijo'], $this->param['p_movil'], $this->param['p_password'], $this->param['p_rutaPerfil']);
            $this->cerrarAbrir();
            $destino = '../../view/default/assets/images/users/' . $this->param['p_archivoPerfil'];
            $archivo = $this->param['p_fileArchivoPerfil'];
            move_uploaded_file($archivo, $destino);
            echo 1;
        }
    }

}
?>
