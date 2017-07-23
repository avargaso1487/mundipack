<?php
session_start();
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
            case "cbo_socio";
                echo $this->cargarSocios();
                break;

            case "cbo_traveler";
                echo $this->cbo_traveler();
                break;


            case "buscar_socio";
                echo $this->buscar_socio();
                break;

            case "listado_pagos_traveler";
                echo $this->listado_pagos_traveler();
                break;

            case "listado_pagos_partner";
                echo $this->listado_pagos_partner();
                break;

            case "listado_pagos_pendientes_partner";
                echo $this->listado_pagos_pendientes_partner();
                break;

            case "listado_pagos_pendientes_traveler";
                echo $this->listado_pagos_pendientes_traveler();
                break;


            case "add_transaccion";
                echo $this->add_transaccion();
                break;
            case "update_transaccion";
                echo $this->update_transaccion();
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
            case "rechazar_transacion";
                echo $this->rechazar_transacion();
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

            case "venta_neta_socio";
                echo $this->venta_neta_socio();
                break;

            case "listado_consumo_traveler";
                echo $this->listado_consumo_traveler();
                break;

            case "add_pre_registro";
                echo $this->add_pre_registro();
                break;

            case "update_pre_transaccion";
                echo $this->update_pre_transaccion();
                break;

            case "listado_travelers_abiertos";
                echo $this->listado_travelers_abiertos();
                break;

            case "obtener_comisiones";
                echo $this->obtener_comisiones();
                break;

            case "dashboard_total_socios";
                echo $this->dashboard_total_socios();
                break;

            case "dashboard_total_viajeros";
                echo $this->dashboard_total_viajeros();
                break;

            case "listado_ultimos_movimientos_traveler";
                echo $this->listado_ultimos_movimientos_traveler();
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

    function cargarSocios() {
        $this->prepararConsultaCombo('opc_listar_socios');
        $this->cerrarAbrir();
        echo '<select class="form-control" id="cboSocio" name="cboSocio">
                    <option value="" disabled selected style="display: none;">Seleccione Net Partner</option>';
        while ($fila = mysqli_fetch_row($this->result)) {
            echo'<option value="'.$fila[0].'">'.utf8_encode($fila[2]).'</option>';
        }
        echo '</select>';
    }

    function cbo_traveler() {
        $this->prepararConsultaCombo('opc_listar_traveler');
        $this->cerrarAbrir();
        echo '<select class="form-control" id="cbotraveler" name="cbotraveler">
                    <option value="" disabled selected style="display: none;">Seleccione Traveler</option>';
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
    function prepararConsultaTransaccion($opcion = '', $socioID = '', $tipoDoc = '', $serie = '', $numero = '', $importe = '', $fecha = '', $usuario = '', $codigo = '') {
        $consultaSql = "call sp_gestion_transaccion(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$socioID."',";
        $consultaSql.= "'".$tipoDoc."',";
        $consultaSql.= "'".$serie."',";
        $consultaSql.= "'".$numero."',";
        $consultaSql.= "'".$importe."',";
        $consultaSql.= "'".$fecha."',";
        $consultaSql.= "'".$usuario."',";
        $consultaSql.= "'".$codigo."')";
        echo $consultaSql;
        //$this->result = mysqli_query($this->conexion, $consultaSql);
    }

    private function getArrayResultado() {
        $resultado = 0;
        while ($fila = mysqli_fetch_array($this->result)) {
            $resultado = $fila["respuesta"];
        }
        return $resultado;
    }

    function add_transaccion() {
        $this->prepararConsultaTransaccion('opc_registrar_transaccion',  $this->param['p_socioID'], $this->param['p_tipoDoc'], $this->param['p_serie'], $this->param['p_numero'], $this->param['p_importe'], $this->param['p_fecha'], $_SESSION['idusuario'], '0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function add_pre_registro() {
        $this->prepararConsultaTransaccion('opc_pre_registrar_transaccion',  $this->param['p_socio'], $this->param['p_tipoDoc'], $this->param['p_serie'], $this->param['p_numero'], $this->param['p_importe'], $this->param['p_fecha'], $_SESSION['idusuario'], '0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }


    function update_transaccion() {
        $this->prepararConsultaTransaccion('opc_update_transaccion',  $this->param['p_socioID'], $this->param['p_tipoDoc'], $this->param['p_serie'], $this->param['p_numero'], $this->param['p_importe'], $this->param['p_fecha'], $_SESSION['idusuario'], $this->param['p_codigo']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function update_pre_transaccion() {
        $this->prepararConsultaTransaccion('opc_update_pre_transaccion',  $this->param['p_socio'], $this->param['p_tipoDoc'], $this->param['p_serie'], $this->param['p_numero'], $this->param['p_importe'], $this->param['p_fecha'], $_SESSION['idusuario'], $this->param['p_codigo']);
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

    function getArrayConsumo(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "CODIGO" => $fila["CODIGO"],
                "TIPO_DOCUMENTO" => $fila["TIPO_DOCUMENTO"],
                "DOCUMENTO" => $fila["DOCUMENTO"],
                "IMPORTE" => $fila["IMPORTE"],
                "FECHA" => $fila["FECHA"],
                "ESTADO" => $fila["ESTADO"],
                "SOCIO" => $fila["SOCIO"]
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
        $this->prepararConsultaListadoVentas('opc_contar_ventas_rgistradas', $_SESSION['idusuario'], '0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_listar_ventas_rgistradas', $_SESSION['idusuario'], '0');
            $datos = $this->getArrayVentas();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 50%;">'.$datos[$i]["CLIENTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["TIPO_DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width:  1%;">'.$datos[$i]["IMPORTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["FECHA"].'</td>';

						if ($datos[$i]["ESTADO"] == '1') {
                            echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Confirmado</span></span></td>';
                        }
                echo '
                            <td style="font-size: 15px; text-align: center; height: 10px; width: 1%;">								
	                            <a href="#" class="red" onclick="editar('.$datos[$i]["CODIGO"].')" data-toggle="modal" data-target="#modalVenta">
	                                <i class= "ace-icon fa fa-pencil bigger-200"></i>
	                            </a>	                           
							</td>';
						echo '</tr>';
            }
        }
    }



    function listado_ultimas_ventas_registradas() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_rgistradas', $_SESSION['idusuario'], '0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_listar_ultimas_ventas_rgistradas', $_SESSION['idusuario'], '0');
            $datos = $this->getArrayVentas();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 50%;">'.$datos[$i]["CLIENTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["TIPO_DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["IMPORTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["FECHA"].'</td>';

                if ($datos[$i]["ESTADO"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Confirmado</span></span></td>';
                }
                echo '</tr>';
            }
        }
    }

    function aceptar_transacion() {
        $this->prepararConsultaListadoVentas('opc_aceptar_transaccion', $_SESSION['idusuario'],$this->param['p_codigo']);
        $this->cerrarAbrir();
        $this->listado_ventas_pre_registradas();
    }

    function rechazar_transacion() {
        $this->prepararConsultaListadoVentas('opc_rechazar_transaccion', $_SESSION['idusuario'],$this->param['p_codigo']);
        $this->cerrarAbrir();
        $this->listado_ventas_pre_registradas();
    }

    function listado_ventas_pre_registradas() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_pre_rgistradas', $_SESSION['idusuario'],'0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_listar_ventas_pre_rgistradas', $_SESSION['idusuario'],'0');
            $datos = $this->getArrayVentas();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 20%;">'.$datos[$i]["CLIENTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["TIPO_DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["IMPORTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["FECHA"].'</td>';

                if ($datos[$i]["ESTADO"] == '0') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Pendiente</span></span></td>
                        <td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">                            
                                                    <a href="#" class="red" onclick="aceptarTransaccion('.$datos[$i]["CODIGO"].')">
                                                        <i class= "ace-icon fa fa-check bigger-400"></i>
                                                    </a>
                                                    <a href="#" class="red" onclick="rechazarTransaccion('.$datos[$i]["CODIGO"].')">
                                                        <i class= "ace-icon fa fa-times-circle bigger-400"></i>
                                                    </a>
                                                </td>
                                        </tr>';
                }
                if ($datos[$i]["ESTADO"] == '2') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;"><span class="badge badge-danger badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Rechazado</span></span></td>
                        <td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">                            
                                                    <a href="#" class="red" onclick="aceptarTransaccion('.$datos[$i]["CODIGO"].')">
                                                        <i class= "ace-icon fa fa-check bigger-400"></i>
                                                    </a>                                                    
                                                </td>
                                        </tr>';
                }
            }
        }
    }

    /* DASHBOARD SOCIO */
    function total_ventas_socio() {
        $this->prepararConsultaListadoVentas('opc_total_ventas_socio',  $_SESSION['idusuario'],'0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function venta_neta_socio() {
        $this->prepararConsultaListadoVentas('opc_venta_neta_socio',  $_SESSION['idusuario'],'0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function monto_total_ventas_socio() {
        $this->prepararConsultaListadoVentas('opc_monto_total_ventas_socio',  $_SESSION['idusuario'],'0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function total_numero_socio() {
        $this->prepararConsultaListadoVentas('opc_total_numro_socios',  $_SESSION['idusuario'],'0');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function noti_pre_regitro() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_pre_rgistradas', $_SESSION['idusuario'],'0');
        $total = $this->getArrayTotal();
        echo $total;
    }



    function noti_pre_regitro_item() {
        $this->prepararConsultaListadoVentas('opc_contar_ventas_pre_rgistradas', $_SESSION['idusuario'],'0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_contar_tres_ventas_pre_rgistradas', $_SESSION['idusuario'],'0');
            $datos = $this->getArrayVentas();
            echo '<li class="dropdown-header">Ventas Pre Registradas</li>';
            for($i=0; $i<count($datos); $i++)
            {
                if ($datos[$i]["ESTADO"] == '2') {
                    echo '
                        <li>
                            <a href="#">
                                <span class="badge badge-danger pull-right">R</span>
                                <div class="message">
                                    <div class="content">
                                        <div class="title">'.$datos[$i]["CLIENTE"].'</div>
                                        <div class="description">S/. '.$datos[$i]["IMPORTE"].'</div>
                                    </div>
                                </div>
                            </a>
                        </li>';
                } else {
                    echo '
					<li>
                        <a href="#">
                            <span class="badge badge-warning pull-right">P</span>
                            <div class="message">
                                <div class="content">
                                    <div class="title">'.$datos[$i]["CLIENTE"].'</div>
                                    <div class="description">S/. '.$datos[$i]["IMPORTE"].'</div>
                                </div>
                            </div>
                        </a>
                    </li>';
                }

            }
            echo '<li class="dropdown-footer">
                                            <a href="../partners/ventasPreRegistradas.php">Ver Todos <i class="fa fa-angle-right"
                                                                    aria-hidden="true"></i></a>
                                        </li>';
        }
    }


    function listado_consumo_traveler() {
        $this->prepararConsultaListadoVentas('opc_contar_consumo_clientes', $_SESSION['idusuario'], '0');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaListadoVentas('opc_listar_consumo', $_SESSION['idusuario'], '0');
            $datos = $this->getArrayConsumo();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>													
						<td style="font-size: 12px; text-align: left; height: 10px; width: 15%;">'.$datos[$i]["SOCIO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["TIPO_DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 8%;">'.$datos[$i]["DOCUMENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width:  8%;">'.$datos[$i]["IMPORTE"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 8%;">'.$datos[$i]["FECHA"].'</td>';

                if ($datos[$i]["ESTADO"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 8%;"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Confirmado</span></span></td>';
                } else {
                    if ($datos[$i]["ESTADO"] == '0') {
                        echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 8%;"><span class="badge badge-warning badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Pendiente</span></span></td>';
                    } else {
                        echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 8%;"><span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Rechazado</span></span></td>';
                    }
                }
                echo '
                            <td style="font-size: 15px; text-align: center; height: 10px; width: 5%;">								
	                            <a href="#" class="red" onclick="editar('.$datos[$i]["CODIGO"].')" data-toggle="modal" data-target="#modalVenta">
	                                <i class= "ace-icon fa fa-pencil bigger-200"></i>
	                            </a>	                           
							</td>';
                echo '</tr>';
            }
        }
    }


    function getArrayPagos(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "PagoCuotaViajero" => $fila["PagoCuotaViajero"],
                "NroOperacion" => $fila["NroOperacion"],
                "MontoCuota" => $fila["MontoCuota"],
                "FechaPago" => $fila["FechaPago"],
                "Estado" => $fila["Estado"]
            ));
        }
        return $datos;
    }

    function getArrayPagosPartner(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "PagoCuotaSocio" => $fila["PagoCuotaSocio"],
                "NroOperacion" => $fila["NroOperacion"],
                "Monto" => $fila["Monto"],
                "FechaPago" => $fila["FechaPago"],
                "Estado" => $fila["Estado"]
            ));
        }
        return $datos;
    }

    function getArrayPagosPartnerAdmin(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "RazonSocial" => $fila["RazonSocial"],
                "PagoCuotaSocio" => $fila["PagoCuotaSocio"],
                "NroOperacion" => $fila["NroOperacion"],
                "Monto" => $fila["Monto"],
                "FechaPago" => $fila["FechaPago"],
                "Estado" => $fila["Estado"]
            ));
        }
        return $datos;
    }

    function getArrayPagosTravelerAdmin(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "Traveler" => $fila["Traveler"],
                "PagoCuotaViajero" => $fila["PagoCuotaViajero"],
                "NroOperacion" => $fila["NroOperacion"],
                "MontoCuota" => $fila["MontoCuota"],
                "FechaPago" => $fila["FechaPago"],
                "Estado" => $fila["Estado"]
            ));
        }
        return $datos;
    }



    function listado_pagos_traveler() {
        $this->prepararConsultaBuscarSocio('opc_contar_pagos_traveler', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_listar_pagos_traveler', $_SESSION['idusuario']);
            $datos = $this->getArrayPagos();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["NroOperacion"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"> S/.'.$datos[$i]["MontoCuota"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["FechaPago"].'</td>';

                if ($datos[$i]["Estado"] == '0') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Pendiente</span></span></td>                        
                           <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">
                                <a href="#" class="red" onclick="editarPago('.$datos[$i]["PagoCuotaViajero"].')">
                                    <i class= "ace-icon fa fa-pencil bigger-400"></i>
                                </a>                                
                           </td>
                          </tr>';
                }
                if ($datos[$i]["Estado"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-success badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Confirmado</span></span></td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"></td>
                        </tr>';
                }
            }
        }
    }

    function listado_pagos_partner() {
        $this->prepararConsultaBuscarSocio('opc_contar_pagos_partner', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_listar_pagos_partner', $_SESSION['idusuario']);
            $datos = $this->getArrayPagosPartner();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["NroOperacion"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"> S/.'.$datos[$i]["Monto"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["FechaPago"].'</td>';

                if ($datos[$i]["Estado"] == '0') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Pendiente</span></span></td>                        
                           <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">
                                <a href="#" class="red" onclick="editarPago('.$datos[$i]["PagoCuotaSocio"].')">
                                    <i class= "ace-icon fa fa-pencil bigger-400"></i>
                                </a>                                
                           </td>
                          </tr>';
                }
                if ($datos[$i]["Estado"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-success badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Confirmado</span></span></td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"></td>
                        </tr>';
                }
            }
        }
    }

    function listado_pagos_pendientes_partner() {
        $this->prepararConsultaBuscarSocio('opc_contar_pagos_partner_pendientes', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_listar_pagos_partner_pendientes', $_SESSION['idusuario']);
            $datos = $this->getArrayPagosPartnerAdmin();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["RazonSocial"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["NroOperacion"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"> S/.'.$datos[$i]["Monto"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["FechaPago"].'</td>';

                if ($datos[$i]["Estado"] == '0') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Pendiente</span></span></td>                        
                           <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">
                                <a href="#" class="red" onclick="aceptar('.$datos[$i]["PagoCuotaSocio"].')">
                                    <i class= "ace-icon fa fa-check bigger-400"></i>
                                </a>                                
                           </td>
                          </tr>';
                }
                if ($datos[$i]["Estado"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-success badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Confirmado</span></span></td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"></td>
                        </tr>';
                }
            }
        }
    }


    function listado_pagos_pendientes_traveler() {
        $this->prepararConsultaBuscarSocio('opc_contar_pagos_traveler_pendientes', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_listar_pagos_traveler_pendientes', $_SESSION['idusuario']);
            $datos = $this->getArrayPagosTravelerAdmin();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["Traveler"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["NroOperacion"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"> S/.'.$datos[$i]["MontoCuota"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["FechaPago"].'</td>';

                if ($datos[$i]["Estado"] == '0') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Pendiente</span></span></td>                        
                           <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">
                                <a href="#" class="red" onclick="aceptar('.$datos[$i]["PagoCuotaViajero"].')">
                                    <i class= "ace-icon fa fa-check bigger-400"></i>
                                </a>                                
                           </td>
                          </tr>';
                }
                if ($datos[$i]["Estado"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-success badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Confirmado</span></span></td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"></td>
                        </tr>';
                }
            }
        }
    }


    function getArrayTraveler(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "TRAVELER" => $fila["TRAVELER"],
                "TELEFONO" => $fila["TELEFONO"],
                "EMAIL" => $fila["EMAIL"],
                "PAQUETE" => $fila["PAQUETE"]
            ));
        }
        return $datos;
    }


    function listado_travelers_abiertos() {
        $this->prepararConsultaBuscarSocio('opc_contar_traveler_abierto', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_traveler_abierto', $_SESSION['idusuario']);
            $datos = $this->getArrayTraveler();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 20%;">'.$datos[$i]["TRAVELER"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;"> '.$datos[$i]["TELEFONO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["EMAIL"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["PAQUETE"].'</td>
						</tr>';
            }
        }
    }


    function obtener_comisiones() {
        $this->prepararConsultaBuscarSocio('opc_obtener_comision', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        echo $total;
    }

    function dashboard_total_socios() {
        $this->prepararConsultaBuscarSocio('opc_dashboard_total_socios', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        echo $total;
    }

    function dashboard_total_viajeros() {
        $this->prepararConsultaBuscarSocio('opc_dashboard_total_viajeros', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        echo $total;
    }

    function getArrayMovraveler(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "MOVIMIENTO" => $fila["MOVIMIENTO"],
                "TIPO_MOVIMIENTO" => $fila["TIPO_MOVIMIENTO"],
                "MONTO" => $fila["MONTO"],
                "ESTADO" => $fila["ESTADO"],
                "FECHA" => $fila["FECHA"]
            ));
        }
        return $datos;
    }

    function listado_ultimos_movimientos_traveler() {
        $this->prepararConsultaBuscarSocio('opc_contar_pagos_traveler', $_SESSION['idusuario']);
        $total1 = $this->getArrayTotal();
        $this->cerrarAbrir();
        $this->prepararConsultaBuscarSocio('opc_contar_transacciones_traveler', $_SESSION['idusuario']);
        $total2 = $this->getArrayTotal();
        $datos = array();

        $totalFinal = $total1 + $total2;

        if($totalFinal>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaBuscarSocio('opc_dashboard_ultimos_movimientos', $_SESSION['idusuario']);
            $datos = $this->getArrayMovraveler();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 25%;">'.$datos[$i]["MOVIMIENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["TIPO_MOVIMIENTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["MONTO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["FECHA"].'</td>';

                if ($datos[$i]["ESTADO"] == 'PENDIENTE') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-warning badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>PENDIENTE</span></span></td>';
                } else {
                    if ($datos[$i]["ESTADO"] == 'CONFIRMADO') {
                        echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-success badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>CONFIRMADO</span></span></td>';
                    } else {
                        echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;"><span class="badge badge-danger badge-icon"><i class="fa fa-clock-o" aria-hidden="true"></i><span>RECHAZADO</span></span></td>';
                    }
                }
                echo '</tr>';
            }
        }
    }
}
?>
