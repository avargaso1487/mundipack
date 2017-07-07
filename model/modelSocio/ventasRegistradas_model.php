<?php
//session_start();
include_once '../../model/conexion_model.php';

class VentaRegistrada_model{

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
            case "cbo_documento";
                echo $this->cargarTipoDocumento();
                break;
            case "buscar_socio";
                echo $this->buscar_socio();
                break;
            case "add_transaccion";
                echo $this->add_transaccion();
                break;
            case "listado_ventas_registradas";
                echo $this->listado_ventas_registradas();
                break;
            case "listado_ventas_pre_registradas";
                echo $this->listado_ventas_pre_registradas();
                break;
            case "aceptar_transacion";
                echo $this->aceptar_transacion();
                break;
            case "listado_ultimas_ventas_registradas";
                echo $this->listado_ultimas_ventas_registradas();
                break;
            case "noti_pre_regitro";
                echo $this->noti_pre_regitro();
                break;

            case "total_ventas_socio";
                echo $this->total_ventas_socio();
                break;

            case "monto_total_ventas_socio";
                echo $this->monto_total_ventas_socio();
                break;

            case "total_numero_socio";
                echo $this->total_numero_socio();
                break;

            case "noti_pre_regitro_item";
                echo $this->noti_pre_regitro_item();
                break;

