<?php
//session_start();
include_once '../../model/conexion_model.php';
class Usuario_model{
    private $param = array();
    private $conexion = null;
    function __construct()
    {
        $this->conexion = Conexion_Model::getConexion();
    }
    function cerrarAbrir()
    {
        mysqli_close($this->conexion);
        $this->conexion = Conexion_Model::getConexion();
    }
    function gestionar($param)
    {
        $this->param = $param;
        switch($this->param['opcion'])
        {
            case "login";
                echo $this->login();
                break;
            case "cargarDashboard";
                echo $this->cargarDashboard();
                break;
            case "nuevoSocio";
                echo $this->nuevoSocio();
                break;
            case "listarUsuariosSocios";
                echo $this->listarUsuariosSocios();
                break;
            case "listarSocios";
                echo $this->listarSocios();
                break;
            case "mostrar";
                echo $this->mostrarUsuario();
                break;
            case "modificarUsuario";
                echo $this->modificarUsuario();
                break;
            case "eliminarUsuario";
                echo $this->eliminarUsuario();
                break;
            case "mostrarMenu";
                echo $this->mostrarMenu();
                break;
        }
    }
    function prepararConsultaUsuario($opcion)
    {
        $consultaSql = "call sp_control_usuario(";
        $consultaSql.="'".$opcion."',";
        $consultaSql.="'".$this->param['usuario']."',";
        $consultaSql.="'".$this->param['password']."')";
        //echo $consultaSql;
        $this->result = mysqli_query($this->conexion,$consultaSql);
    }
    function prepararConsultaDashboard($opcion)
    {
        $consultaSql3 = "call sp_control_dashboard(";
        $consultaSql3.="'".$opcion."',";
        $consultaSql3.="".$_SESSION['usuarioIdRol'].")";
        //echo $consultaSql3;
        $this->result3 = mysqli_query($this->conexion,$consultaSql3);
    }
    function prepararConsultaMenu($opcion ='', $padreId=0)
    {
        $consultaSql2 = "call sp_control_menu(";
        $consultaSql2.="'".$opcion."',";
        $consultaSql2.="".$_SESSION['idusuario'].",";
        $consultaSql2.="".$padreId.")";
        //echo $consultaSql2;
        $this->result2 = mysqli_query($this->conexion,$consultaSql2);
    }
    function ejecutarConsultaRespuesta() {
        $respuesta = '';
        while ($fila = mysqli_fetch_array($this->result)) {
            $respuesta = $fila['respuesta'];
        }
        return $respuesta;
    }
    function getArrayPadres()
    {
        $datos = array();
        while ($fila = mysqli_fetch_array($this->result2)) {
            array_push($datos, array(
                "menuID" => $fila["Menu"],
                "menuDesc" => $fila["Nombre"],
                "menuIcono" => $fila["Icono"],
                "menuURL" => $fila["URL"]
            ));
        }
        return $datos;
    }
    function getArrayHijos()
    {
        $datos = array();
        while ($fila = mysqli_fetch_array($this->result2)) {
            array_push($datos, array(
                "menuID" => $fila["Menu"],
                "menuDesc" => $fila["Nombre"],
                "menuIcono" => $fila["Icono"],
                "menuURL" => $fila["URL"]
            ));
        }
        return $datos;
    }
    function mostrarMenu()
    {

        $this->cerrarAbrir();
        $this->prepararConsultaMenu('opc_obtenerMenuPadres', 0);
        $datosPadres = $this->getArrayPadres();
        //print_r($datosPadres);
        echo '<ul class="sidebar-nav">';
        for($i=0; $i<count($datosPadres); $i++)
        {
            if($datosPadres[$i]["menuURL"] != '0')
            {
                if($datosPadres[$i]["menuDesc"] === $this->param['menu'])
                    echo '<li class="active">';
                else
                    echo '<li class="">';
                echo '

    	$this->cerrarAbrir();
    	$this->prepararConsultaMenu('opc_obtenerMenuPadres', 0);
    	$datosPadres = $this->getArrayPadres();  
    	//print_r($datosPadres);  	
    	echo '<ul class="sidebar-nav">';
    	for($i=0; $i<count($datosPadres); $i++)
    	{    		    		
    		if($datosPadres[$i]["menuURL"] != '0')
    		{    			
    			if($datosPadres[$i]["menuDesc"] === $this->param['menu'])
    				echo '<li class="active">';
    			else
    				echo '<li class="">';

    			echo '

				        <a href="'.$datosPadres[$i]["menuURL"].'">
				          <div class="icon">
				            <i class="'.$datosPadres[$i]['menuIcono'].'"></i>
				          </div>
				          <div class="title">'.$datosPadres[$i]['menuDesc'].'</div>
				        </a>
				      </li>';
            }
            else
            {
                if($datosPadres[$i]["menuDesc"] === $this->param['menu'])
                    echo '<li class="dropdown active">';
                else
                    echo '<li class="dropdown ">';
                echo '
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				          <div class="icon">
				            <i class="'.$datosPadres[$i]['menuIcono'].'"></i>
				          </div>
				          <div class="title">'.$datosPadres[$i]['menuDesc'].'</div>
				        </a>
				        <div class="dropdown-menu">
          					<ul>';
                $this->cerrarAbrir();
                $this->prepararConsultaMenu('opc_obtenerMenuHijos', $datosPadres[$i]['menuID']);
                //echo $datosPadres[$i]['menuID'];
                $datosHijos = $this->getArrayHijos();
                for($j=0; $j<count($datosHijos);$j++)
                {
                    echo '<li><a href="'.$datosHijos[$j]["menuURL"].'">'.$datosHijos[$j]["menuDesc"].'</a></li>';
                }
                echo '		</ul>
				        </div>
				    </li>';

            }
        }
        echo '</ul>';

    		}
    	}
		echo '</ul>';

    }
    function login()
    {
        $this->prepararConsultaUsuario('opc_login_respuesta');
        $respuesta = $this->ejecutarConsultaRespuesta();
        //echo $respuesta;
        if($respuesta == '1')
        {
            $this->cerrarAbrir();
            $this->prepararConsultaUsuario('opc_login_listar');
            while($fila = mysqli_fetch_array($this->result))
            {
                $_SESSION['idusuario'] = $fila['idusuario'];
                $_SESSION['usuario']   = $fila['usuario'];
                $_SESSION['usuarioNIF']   = $fila['NIF'];
                $_SESSION['usuarioNombres'] = $fila['nombres'];
                $_SESSION['usuarioApellidos'] = $fila['apellidos'];
                $_SESSION['usuarioDashboard'] = $fila['dashboard'];
                $_SESSION['usuarioDashboardURL'] = $fila['dashboardURL'];
                $_SESSION['usuarioIdRol'] = $fila['idRol'];
                $_SESSION['usuarioRol'] = $fila['rol'];
                $_SESSION['usuarioImagen'] = $fila['usuarioImagen'];
                $tipo = $fila['idRol'];
            }
            $this->cargarDashboard();
            echo '1';
        }
        else
        {
            echo '2';
        }
    }
    function cargarDashboard() {

        $this->cerrarAbrir();
        $this->prepararConsultaDashboard('opc_cargar_dashboard');
        while($fila3 = mysqli_fetch_array($this->result3))
        {
            //echo $_SESSION['usuarioIdRol'];
            if($_SESSION['usuarioIdRol'] == '1')
            {
                $_SESSION['mundipackComisiones'] = $fila3['mundipackComisiones'];
                $_SESSION['mundipackSocios'] = $fila3['mundipackSocios'];
                $_SESSION['mundipackTravelers'] = $fila3['mundipackTravelers'];
            }
            else
            {
                if($_SESSION['usuarioIdRol'] == '2')
                {
                    $_SESSION['socioMontoVentas']   = $fila3['socioMontoVentas'];
                    $_SESSION['socioCantidadVentas']   = $fila3['socioCantidadVentas'];
                }
                else
                {
                    $_SESSION['travelerAcumulado'] = $fila3['travelerAcumulado'];
                    $_SESSION['travelerPaquete'] = $fila3['travelerPaquete'];
                    $_SESSION['travelerImportePaquete'] = $fila3['travelerImportePaquete'];
                    $_SESSION['travelerPorcentajePaquete'] = $fila3['travelerPorcentajePaquete'];
                }
            }
            echo '1';
        }
    }
    function listarUsuariosSocios() {
        $this->prepararConsultaUsuario('opc_usuarios_socios_listar');
        while($row = mysqli_fetch_row($this->result)){

    	$this->cerrarAbrir();
    	$this->prepararConsultaDashboard('opc_cargar_dashboard');    	
    	while($fila3 = mysqli_fetch_array($this->result3))
    	{      
    		//echo $_SESSION['usuarioIdRol'];
    		if($_SESSION['usuarioIdRol'] == '1')
    		{
    			$_SESSION['mundipackComisiones'] = $fila3['mundipackComisiones'];
				$_SESSION['mundipackSocios'] = $fila3['mundipackSocios'];
				$_SESSION['mundipackTravelers'] = $fila3['mundipackTravelers'];
    		}
    		else
    		{
    			if($_SESSION['usuarioIdRol'] == '2')
    			{
    				$_SESSION['socioMontoVentas']   = $fila3['socioMontoVentas'];
					$_SESSION['socioCantidadVentas']   = $fila3['socioCantidadVentas'];
    			}
    			else
    			{
    				$_SESSION['travelerAcumulado'] = $fila3['travelerAcumulado'];
					$_SESSION['travelerPaquete'] = $fila3['travelerPaquete'];
					$_SESSION['travelerImportePaquete'] = $fila3['travelerImportePaquete'];
					$_SESSION['travelerPorcentajePaquete'] = $fila3['travelerPorcentajePaquete'];
    			}
    		}
    		echo '1';
    	}        	        
	}



            echo '<tr>					
					<td style="font-size: 12px; height: 10px; width: 4%;">'.$row[0].'</td>					
					<td style="font-size: 12px; height: 10px; width: 20%;">'.$row[1].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[2].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[3].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[4].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[5].'</td>
					<td syle="height: 10px; width: 5%;">
					<a class="btn btn-link btn-xs col-md-offset-4"><span class="fa fa-edit" title="Editar" onclick="editar('.$row[0].');" /></span></a>
								
					</td>
					<td syle="height: 10px; width: 5%;">
						<a id="eliminar_usuario" class="btn btn-link btn-xs col-md-offset-4"><span class="fa fa-close" title="Eliminar" onclick="eliminar('.$row[0].');"/></span></a>				
					</td>					
					
				</tr>';
        }
    }
    function listarSocios() {
        $this->prepararConsultaUsuario('opc_socios_listar');
        while($row = mysqli_fetch_row($this->result)){

            echo '<tr>					
					<td style="font-size: 12px; height: 10px; width: 4%;">'.$row[0].'</td>					
					<td style="font-size: 12px; height: 10px; width: 20%;">'.$row[1].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[2].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[3].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[4].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[5].'</td>
					<td style="font-size: 12px; height: 10px; width: 15%;">'.$row[6].'</td>
					<td syle="height: 10px; width: 5%;">
					<a class="btn btn-link btn-xs col-md-offset-4"><span class="fa fa-edit" title="Editar" onclick="editar('.$row[0].');" /></span></a>	
					</td>
					<td syle="height: 10px; width: 5%;">
						<a id="eliminar_usuario" class="btn btn-link btn-xs col-md-offset-4"><span class="fa fa-close" title="Eliminar" onclick="eliminar('.$row[0].');"/></span></a>				
					</td>					
					
				</tr>';
        }
    }
    function nuevoSocio() {
        $this->prepararRegistroUsuario('opc_socio_registrar');
        echo 1;
    }
    function prepararRegistroUsuario($opcion)
    {
        $consultaSql = "call sp_gestionar_usuario(";
        $consultaSql.="'".$opcion."',";
        $consultaSql.="'".$this->param['param_nombres']."',";
        $consultaSql.="'".$this->param['param_paterno']."',";
        $consultaSql.="'".$this->param['param_materno']."',";
        $consultaSql.="'".$this->param['param_nombre']."',";
        $consultaSql.="'".$this->param['param_rubro']."',";
        $consultaSql.="'".$this->param['param_ruc']."',";
        $consultaSql.="'".$this->param['param_dni']."',";
        $consultaSql.="'".$this->param['param_direccion']."',";
        $consultaSql.="'".$this->param['param_celular']."',";
        $consultaSql.="'".$this->param['param_telefono']."',";
        $consultaSql.="'".$this->param['param_usuario']."',";
        $consultaSql.="'".$this->param['param_clave']."',";
        $consultaSql.="'".$this->param['param_web']."',";
        $consultaSql.="'".$this->param['param_email']."',";
        $consultaSql.="'".$this->param['param_id']."')";
        //echo $consultaSql;	// FALTA VER AKI EL REGISTRO PREGUNTAR A MILUSKA
        $this->result = mysqli_query($this->conexion,$consultaSql);
    }

    function mostrarUsuario() {
        $this->prepararEditarUsuario('opc_usuario_mostrar');
        $row = mysqli_fetch_row($this->result);
        echo json_encode($row);
    }
}
?>