<?php
session_start();
include_once '../../model/conexion_model.php';

class Paquetes_model{

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
            case "listado_paquetes";
                echo $this->listado_paquetes();
                break;

            case "add_paquete_admin";
                echo $this->add_paquete_admin();
                break;

            case "obtener_paquete";
                echo $this->obtener_paquete();
                break;

            case "update_paquete_admin";
                echo $this->update_paquete_admin();
                break;

            case "eliminar_paquete_admin";
                echo $this->eliminar_paquete_admin();
                break;

            case "activar_paquete_admin";
                echo $this->activar_paquete_admin();
                break;

            case "listado_paquetes_traveler";
                echo $this->listado_paquetes_traveler();
                break;

            case "listado_paquetes_adquiridos";
                echo $this->listado_paquetes_adquiridos();
                break;

            case "cbo_paqueteprincipal";
                echo $this->cbo_listado_paquete_principal();
                break;

            case "cbo_paquetesecundario1";
                echo $this->cbo_listado_paquete_secundario1();
                break;

            case "cbo_paquetesecundario2";
                echo $this->cbo_listado_paquete_secundario2();
                break;

            case "getPrecios";
                echo $this->getPrecios();
                break;
        }
    }

    function prepararConsultaBuscarSocio($opcion = '', $dni = '') {
        $consultaSql = "call sp_buscar_socio(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$dni."')";
        //echo $consultaSql;

        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function prepararConsultaPaquete($opcion = '', $nombre = '', $descripcion = '', $preciomin = '', $preciomax = '', $precioprom = '', $paqueteID = '') {
        $consultaSql = "call sp_gestionar_paquetes(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$nombre."',";
        $consultaSql.= "'".$descripcion."',";
        $consultaSql.= "'".$preciomin."',";
        $consultaSql.= "'".$preciomax."',";
        $consultaSql.= "'".$precioprom."',";
        $consultaSql.= "'".$paqueteID."')";
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

    function getArrayPaquetes(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "Paquete" => $fila["Paquete"],
                "Nombre" => $fila["Nombre"],
                "Descripcion" => $fila["Descripcion"],
                "PrecioMinimo" => $fila["PrecioMinimo"],
                "PrecioMaximo" => $fila["PrecioMaximo"],
                "PrecioPromedio" => $fila["PrecioPromedio"],
                "Estado" => $fila["Estado"]
            ));
        }
        return $datos;
    }

    function getArrayPaquetesAdquiridos(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "Paquete" => $fila["Paquete"],
                "Nombre" => $fila["Nombre"],
                "Descripcion" => $fila["Descripcion"],
                "Precio" => $fila["Precio"]
            ));
        }
        return $datos;
    }

    function getArrayTotal(){
        $respuesta = '';
        while($fila = mysqli_fetch_array($this->result)){
            $respuesta = $fila["total"];
        }
        return $respuesta;
    }

    function cbo_listado_paquete_principal() {
        $this->prepararConsultaBuscarSocio('opc_listar_paquetes', $_SESSION['idusuario']);
        $datos = $this->getArrayPaquetes();        
        echo '<select class="chosen-select form-control" onchange="getPrincipalPrices()" id="viajeroPaquetePrincipal" name="viajeroPaquetePrincipal">
                    <option value="" disabled selected style="display: none;">Seleccione Paquete</option>';
        for($i=0; $i<count($datos); $i++){            
            echo'<option value="'.$datos[$i]["Paquete"].'">'.$datos[$i]["Nombre"].'</option>';
        }
        echo '</select>';
    }

    function cbo_listado_paquete_secundario1() {
        $this->prepararConsultaBuscarSocio('opc_listar_paquetes', $_SESSION['idusuario']);
        $datos = $this->getArrayPaquetes();
        echo '<select class="chosen-select form-control" onchange="getSecondPrices()" id="viajeroPaqueteSecundarioOne" name="viajeroPaqueteSecundarioOne">
                    <option value="" disabled selected style="display: none;">Seleccione Paquete</option>';
        for($i=0; $i<count($datos); $i++){
            echo'<option value="'.$datos[$i]["Paquete"].'">'.$datos[$i]["Nombre"].'</option>';
        }
        echo '</select>';
    }

    function cbo_listado_paquete_secundario2() {
        $this->prepararConsultaBuscarSocio('opc_listar_paquetes', $_SESSION['idusuario']);
        $datos = $this->getArrayPaquetes();
        echo '<select class="chosen-select form-control" onchange="getThirdPrices()" id="viajeroPaqueteSecundarioTwo" name="viajeroPaqueteSecundarioTwo">
                    <option value="" disabled selected style="display: none;">Seleccione Paquete</option>';
        for($i=0; $i<count($datos); $i++){
            echo'<option value="'.$datos[$i]["Paquete"].'">'.$datos[$i]["Nombre"].'</option>';
        }
        echo '</select>';
    }

    function listado_paquetes() {
        $this->prepararConsultaBuscarSocio('opc_contar_paquetes', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_listar_paquetes', $_SESSION['idusuario']);
            $datos = $this->getArrayPaquetes();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["Nombre"].'</td>						
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">S/.'.$datos[$i]["PrecioMinimo"].'</td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">S/.'.$datos[$i]["PrecioMaximo"].'</td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">S/.'.$datos[$i]["PrecioPromedio"].'</td>';


                if ($datos[$i]["Estado"] == '0') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Inactivo</span></span></td>                        
                           <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">
                                <a href="#" class="red" onclick="editarPaquete('.$datos[$i]["Paquete"].')">
                                    <i class= "ace-icon fa fa-pencil bigger-400"></i>
                                </a> 
                                <a href="#" class="red" onclick="activar('.$datos[$i]["Paquete"].')">
                                    <i class= "ace-icon fa fa-check bigger-400"></i>
                                </a> 
                           </td>
                          </tr>';
                }
                if ($datos[$i]["Estado"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-success badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Activo</span></span></td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">
                            <a href="#" class="red" onclick="editarPaquete('.$datos[$i]["Paquete"].')">
                                <i class= "ace-icon fa fa-pencil bigger-400"></i>
                            </a> 
                            <a href="#" class="red" onclick="eliminar('.$datos[$i]["Paquete"].')">
                                <i class= "ace-icon fa fa-times-circle bigger-400"></i>
                            </a> 
                        </td>
                        </tr>';
                }
            }
        } else {
            echo '0';
        }
    }

    function listado_paquetes_traveler() {
        $this->prepararConsultaBuscarSocio('opc_contar_paquetes_traveler', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_listar_paquetes_traveler', $_SESSION['idusuario']);
            $datos = $this->getArrayPaquetes();
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div class="col-xs-6 col-sm-3 pricing-box">
                            <div class="widget-box widget-color-blue">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">'.$datos[$i]["Nombre"].'</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <ul class="list-unstyled spaced2">
                                            <label for="">'.$datos[$i]["Descripcion"].'</label>
                                        </ul>
                                        <hr />
                                        <div class="price">
                                            Precio Aprox. $'.$datos[$i]["PrecioPromedio"].'
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>';

            }
        } else {
            echo '0';
        }
    }

    function listado_paquetes_adquiridos() {
        $this->prepararConsultaBuscarSocio('opc_contar_paquetes_adquiridos', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_listar_paquetes_adquiridos', $_SESSION['idusuario']);
            $datos = $this->getArrayPaquetesAdquiridos();
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div class="col-xs-6 col-sm-3 pricing-box">
                            <div class="widget-box widget-color-blue">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">'.$datos[$i]["Nombre"].'</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <ul class="list-unstyled spaced2">
                                            <label for="">'.$datos[$i]["Descripcion"].'</label>
                                        </ul>
                                        <hr />
                                        <div class="price">
                                            S/. '.$datos[$i]["Precio"].'
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>';

            }
        } else {
            echo '0';
        }
    }





    function add_paquete_admin() {
        $this->prepararConsultaPaquete('opc_registrar_paquete',  $this->param['p_nombre'], $this->param['p_descripcion'], $this->param['p_preciominimo'], $this->param['p_preciomaximo'], $this->param['p_preciopromedio'], '0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function update_paquete_admin() {
        $this->prepararConsultaPaquete('opc_update_paquete',  $this->param['p_nombre'], $this->param['p_descripcion'], $this->param['p_preciominimo'], $this->param['p_preciomaximo'], $this->param['p_preciopromedio'], $this->param['paqueteID']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }


    function eliminar_paquete_admin() {
        $this->prepararConsultaPaquete('opc_eliminar_paquete',  '', '', '0.00', '0.00', '0.00', $this->param['paqueteID']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function activar_paquete_admin() {
        $this->prepararConsultaPaquete('opc_activar_paquete',  '', '', '0.00', '0.00', '0.00', $this->param['paqueteID']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }


    function obtener_paquete() {
        $this->prepararConsultaBuscarSocio('opc_obtener_paquete',  $this->param['paqueteID']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function getPrecios() {
        $this->prepararConsultaPaquete('opc_getPrecios',  '', '', '0.00', '0.00', '0.00', $this->param['paqueteID']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

}
?>
