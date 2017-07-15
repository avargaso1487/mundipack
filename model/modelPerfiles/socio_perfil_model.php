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

            case "update_perfil_socio";
                echo $this->update_perfil_socio();
                break;

        }
    }

    function prepararConsultaObtenerPerfil($opcion = '', $usuario = '',$contaco = '', $atencion = '',$password = '', $fotoPerfil = '', $fotoCarta = '') {
        $consultaSql = "call sp_gestion_perfil_socio(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$usuario."',";
        $consultaSql.= "'".$contaco."',";
        $consultaSql.= "'".$atencion."',";
        $consultaSql.= "'".$password."',";
        $consultaSql.= "'".$fotoPerfil."',";
        $consultaSql.= "'".$fotoCarta."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function obtener_perfil_socio() {
        $this->prepararConsultaObtenerPerfil('opc_obtener_perfil_socio',  $_SESSION['idusuario'], '','','','', '');
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function update_perfil_socio() {
        if ($this->param['p_archivoPerfil'] == '' || $this->param['p_archivoCarta'] == '') {
            if ($this->param['p_archivoPerfil'] == '' && $this->param['p_archivoCarta'] != '') {
                $this->prepararConsultaObtenerPerfil('opc_update_perfil_socio', $_SESSION['idusuario'], $this->param['p_contacto'], $this->param['p_atencion'], $this->param['p_paswword'], '', $this->param['p_rutaCarta']);
                $this->cerrarAbrir();
                $destino = '../../view/partners/carta/' . $this->param['p_archivoCarta'];
                $archivo = $this->param['p_fileArchivoCarta'];
                move_uploaded_file($archivo, $destino);
                echo 1;
            } else {
                if ($this->param['p_archivoCarta'] == '' && $this->param['p_archivoPerfil'] != '') {
                    $this->prepararConsultaObtenerPerfil('opc_update_perfil_socio', $_SESSION['idusuario'], $this->param['p_contacto'], $this->param['p_atencion'], $this->param['p_paswword'], $this->param['p_rutaPerfil'], '');
                    $this->cerrarAbrir();
                    $destino = '../../view/default/assets/images/users/' . $this->param['p_archivoPerfil'];
                    $archivo = $this->param['p_fileArchivoPerfil'];
                    move_uploaded_file($archivo, $destino);
                    echo 1;
                } else {
                    if ($this->param['p_archivoPerfil'] == '' && $this->param['p_archivoCarta'] == '') {
                        $this->prepararConsultaObtenerPerfil('opc_update_perfil_socio',  $_SESSION['idusuario'], $this->param['p_contacto'],$this->param['p_atencion'],$this->param['p_paswword'],'', '');
                        echo 1;
                    }
                }
            }
        } else {
            $this->prepararConsultaObtenerPerfil('opc_update_perfil_socio', $_SESSION['idusuario'], $this->param['p_contacto'], $this->param['p_atencion'], $this->param['p_paswword'], $this->param['p_rutaPerfil'], $this->param['p_rutaCarta']);
            $this->cerrarAbrir();

            $destino = '../../view/default/assets/images/users/' . $this->param['p_archivoPerfil'];
            $archivo = $this->param['p_fileArchivoPerfil'];
            move_uploaded_file($archivo, $destino);

            $destino = '../../view/partners/carta/' . $this->param['p_archivoCarta'];
            $archivo = $this->param['p_fileArchivoCarta'];
            move_uploaded_file($archivo, $destino);
            echo 1;
        }
    }

}
?>
