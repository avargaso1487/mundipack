<?php
//session_start();
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
        $consultaSql.= "".$this->param['viajeroAbierto'].")";
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
						<td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">';
                /*<a href="#modalSocio" data-toggle="modal" class="red" onclick="editar('.$datos[$i]["socioID"].')">
                    <i class= "ace-icon fa fa-pencil bigger-200"></i>
                </a>*/
                echo '                        	
							<a href="#" class="red" onclick="eliminar('.$datos[$i]["socioID"].')">
                                <i class= "fa fa-trash-o close col-md-6"></i>
                            </a>
                            <form method="post" action="socio_profile.php">
                            	<input type="text" hidden name="socioID" value="2">
                        		<button type="submit" class="close col-md-offset-3">
							      <i class="fa fa-user"></i>
							    </button>                 
                        	</form>
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
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroDNI"].'</td>
							<td style="font-size: 12px; text-align: center; height: 10px; width: 3%;">'.$datos[$i]["viajeroNroPasaporte"].'</td>
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