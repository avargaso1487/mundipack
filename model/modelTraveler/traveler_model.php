<?php
session_start();
include_once '../../model/conexion_model.php';

class Traveler_model{

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
            case "get_four_all_socios";
                echo $this->get_four_all_socios();
                break;

            case "get_all_socios";
                echo $this->get_all_socios();
                break;

            case "get_four_all_ofertas";
                echo $this->get_four_all_ofertas();
                break;

            case "listado_four_travelers_abiertos";
                echo $this->listado_four_travelers_abiertos();
                break;

            case "listado_travelers_abiertos";
                echo $this->listado_travelers_abiertos();
                break;




            case "get_all_ofertas";
                echo $this->get_all_ofertas();
                break;
            case "add_pago";
                echo $this->add_pago();
                break;
            case "update_pago";
                echo $this->update_pago();
                break;
            case "obtener_pago";
                echo $this->obtener_pago();
                break;

            case "obtener_pago_traveler";
                echo $this->obtener_pago_traveler();
                break;


            case "add_pago_partners";
                echo $this->add_pago_partners();
                break;

            case "add_pago_partners_admin";
                echo $this->add_pago_partners_admin();
                break;

            case "add_pago_traveler_admin";
                echo $this->add_pago_traveler_admin();
                break;

            case "update_pago_partners";
                echo $this->update_pago_partners();
                break;
            case "obtener_pago_partners";
                echo $this->obtener_pago_partners();
                break;

            case "aprobar_pago_partners";
                echo $this->aprobar_pago_partners();
                break;

