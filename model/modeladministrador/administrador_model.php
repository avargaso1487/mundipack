<?php
session_start();
include_once '../../model/conexion_model.php';
class Administrador_model{
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
        switch($this->param['opcion'])
        {
            case "listarSocios";
                echo $this->listarSocios();
                break;
            case "grabarSocio";
                echo $this->grabarSocio();
                break;
            case "eliminarSocio";
                echo $this->eliminarSocio();
                break;
            case "eliminarViajero";
                echo $this->eliminarViajero();
                break;
            case "listarViajeros";
                echo $this->listarViajeros();
                break;
            case "grabarViajero";
                echo $this->grabarViajero();
                break;
            case "getDatosNP";
                echo $this->getDatosNP();
                break;

            case "listar_viajeros_recomendados";
                echo $this->listar_viajeros_recomendados();
                break;

            case "grabar_viajero_recomendado";
                echo $this->grabar_viajero_recomendado();
                break;


        }
    }

    function prepararConsultaAdministrador($opcion = '')
    {
        $consultaSql = "call sp_control_administrador(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$this->param['socioNombreComercial']."',";
        $consultaSql.= "'".$this->param['socioRubro']."',";
        $consultaSql.= "'".$this->param['socioRUC']."',";
        $consultaSql.= "'".$this->param['socioDireccion']."',";
        $consultaSql.= "'".$this->param['socioTelefonoContacto']."',";
        $consultaSql.= "'".$this->param['socioTelefonoAtencion']."',";
        $consultaSql.= "'".$this->param['socioEmail']."',";
        $consultaSql.= "'".$this->param['socioRazonSocial']."',";
        $consultaSql.= "'".$this->param['socioNroCuenta']."',";
        $consultaSql.= "'".$this->param['socioContactoResponsable']."',";
        $consultaSql.= "".$this->param['socioPrctjRetorno'].",";
        $consultaSql.= "".$this->param['socioPrecioDesde'].",";
        $consultaSql.= "".$this->param['socioID'].",";
        $consultaSql.= "".$this->param['viajeroID'].",";
        $consultaSql.= "'".$this->param['viajeroNombre']."',";
        $consultaSql.= "'".$this->param['viajeroApellidos']."',";
        $consultaSql.= "'".$this->param['viajeroDNI']."',";
        $consultaSql.= "'".$this->param['viajeroDireccion']."',";
        $consultaSql.= "'".$this->param['viajeroNacimiento']."',";
        $consultaSql.= "'".$this->param['viajeroTelefonoFijo']."',";
        $consultaSql.= "'".$this->param['viajeroTelefonoCelular']."',";
        $consultaSql.= "'".$this->param['viajeroEmail']."',";
        $consultaSql.= "'".$this->param['viajeroNroPasaporte']."',";
        $consultaSql.= "".$this->param['viajeroAbierto'].",";
        $consultaSql.= "".$this->param['socioDiaPago'].",";
        $consultaSql.= "".$this->param['viajeroDiaPago'].",";
        $consultaSql.= "".$this->param['viajeroPaquetePrincipal'].",";
        $consultaSql.= "".$this->param['viajeroPaqueteSecundarioOne'].",";
        $consultaSql.= "".$this->param['viajeroPaqueteSecundarioTwo'].",";
        $consultaSql.= "".$this->param['viajeroMontoPago'].",";
        $consultaSql.= "".$this->param['socioRestriccionTarjeta'].",";
        $consultaSql.= "".$this->param['socioRestriccionAlmuerzo'].",";
        $consultaSql.= "".$this->param['socioRestriccionMenu'].",";
        $consultaSql.= "".$this->param['socioRestriccionPromocion'].",";
        $consultaSql.= "".$this->param['socioRestriccionDelivery'].")";
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
    function getArraySocios(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "socioID" => $fila["socioID"],
                "socioNombre" => $fila["socioNombre"],
                "socioRubro" => $fila["socioRubro"],
                "socioPorcentajeRetorno" => $fila["socioPorcentajeRetorno"],
                "socioPrecioDesde" => $fila["socioPrecioDesde"],
                "socioDiaPago" => $fila["socioDiaPago"],
                "socioTelefonoContacto" => $fila["socioTelefonoContacto"],
                "socioRUC" => $fila["socioRUC"]
            ));
        }
        return $datos;
    }
    function listarSocios()
    {
        $this->prepararConsultaAdministrador('opc_contar_socios');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaAdministrador('opc_listar_socios');
            $datos = $this->getArraySocios();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: center; height: 10px; width: 12%;">'.$datos[$i]["socioNombre"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["socioRUC"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["socioRubro"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["socioTelefonoContacto"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["socioPorcentajeRetorno"].'</td>
                        <td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["socioDiaPago"].'</td>
						<td style="font-size: 15px; text-align:center; height: 10px; width: 2%;">';
                /*<a href="#modalSocio" data-toggle="modal" class="red" onclick="editar('.$datos[$i]["socioID"].')">
                    <i class= "ace-icon fa fa-pencil bigger-200"></i>
                </a>*/
                echo '                        	
                            <a href="#" class="green" onclick="datosNetPartner('.$datos[$i]["socioID"].')">
                                <i class= "fa fa-user"></i>
                            </a>                            
							<a href="#" class="red" onclick="eliminar('.$datos[$i]["socioID"].')">
                                <i class= "fa fa-trash-o"></i>
                            </a>
						</td>
					</tr>';
            }
        }
    }
    function getArrayViajeros(){
        $datos = array();
        //print_r($this->result);
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "viajeroID" => $fila["viajeroID"],
                "viajeroNombre" => $fila["viajeroNombre"],
                "viajeroApellidos" => $fila["viajeroApellidos"],
                "viajeroDNI" => $fila["viajeroDNI"],
                "viajeroNroPasaporte" => $fila["viajeroNroPasaporte"],
                "viajeroCelular" => $fila["viajeroCelular"],
                "viajeroPaqueteObjetivo" => $fila["viajeroPaqueteObjetivo"],
                "viajeroAcumulado" => $fila["viajeroAcumulado"],
                "viajeroEstadoPago" => $fila["viajeroEstadoPago"],
                "viajeroAbierto" => ($fila["viajeroAbierto"])
            ));
        }
        return $datos;
    }

    function getArrayDatosNP(){
        $datos = array();
        //print_r($this->result);
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "razonSocial" => $fila["RazonSocial"],
                "nombreComercial" => $fila["NombreComercial"],
                "rubro" => $fila["Rubro"],
                "imagen" => $fila["Imagen"],
                "RUC" => $fila["RUC"],
                "direccion" => $fila["Direccion"],
                "telefContacto" => $fila["TelefonoContacto"],
                "telefAtencion" => $fila["TelefonoAtencion"],
                "email" => $fila["Email"],
                "nroCuenta" => $fila["NroCuenta"],
                "contactoResponsable" => $fila["ContactoResponsable"],
                "prctjRetorno" => $fila["PorcentajeRetorno"],
                "precioDesde" => $fila["PrecioDesde"],
                "diaPago" => $fila["DiaPago"]));
        }
        return $datos;
    }

    function listarViajeros()
    {
        $this->prepararConsultaAdministrador('opc_contar_viajeros');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaAdministrador('opc_listar_viajeros');
            $datos = $this->getArrayViajeros();
            for($i=0; $i<count($datos); $i++)
            {
                echo '<tr>							
							<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["viajeroNombre"].' '.$datos[$i]["viajeroApellidos"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["viajeroDNI"].'</td>							
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroCelular"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 10%;">'.$datos[$i]["viajeroPaqueteObjetivo"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["viajeroAcumulado"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 1%;">'.$datos[$i]["viajeroAbierto"].'</td>
							<td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">
								<a href="#" class="red" onclick="eliminar('.$datos[$i]["viajeroID"].')">
	                                <i class= "ace-icon fa fa-trash-o bigger-200"></i>
	                            </a>
							</td>
						</tr>';
            }
        }
    }


    function prepararConsultaViajerosRecomendados($opcion = '')
    {
        $consultaSql = "call sp_control_viajero_recomentado(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$this->param['viajeroNombre']."',";
        $consultaSql.= "'".$this->param['viajeroApellidos']."',";
        $consultaSql.= "'".$this->param['viajeroDNI']."',";
        $consultaSql.= "'".$this->param['viajeroDireccion']."',";
        $consultaSql.= "'".$this->param['viajeroNacimiento']."',";
        $consultaSql.= "'".$this->param['viajeroTelefonoFijo']."',";
        $consultaSql.= "'".$this->param['viajeroTelefonoCelular']."',";
        $consultaSql.= "'".$this->param['viajeroEmail']."',";
        $consultaSql.= "'".$this->param['viajeroNroPasaporte']."',";
        $consultaSql.= "'".$this->param['viajeroAbierto']."',";
        $consultaSql.= "".$_SESSION['idusuario'].")";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion, $consultaSql);
    }


    function listar_viajeros_recomendados()
    {
        $this->prepararConsultaViajerosRecomendados('opc_contar_viajeros_recomendados');
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaViajerosRecomendados('opc_listar_viajeros_recomendados');
            $datos = $this->getArrayViajeros();
            for($i=0; $i<count($datos); $i++)
            {
                echo '<tr>							
							<td style="font-size: 12px; text-align: center; height: 10px; width: 20%;">'.$datos[$i]["viajeroNombre"].' '.$datos[$i]["viajeroApellidos"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroDNI"].'</td>							
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroCelular"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroPaqueteObjetivo"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroAcumulado"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroAbierto"].'</td>
							<td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">
								<a href="#" class="red" onclick="eliminar('.$datos[$i]["viajeroID"].')">
	                                <i class= "ace-icon fa fa-trash-o bigger-200"></i>
	                            </a>
							</td>
						</tr>';
            }
        } else {
            echo '0';
        }
    }


    function grabar_viajero_recomendado()
    {
        $this->prepararConsultaViajerosRecomendados('opc_grabar_viajero_recomendado');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }


    function getDatosNP(){
        $this->prepararConsultaAdministrador('opc_get_NP');
        $datos = $this->getArrayDatosNP();

        for($i=0; $i<count($datos); $i++)
        {
            echo '
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="text-align: center; font-size: 18px; color: blue">'.$datos[$i]["nombreComercial"].'</h4>

                    </div>

                    <div class="modal-body" id="modalNetPartner">                            
                        <div class="col-xs-12 col-sm-4">
                            <div>
                              <span class="profile-img">
                                <img class="img-responsive" alt="Net Partner" src="../../'.$datos[$i]["imagen"].'" />
                              </span>
                              <div class="space-4" id="RazonSocial"></div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-5">                                
                            <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Razón Social: <b style="font-size: 14px;">'.$datos[$i]["razonSocial"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Nombre Comercial: <b style="font-size: 14px;">'.$datos[$i]["nombreComercial"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Rubro: <b style="font-size: 14px;">'.$datos[$i]["rubro"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">RUC: <b style="font-size: 14px;">'.$datos[$i]["RUC"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Dirección: <b style="font-size: 14px;">'.$datos[$i]["direccion"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">T. Contacto: <b style="font-size: 14px;">'.$datos[$i]["telefContacto"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">T. Atención: <b style="font-size: 14px;">'.$datos[$i]["telefAtencion"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Email: <b style="font-size: 14px;">'.$datos[$i]["email"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">N° Cuenta: <b style="font-size: 14px;">'.$datos[$i]["nroCuenta"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Contacto Responsable: <b style="font-size: 14px;">'.$datos[$i]["contactoResponsable"].'</b></label>                                
                        </div>

                        <div class="col-xs-12 col-sm-3">                                
                            <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">N° Cuenta: <b style="font-size: 14px;">'.$datos[$i]["nroCuenta"].'</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Contacto Responsable: <b style="font-size: 14px;">'.$datos[$i]["contactoResponsable"].'</b></label>                                
                            <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Porcentaje Retorno: <b style="font-size: 14px;">'.$datos[$i]["prctjRetorno"].'%</b></label>
                            <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Precios Desde: <b style="font-size: 14px;">S/. '.$datos[$i]["precioDesde"].'</b></label>
                            <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Día Límite Pago: <b style="font-size: 14px;">'.$datos[$i]["diaPago"].'</b></label>
                        </div>

                        <br><br><br><br>
                        <br><br><br>
                        <br><br><br><br><br>
                    </div>
                    <div class="modal-footer">                                    
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>';
        }
    }

    private function getArrayResultado() {
        $resultado = 0;
        while ($fila = mysqli_fetch_array($this->result)) {
            $resultado = $fila["resultado"];
        }
        return $resultado;
    }
    function grabarSocio()
    {
        $this->prepararConsultaAdministrador('opc_grabar_socio');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }
    function grabarViajero()
    {
        $this->prepararConsultaAdministrador('opc_grabar_viajero');
        $resultado = $this->getArrayResultado();
        echo $resultado;
    }
    function eliminarSocio() {
        $this->prepararConsultaAdministrador('opc_eliminar_socio');
    }
    function eliminarViajero() {
        $this->prepararConsultaAdministrador('opc_eliminar_viajero');
    }
}
?>