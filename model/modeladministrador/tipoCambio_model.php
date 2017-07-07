<?php
//session_start();
include_once '../../model/conexion_model.php';

class TipoCambio_model{

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
            case "add_type";
                echo $this->add_tipo_cambio();
                break;
            case "view_type";
                echo $this->view_tipo_cambio();
                break;
        }
    }

    function prepararConsultaTipoCambio($opcion = '', $montoCompra = '', $montoVenta = '')
    {
        $consultaSql = "call sp_control_tipo_cambio(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$montoCompra."',";
        $consultaSql.= "'".$montoVenta."')";
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

    function add_tipo_cambio() {
        $this->prepararConsultaTipoCambio('opc_grabar_tipo_cambio', $this->param['p_montoCompra'], $this->param['p_montoVenta']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function view_tipo_cambio() {
        $this->prepararConsultaTipoCambio('opc_ver_tipo_cambio', '0', '0');
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }
}
?>
