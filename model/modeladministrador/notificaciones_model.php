<?php

include_once '../../model/conexion_model.php';

class Notificaciones_model{

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
            case "noti_pre_pago_socio";
                echo $this->noti_pre_pago_socio();
                break;
            case "noti_pre_pago_traveler";
                echo $this->noti_pre_pago_traveler();
                break;

            case "item_noti_pago_socio";
                echo $this->item_noti_pago_socio();
                break;

            case "item_noti_pago_traveler";
                echo $this->item_noti_pago_traveler();
                break;
        }
    }

    function prepararConsultaNotificaciones($opcion = '')
    {
        $consultaSql = "call sp_gestionar_notificaciones(";
        $consultaSql.= "'".$opcion."')";
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

    function noti_pre_pago_socio() {
        $this->prepararConsultaNotificaciones('opc_noti_pre_pago_socio');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function noti_pre_pago_traveler() {
        $this->prepararConsultaNotificaciones('opc_noti_pre_pago_traveler');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function getArrayPagos(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "NOMBRE" => $fila["NOMBRE"],
                "IMPORTE" => $fila["IMPORTE"]
            ));
        }
        return $datos;
    }

    function item_noti_pago_socio() {
        $this->prepararConsultaNotificaciones('opc_item_noti_pago_socio');
        $datos = $this->getArrayPagos();
        echo '<li class="dropdown-header">Nuevos Pagos de Net Partners</li>';
        for($i=0; $i<count($datos); $i++) {
            echo '<li>
                     <a href="#">                        
                        <div class="message">
                            <div class="content">
                                <div class="title">'.$datos[$i]["NOMBRE"].'</div>
                                <div class="description">S/. '.$datos[$i]["IMPORTE"].'</div>
                            </div>
                        </div>
                    </a>
                </li>';
        }
        echo '<li class="dropdown-footer">
                    <a href="../administrador/pagos_partner.php">Ver Todos <i class="fa fa-angle-right"
                                        aria-hidden="true"></i></a>
                </li>';
    }

    function item_noti_pago_traveler() {
        $this->prepararConsultaNotificaciones('opc_item_noti_pago_traveler');
        $datos = $this->getArrayPagos();
        echo '<li class="dropdown-header">Nuevos Pagos de Travelers</li>';
        for($i=0; $i<count($datos); $i++) {
            echo '<li>
                     <a href="#">                        
                        <div class="message">
                            <div class="content">
                                <div class="title">'.$datos[$i]["NOMBRE"].'</div>
                                <div class="description">S/. '.$datos[$i]["IMPORTE"].'</div>
                            </div>
                        </div>
                    </a>
                </li>';
        }
        echo '<li class="dropdown-footer">
                    <a href="../administrador/pagos_traveler.php">Ver Todos <i class="fa fa-angle-right"
                                        aria-hidden="true"></i></a>
                </li>';
    }
}
?>
