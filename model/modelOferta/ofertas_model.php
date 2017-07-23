<?php
//session_start();
include_once '../../model/conexion_model.php';

class Ofertas_model{

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
            case "add_oferta";
                echo $this->add_oferta();
                break;
            case "listar_ofertas";
                echo $this->listar_ofertas();
                break;
            case "eliminar_ofertas";
                echo $this->eliminar_ofertas();
                break;
            case "activar_ofertas";
                echo $this->activar_ofertas();
                break;
            case "obtener_ofertas";
                echo $this->obtener_ofertas();
                break;
            case "update_oferta";
                echo $this->update_oferta();
                break;

        }
    }

    function prepararConsultaOfertas($opcion = '', $descripcion = '', $fechaInicio = '', $fechaFin = '', $stock = '', $usuario = '', $ruta = '', $codigo = '', $porcentaje = '')
    {
        $consultaSql = "call sp_control_ofertas(";
        $consultaSql.= "'".$opcion."',";
        $consultaSql.= "'".$descripcion."',";
        $consultaSql.= "'".$fechaInicio."',";
        $consultaSql.= "'".$fechaFin."',";
        $consultaSql.= "'".$stock."',";
        $consultaSql.= "'".$ruta."',";
        $consultaSql.= "'".$usuario."',";
        $consultaSql.= "'".$codigo."',";
        $consultaSql.= "'".$porcentaje."')";
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

    function add_oferta() {
        if ($this->param['p_archivo'] == '') {
            $this->prepararConsultaOfertas('opc_add_oferta', $this->param['p_descripcion'], $this->param['p_fechaInicio'], $this->param['p_fechaFin'], $this->param['p_stock'], $_SESSION['idusuario'], '', '', $this->param['p_porcentaje']);
            $this->cerrarAbrir();
            echo 1;
        } else {
            $this->prepararConsultaOfertas('opc_add_oferta', $this->param['p_descripcion'], $this->param['p_fechaInicio'], $this->param['p_fechaFin'], $this->param['p_stock'], $_SESSION['idusuario'], $this->param['p_ruta'], '', $this->param['p_porcentaje']);
            $this->cerrarAbrir();
            $destino = '../../view/partners/ofertas/'.$this->param['p_archivo'];
            $archivo = $this->param['p_fileArchivo'];
            move_uploaded_file($archivo, $destino);
            echo 1;
        }


        //echo $this->param['ruta'];
    }

    function update_oferta() {
        if ($this->param['p_archivo'] == '') {
            $this->prepararConsultaOfertas('opc_update_oferta', $this->param['p_descripcion'], $this->param['p_fechaInicio'], $this->param['p_fechaFin'], $this->param['p_stock'], $_SESSION['idusuario'], '', $this->param['p_codigo'], $this->param['p_porcentaje']);
            $this->cerrarAbrir();
            echo 1;
        } else {
            $this->prepararConsultaOfertas('opc_update_oferta', $this->param['p_descripcion'], $this->param['p_fechaInicio'], $this->param['p_fechaFin'], $this->param['p_stock'], $_SESSION['idusuario'], $this->param['p_ruta'], $this->param['p_codigo'], $this->param['p_porcentaje']);
            $this->cerrarAbrir();
            $destino = '../../view/partners/ofertas/'.$this->param['p_archivo'];
            $archivo = $this->param['p_fileArchivo'];
            move_uploaded_file($archivo, $destino);
            echo 1;
        }

        //echo $this->param['ruta'];
    }

    function eliminar_ofertas() {
        $this->prepararConsultaOfertas('opc_eliminar_oferta', '', '1999-09-09', '1999-09-09', '0', $_SESSION['idusuario'], '', $this->param['p_codigo'], '0');
        echo 1;
        //echo $this->param['ruta'];
    }
    function activar_ofertas() {
        $this->prepararConsultaOfertas('opc_activar_oferta', '', '1999-09-09', '1999-09-09', '0', $_SESSION['idusuario'], '', $this->param['p_codigo'], '0');
        echo 1;
        //echo $this->param['ruta'];
    }

    function obtener_ofertas() {
        $this->prepararConsultaOfertas('opc_obtener_oferta', '', '1999-09-09', '1999-09-09', '0', $_SESSION['idusuario'], '', $this->param['p_codigo'], '0');
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }

    function getArrayOfertas(){
        $datos = array();
        while($fila = mysqli_fetch_array($this->result)){
            array_push($datos, array(
                "PROMO_ID" => $fila["PROMO_ID"],
                "DESCRIPCION" => $fila["DESCRIPCION"],
                "FECHA_INICIO" => $fila["FECHA_INICIO"],
                "FECHA_FIN" => $fila["FECHA_FIN"],
                "STOCK" => $fila["STOCK"],
                "IMAGEN" => $fila["IMAGEN"],
                "ESTADO" => $fila["ESTADO"],
                "PORCENTAJE" => $fila["PORCENTAJE"]
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

    function listar_ofertas() {
        $this->prepararConsultaOfertas('opc_total_ofertas', '', '1999-09-09', '1999-09-09', '0', $_SESSION['idusuario'], '', '', '0');
        $this->cerrarAbrir();
        $total = $this->getArrayTotal();
        $datos = array();
        if($total>0)
        {
            $this->cerrarAbrir();
            $this->prepararConsultaOfertas('opc_listar_oferta', '', '1999-09-09', '1999-09-09', '0', $_SESSION['idusuario'], '', '', '0');
            $datos = $this->getArrayOfertas();
            for($i=0; $i<count($datos); $i++)
            {
                echo '
					<tr>							
						<td style="font-size: 12px; text-align: left; height: 10px; width: 10%;">'.$datos[$i]["DESCRIPCION"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["FECHA_INICIO"].'</td>
						<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">'.$datos[$i]["FECHA_FIN"].'</td>';
                
                if ( $datos[$i]["PORCENTAJE"] == '1') {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">SI</td>';
                } else {
                    echo '<td style="font-size: 12px; text-align: center; height: 10px; width: 4%;">NO</td>';
                }
                if ($datos[$i]["ESTADO"] == '1') {
                    echo '<td style="font-size: 15px; text-align: center; height: 10px; width: 4%;"><span class="badge badge-success badge-icon"><span>ACTIVO</span></span></td>
                            <td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">
								<a href="#" class="red" onclick="ver('.$datos[$i]["PROMO_ID"].')" data-toggle="modal" data-target="#modalVerOferta">
	                                <i class= "ace-icon fa fa-eye bigger-200"></i>
	                            </a>
	                            <a href="#" class="red" onclick="editar('.$datos[$i]["PROMO_ID"].')" data-toggle="modal" data-target="#modalOferta">
	                                <i class= "ace-icon fa fa-pencil bigger-200"></i>
	                            </a>
	                            <a href="#" class="red" onclick="eliminar('.$datos[$i]["PROMO_ID"].')">
	                                <i class= "ace-icon fa fa-trash-o bigger-200"></i>
	                            </a>
							</td>';
                } else {
                    echo '<td style="font-size: 15px; text-align: center; height: 10px; width: 4%;"><span class="badge badge-danger badge-icon"><span>INACTIVO</span></span></td>
                            <td style="font-size: 15px; text-align: center; height: 10px; width: 2%;">
								<a href="#" class="red" onclick="ver('.$datos[$i]["PROMO_ID"].')" data-toggle="modal" data-target="#modalVerOferta">
	                                <i class= "ace-icon fa fa-eye bigger-200"></i>
	                            </a>
	                            <a href="#" class="red" onclick="editar('.$datos[$i]["PROMO_ID"].')" data-toggle="modal" data-target="#modalOferta">
	                                <i class= "ace-icon fa fa-pencil bigger-200"></i>
	                            </a>
	                            <a href="#" class="red" onclick="activar('.$datos[$i]["PROMO_ID"].')">
	                                <i class= "ace-icon fa fa-check bigger-200"></i>
	                            </a>
							</td>';
                }

                echo '
                </tr>';
            }
        }
    }
}
?>