            case "obtener_venta_registrada";
                echo $this->obtener_venta_registrada();
                break;


        }
    }


    /* CARGAR COMBO TIPO DE DOCUMENTO */
    function prepararConsultaCombo($opcion = '') {
        $consultaSql = "call sp_control_combos(";
        $consultaSql.= "'".$opcion."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function cargarTipoDocumento() {
        $this->prepararConsultaCombo('opc_listar_tipo_documento');
        $this->cerrarAbrir();
        echo '<select class="form-control" id="tipoDocumento" name="tipoDocumento">
                    <option value="" disabled selected style="display: none;">Seleccione Tipo Documento</option>';
        while ($fila = mysqli_fetch_row($this->result)) {
            echo'<option value="'.$fila[0].'">'.utf8_encode($fila[1]).'</option>';
        }
        echo '</select>';
    }

    /* VERIFICAR Y OBTENER AL SOCIO INGRESADO */
    function prepararConsultaBuscarSocio($opcion = '', $dni = '') {
        $consultaSql = "call sp_buscar_socio(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$dni."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function buscar_socio() {
        $this->prepararConsultaBuscarSocio('opc_buscar_socio',  $this->param['p_dni']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function obtener_venta_registrada() {
        $this->prepararConsultaBuscarSocio('opc_obtener_venta',  $this->param['p_codigo']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }



    /* REGISTRO DE TRANSACCION */
    function prepararConsultaTransaccion($opcion = '', $socioID = '', $tipoDoc = '', $serie = '', $numero = '', $importe = '', $fecha = '', $usuario = '') {
        $consultaSql = "call sp_gestion_transaccion(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$socioID."',";
        $consultaSql.= "'".$tipoDoc."',";
        $consultaSql.= "'".$serie."',";
        $consultaSql.= "'".$numero."',";
        $consultaSql.= "'".$importe."',";
        $consultaSql.= "'".$fecha."',";
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

    function add_transaccion() {
        $this->prepararConsultaTransaccion('opc_registrar_transaccion',  $this->param['p_socioID'], $this->param['p_tipoDoc'], $this->param['p_serie'], $this->param['p_numero'], $this->param['p_importe'], $this->param['p_fecha'], $this->param['p_usuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }


    /* LISTADO DE VENTAS REGISTRADAS */
    function prepararConsultaListadoVentas($opcion = '', $usuario = '', $codigo = '') {
        $consultaSql = "call sp_listado_ventas(";
        $consultaSql.= "'".$usuario."',";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$codigo."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function getArrayVentas(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "CODIGO" => $fila["CODIGO"],
                "CLIENTE" => $fila["CLIENTE"],
                "TIPO_DOCUMENTO" => $fila["TIPO_DOCUMENTO"],
                "DOCUMENTO" => $fila["DOCUMENTO"],
                "IMPORTE" => $fila["IMPORTE"],
                "FECHA" => $fila["FECHA"],
                "ESTADO" => $fila["ESTADO"]
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


    function listado_ventas_registradas() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_rgistradas', $this->param['p_usuario'], '0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_listar_ventas_rgistradas', $this->param['p_usuario'], '0');
            $datos = $this->getArrayVentas();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 10%;">'.$datos[$i]["CLIENTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["TIPO_DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["IMPORTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["FECHA"].'</td>';

						if ($datos[$i]["ESTADO"] == '1') {
                            echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Completo</span></span></td>';
                        }
                echo '
                            <td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">								
	                            <a href="#" class="red" onclick="editar('.$datos[$i]["CODIGO"].')" data-toggle="modal" data-target="#modalVenta">
	                                <i class= "ace-icon fa fa-pencil bigger-200"></i>
	                            </a>	                           
							</td>';
						echo '</tr>';
            }
        }
    }

    function listado_ultimas_ventas_registradas() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_rgistradas', $this->param['p_usuario'], '0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_listar_ultimas_ventas_rgistradas', $this->param['p_usuario'], '0');
            $datos = $this->getArrayVentas();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 10%;">'.$datos[$i]["CLIENTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["TIPO_DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["IMPORTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["FECHA"].'</td>';

                if ($datos[$i]["ESTADO"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Completo</span></span></td>';
                }
                echo '</tr>';
            }
        }
    }

    function aceptar_transacion() {
        $this->prepararConsultaListadoVentas('opc_aceptar_transaccion', $this->param['p_usuario'],$this->param['p_codigo']);
        $this->cerrarAbrir();
        $this->listado_ventas_pre_registradas();
    }

    function listado_ventas_pre_registradas() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_pre_rgistradas', $this->param['p_usuario'],'0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_listar_ventas_pre_rgistradas', $this->param['p_usuario'],'0');
            $datos = $this->getArrayVentas();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 15%;">'.$datos[$i]["CLIENTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["TIPO_DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["IMPORTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["FECHA"].'</td>';

                if ($datos[$i]["ESTADO"] == '0') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Pendiente</span></span></td>';
                }
                echo '<td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">                            
                            <a href="#" class="red" onclick="aceptarTransaccion('.$datos[$i]["CODIGO"].')">
                                <i class= "ace-icon fa fa-check bigger-400"></i>
                            </a>
                        </td>
				</tr>';
            }
        }
    }

    /* DASHBOARD SOCIO */
    function total_ventas_socio() {
        $this->prepararConsultaListadoVentas('opc_total_ventas_socio',  $this->param['p_usuario'],'0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function monto_total_ventas_socio() {
        $this->prepararConsultaListadoVentas('opc_monto_total_ventas_socio',  $this->param['p_usuario'],'0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function total_numero_socio() {
        $this->prepararConsultaListadoVentas('opc_total_numro_socios',  $this->param['p_usuario'],'0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function noti_pre_regitro() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_pre_rgistradas', $this->param['p_usuario'],'0');
        $total = $this->getArrayTotal();
        echo $total;
    }



    function noti_pre_regitro_item() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_pre_rgistradas', $this->param['p_usuario'],'0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_contar_tres_ventas_pre_rgistradas', $this->param['p_usuario'],'0');
            $datos = $this->getArrayVentas();
            echo '<li class="dropdown-header">Ventas Pre Registradas</li>';
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<li>
                        <a href="#">
                            <span class="badge badge-danger pull-right">8</span>
                            <div class="message">
                                <div class="content">
                                    <div class="title">'.$datos[$i]["CLIENTE"].'</div>
                                    <div class="description">S/. '.$datos[$i]["IMPORTE"].'</div>
                                </div>
                            </div>
                        </a>
                    </li>';
            }
            echo '<li class="dropdown-footer">
                                            <a href="../partners/ventasPreRegistradas.php">Ver Todos <i class="fa fa-angle-right"
                                                                    aria-hidden="true"></i></a>
                                        </li>';
        }
    }

}
?>
