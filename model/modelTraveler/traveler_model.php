<?php
//session_start();
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

            case "get_all_ofertas";
                echo $this->get_all_ofertas();
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
                "CARTA_PRESENTACION" => $fila["CARTA_PRESENTACION"]
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
                "IMAGEN" => $fila["IMAGEN"]
            ));
        }
        return $datos;
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
                                            <a class="profile-img" href="'.$datos[$i]["CARTA_PRESENTACION"].'" data-lightbox="image-1" data-title='.$datos[$i]["NOMBRE"].'>
												<img width="140" height="100" alt="100x100" src="'.$datos[$i]["CARTA_PRESENTACION"].'" />												
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
                                            <a class="profile-img" href="'.$datos[$i]["CARTA_PRESENTACION"].'" data-lightbox="image-1" data-title='.$datos[$i]["NOMBRE"].'>
												<img width="140" height="100" alt="100x100" src="'.$datos[$i]["CARTA_PRESENTACION"].'" />												
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
												<img width="140" height="190" alt="100x100" src="'.$datos[$i]["IMAGEN"].'" />												
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
												<img width="140" height="100" alt="100x100" src="'.$datos[$i]["CARTA_PRESENTACION"].'" />												
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
                                       
                                    

                                </div>';
            }
            echo '</div><br><br><br><br><br><br> ';
        } else {
            echo '0';
        }
    }
}
?>
