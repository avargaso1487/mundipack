<?php
//session_start();
include_once '../../model/conexion_model.php';

class Porcentaje_model{

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
            case "verificar_porcentaje";
                echo $this->verificar_porcentaje();
                break;
            case "add_porcentaje";
                echo $this->add_porcentaje();
                break;
            case "valor_porcentaje";
                echo $this->valor_porcentaje();
                break;
        }
    }

    function prepararConsultaPorcentaje($opcion = '', $porcentaje = '', $usuario ='')
    {
        $consultaSql = "call sp_control_porcentaje(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$porcentaje."',";
        $consultaSql.= "'".$usuario."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    private function getArrayResultado() {
        $resultado = 0;
        while ($fila = mysqli_fetch_array($this->result)) {
            $resultado = $fila["respuesta"];
        }
        return $resultado;
    }

    function verificar_porcentaje() {
        $this->prepararConsultaPorcentaje('opc_verificar_porcentaje', '0','0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function valor_porcentaje() {
        $this->prepararConsultaPorcentaje('opc_valor_porcentaje', '0','0');
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function add_porcentaje() {
        $this->prepararConsultaPorcentaje('opc_add_porcentaje', $this->param['p_porcentaje'], $this->param['p_usuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }
}
?>