            case "aprobar_pago_traveler";
                echo $this->aprobar_pago_traveler();
                break;

        }
    }

    function prepararConsultarSocio($opcion = '', $dni = '') {
        $consultaSql = "call sp_buscar_socio(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$dni."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function getArrayTotal(){
        $respuesta = '';
        while($fila = mysqli_fetch_array($this->result)){
            $respuesta = $fila["total"];
        }
        return $respuesta;
    }

    function getArraySocio(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "NOMBRE" => $fila["NOMBRE"],
                "TELEFONO" => $fila["TELEFONO"],
                "DIRECCION" => $fila["DIRECCION"],
                "CARTA_PRESENTACION" => $fila["CARTA_PRESENTACION"],
                "FOTO_PERFIL" => $fila["FOTO_PERFIL"]

            ));
        }
        return $datos;
    }

    function getArrayOferta(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "DESCRIPCION" => $fila["DESCRIPCION"],
                "INICIO" => $fila["INICIO"],
                "FIN" => $fila["FIN"],
                "SOCIO" => $fila["SOCIO"],
                "DIRECCION" => $fila["DIRECCION"],
                "TELEFONO" => $fila["TELEFONO"],
                "IMAGEN" => $fila["IMAGEN"],
                "RETORNO" => $fila["RETORNO"]
            ));
        }
        return $datos;
    }

    private function getArrayResultado() {
        $resultado = 0;
        while ($fila = mysqli_fetch_array($this->result)) {
            $resultado = $fila["respuesta"];
        }
        return $resultado;
    }

    function get_four_all_socios() {
        $this->prepararConsultarSocio('opc_contar_socios', '');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultarSocio('opc_get_four_all_socios', '');
            $datos = $this->getArraySocio();
            echo '<div>';
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div id="user-profile-1" class="user-profile row col-xs-6">
                                    <div class="col-xs-12 col-sm-3 center">
                                        <div class="ace-thumbnails clearfix">
                                            <a class="profile-img" href="../../'.$datos[$i]["FOTO_PERFIL"].'" data-lightbox="image-1" data-title='.$datos[$i]["NOMBRE"].'>
												<img width="140" height="98" alt="100x100" src="../../'.$datos[$i]["FOTO_PERFIL"].'" />												
											</a>                                      
                                            <div class="space-4"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="profile-user-info profile-user-info-striped">

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Nombre Comercial</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_Comercial">'.$datos[$i]["NOMBRE"].'</span>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Dirección</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_direccion">'.$datos[$i]["DIRECCION"].'</span>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Teléfono</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_telefono">'.$datos[$i]["TELEFONO"].'</span>
                                                </div>
                                            </div>                                             
                                        </div><br>
                                        <a class="profile-img btn btn-xs btn-primary" href="../../'.$datos[$i]["CARTA_PRESENTACION"].'" data-lightbox="image-1" data-title='.$datos[$i]["NOMBRE"].'>
                                            Ver Carta de Presentacion											
                                        </a>
                                    </div>
                                       
                                    

                                </div>';
            }
            echo '</div><br><br><br><br><br><br> ';

            if ($total>4) {
                echo '<div class="center">
                            <input  type="button" class="btn btn-sm btn-primary" onclick="all_socio()"value="Ver Todos"/>                           
                        </div>';
            }
        } else {
            echo '0';
        }
    }

    function get_all_socios() {
        $this->prepararConsultarSocio('opc_contar_socios', '');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultarSocio('opc_get_all_socios', '');
            $datos = $this->getArraySocio();
            echo '<div>';
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div id="user-profile-1" class="user-profile row col-xs-6">
                                    <div class="col-xs-12 col-sm-3 center">
                                        <div class="ace-thumbnails clearfix">
                                            <a class="profile-img" href="../../'.$datos[$i]["FOTO_PERFIL"].'" data-lightbox="image-1" data-title='.$datos[$i]["NOMBRE"].'>
												<img width="140" height="99" alt="100x100" src="../../'.$datos[$i]["FOTO_PERFIL"].'" />												
											</a>                                      
                                            <div class="space-4"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="profile-user-info profile-user-info-striped">

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Nombre Comercial</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_Comercial">'.$datos[$i]["NOMBRE"].'</span>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Dirección</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_direccion">'.$datos[$i]["DIRECCION"].'</span>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Teléfono</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_telefono">'.$datos[$i]["TELEFONO"].'</span>
                                                </div>
                                            </div>

                                        </div>
                                        <br>
                                        <a class="profile-img btn btn-xs btn-primary" href="../../'.$datos[$i]["CARTA_PRESENTACION"].'" data-lightbox="image-1" data-title='.$datos[$i]["NOMBRE"].'>
                                            Ver Carta de Presentacion											
                                        </a>
                                        
                                    </div>
                                       
                                    

                                </div>';
            }
            echo '</div><br><br><br><br><br><br> ';
        } else {
            echo '0';
        }
    }


    function get_four_all_ofertas() {
        $this->prepararConsultarSocio('opc_contar_ofertas', '');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultarSocio('opc_get_four_all_ofertas', '');
            $datos = $this->getArrayOferta();
            echo '<div>';
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div id="user-profile-1" class="user-profile row col-xs-6">
                                    <div class="col-xs-12 col-sm-3 center">
                                        <div class="ace-thumbnails clearfix">
                                            <a class="profile-img" href="'.$datos[$i]["IMAGEN"].'" data-lightbox="image-1" data-title='.$datos[$i]["DESCRIPCION"].'>
												<img width="140" height="225" alt="100x100" src="'.$datos[$i]["IMAGEN"].'" />												
											</a>                                      
                                            <div class="space-4"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="profile-user-info profile-user-info-striped">

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Descripción</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_Comercial">'.$datos[$i]["DESCRIPCION"].'</span>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Fecha Inicio</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_direccion">'.$datos[$i]["INICIO"].'</span>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Fecha Fin</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_telefono">'.$datos[$i]["FIN"].'</span>
                                                </div>
                                            </div>
                                            
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Asociado</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_telefono">'.$datos[$i]["SOCIO"].'</span>
                                                </div>
                                            </div>
                                            
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Dirección</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_telefono">'.$datos[$i]["DIRECCION"].'</span>
                                                </div>
                                            </div>
                                            
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Teléfono</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_telefono">'.$datos[$i]["TELEFONO"].'</span>
                                                </div>
                                            </div>
                                            
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> % de Retorno</div>

                                                <div class="profile-info-value">
                                                    <span id="socio_telefono">'.$datos[$i]["RETORNO"].'</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                       
                                    

                                </div>';
            }
            echo '</div><br><br><br><br><br><br> ';

            if ($total>4) {
                echo '<div class="center">
                            <input  type="button" class="btn btn-sm btn-primary" onclick="all_socio()"value="Ver Todos"/>                           
                        </div>';
            }
        } else {
            echo '0';
        }
    }

    function get_all_ofertas() {
        $this->prepararConsultarSocio('opc_contar_ofertas', '');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultarSocio('opc_get_all_ofertas', '');
            $datos = $this->getArrayOferta();
            echo '<div>';
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div id="user-profile-1" class="user-profile row col-xs-6">
                        <div class="col-xs-12 col-sm-3 center">
                            <div class="ace-thumbnails clearfix">
                                <a class="profile-img" href="'.$datos[$i]["CARTA_PRESENTACION"].'" data-lightbox="image-1" data-title='.$datos[$i]["NOMBRE"].'>
                                    <img width="140" height="225" alt="100x100" src="'.$datos[$i]["CARTA_PRESENTACION"].'" />												
                                </a>                                      
                                <div class="space-4"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Nombre Comercial</div>

                                    <div class="profile-info-value">
                                        <span id="socio_Comercial">'.$datos[$i]["NOMBRE"].'</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Dirección</div>

                                    <div class="profile-info-value">
                                        <span id="socio_direccion">'.$datos[$i]["DIRECCION"].'</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Teléfono</div>

                                    <div class="profile-info-value">
                                        <span id="socio_telefono">'.$datos[$i]["TELEFONO"].'</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> % de Retorno</div>

                            <div class="profile-info-value">
                                <span id="socio_telefono">'.$datos[$i]["RETORNO"].'</span>
                            </div>
                        </div>
                        

                    </div>';
            }
            echo '</div><br><br><br><br><br><br> ';
        } else {
            echo '0';
        }
    }

    function getArrayTraveler(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "TRAVELER" => $fila["TRAVELER"],
                "TELEFONO" => $fila["TELEFONO"],
                "EMAIL" => $fila["EMAIL"],
                "PAQUETE" => $fila["PAQUETE"],
                "IMAGEN" => $fila["IMAGEN"]
            ));
        }
        return $datos;
    }

    function listado_four_travelers_abiertos() {
        $this->prepararConsultarSocio('opc_contar_traveler_abierto', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultarSocio('opc_get_four_travelers_abiertos', $_SESSION['idusuario']);
            $datos = $this->getArrayTraveler();
            echo '<div>';
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div id="user-profile-1" class="user-profile row col-xs-6">
                    <div class="col-xs-12 col-sm-2 center">
                        <div class="ace-thumbnails clearfix">
                            <a class="profile-img" href="../../'.$datos[$i]["IMAGEN"].'" data-lightbox="image-1" data-title='.$datos[$i]["TRAVELER"].'>
                                <img width="97" height="128" alt="100x100" src="../../'.$datos[$i]["IMAGEN"].'" />												
                            </a>                                      
                            <div class="space-4"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <div class="profile-user-info profile-user-info-striped">                                                                                                                                                                                                            
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nombres y Apellidos</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["TRAVELER"].'</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Teléfono</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["TELEFONO"].'</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Email</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["EMAIL"].'</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Paquete Elegido</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["PAQUETE"].'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                       
                    

                </div>';
            }
            echo '</div><br><br><br><br><br><br> ';

            if ($total>4) {
                echo '<div class="center">
                            <input  type="button" class="btn btn-sm btn-primary" onclick="all_traveler_abierto()"value="Ver Todos"/>                           
                        </div>';
            }
        } else {
            echo '0';
        }
    }

    function listado_travelers_abiertos() {
        $this->prepararConsultarSocio('opc_contar_traveler_abierto', $_SESSION['idusuario']);
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultarSocio('opc_get_four_travelers_abiertos', $_SESSION['idusuario']);
            $datos = $this->getArrayTraveler();
            echo '<div>';
            for($i=0; $i<count($datos); $i++)
            {
                echo '<div id="user-profile-1" class="user-profile row col-xs-6">
                    <div class="col-xs-12 col-sm-2 center">
                        <div class="ace-thumbnails clearfix">
                            <a class="profile-img" href="../../'.$datos[$i]["IMAGEN"].'" data-lightbox="image-1" data-title='.$datos[$i]["TRAVELER"].'>
                                <img width="97" height="128" alt="100x100" src="../../'.$datos[$i]["IMAGEN"].'" />												
                            </a>                                      
                            <div class="space-4"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <div class="profile-user-info profile-user-info-striped">                                                                                                                                                                                                            
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nombres y Apellidos</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["TRAVELER"].'</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Teléfono</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["TELEFONO"].'</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Email</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["EMAIL"].'</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Paquete Elegido</div>

                                <div class="profile-info-value">
                                    <span id="socio_telefono">'.$datos[$i]["PAQUETE"].'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                       
                    

                </div>';
            }
            echo '</div><br><br><br><br> ';
        } else {
            echo '0';
        }
    }



    function prepararConsultarPago($opcion = '', $operacion = '', $monto = '', $fecha = '', $pagoId = '', $usuario = '') {
        $consultaSql = "call sp_gestionar_pagos(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$operacion."',";
        $consultaSql.= "'".$monto."',";
        $consultaSql.= "'".$fecha."',";
        $consultaSql.= "'".$pagoId."',";
        $consultaSql.= "'".$usuario."')";
        // echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }

    function add_pago() {
        $this->prepararConsultarPago('opc_registrar_pago',  $this->param['p_operacion'], $this->param['p_monto'], $this->param['p_fecha'], '0', $_SESSION['idusuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function update_pago() {
        $this->prepararConsultarPago('opc_update_pago',  $this->param['p_operacion'], $this->param['p_monto'], $this->param['p_fecha'], $this->param['p_pagoID'], $_SESSION['idusuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function obtener_pago() {
        $this->prepararConsultarPago('opc_obtener_pago',  '', '0', '1999-09-09', $this->param['p_pagoID'], $_SESSION['idusuario']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function add_pago_partners() {
        $this->prepararConsultarPago('opc_registrar_pago_partner',  $this->param['p_operacion'], $this->param['p_monto'], $this->param['p_fecha'], '0', $_SESSION['idusuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function add_pago_partners_admin() {
        $this->prepararConsultarPago('opc_registrar_pago_partner_admin',  $this->param['p_operacion'], $this->param['p_monto'], $this->param['p_fecha'], $this->param['p_socioID'], $_SESSION['idusuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function add_pago_traveler_admin() {
        $this->prepararConsultarPago('opc_registrar_pago_traveler_admin',  $this->param['p_operacion'], $this->param['p_monto'], $this->param['p_fecha'], $this->param['p_travelerID'], $_SESSION['idusuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }


    function update_pago_partners() {
        $this->prepararConsultarPago('opc_update_pago_partner',  $this->param['p_operacion'], $this->param['p_monto'], $this->param['p_fecha'], $this->param['p_pagoID'], $_SESSION['idusuario']);
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }

    function obtener_pago_partners() {
        $this->prepararConsultarPago('opc_obtener_pago_partner',  '', '0', '1999-09-09', $this->param['p_pagoID'], $_SESSION['idusuario']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function obtener_pago_traveler() {
        $this->prepararConsultarPago('opc_obtener_pago_traveler',  '', '0', '1999-09-09', $this->param['p_pagoID'], $_SESSION['idusuario']);
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }



    function aprobar_pago_partners() {
        $this->prepararConsultarPago('aprobar_pago_partners',  '', '0', '1999-09-09', $this->param['p_pagoID'], $_SESSION['idusuario']);
        $row = mysqli_fetch_row($this->result);
        echo 1;
    }

    function aprobar_pago_traveler() {
        $this->prepararConsultarPago('aprobar_pago_traveler',  '', '0', '1999-09-09', $this->param['p_pagoID'], $_SESSION['idusuario']);
        $row = mysqli_fetch_row($this->result);
        echo 1;
    }




}
?>
