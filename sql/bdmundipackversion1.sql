-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2017 a las 13:00:53
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdmundipack`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_administrador` (IN `ve_opcion` VARCHAR(20), IN `ve_socioNombreComercial` VARCHAR(150), IN `ve_socioRubro` VARCHAR(50), IN `ve_socioRUC` CHAR(11), IN `ve_socioDireccion` VARCHAR(200), IN `ve_socioTelefonoContacto` VARCHAR(10), IN `ve_socioTelefonoAtencion` VARCHAR(10), IN `ve_socioEmail` VARCHAR(100), IN `ve_socioRazonSocial` VARCHAR(200), IN `ve_socioNroCuenta` VARCHAR(30), IN `ve_socioContactoResponsable` VARCHAR(200), IN `ve_socioPorcentajeRetorno` INT, IN `ve_socioCategoria` INT, IN `ve_socioID` INT, IN `ve_viajeroID` INT, IN `ve_viajeroNombre` VARCHAR(100), IN `viajeroApellidos` VARCHAR(100), IN `ve_viajeroDNI` CHAR(8), IN `ve_viajeroDireccion` TEXT, IN `ve_viajeroNacimiento` DATE, IN `ve_viajeroTelefonoFijo` VARCHAR(10), IN `ve_viajeroTelefonoCelular` VARCHAR(10), IN `ve_viajeroEmail` VARCHAR(150), IN `ve_viajeroNroPasaporte` VARCHAR(20), IN `ve_viajeroAbierto` BOOLEAN)  NO SQL
BEGIN
    IF ve_opcion = 'opc_contar_socios' THEN   
       SELECT count(s.Socio) AS "total" FROM se_socio s WHERE Estado = 1;
    END IF;
    
    IF ve_opcion = 'opc_listar_socios' THEN
    	select s.Socio as socioID, s.NombreComercial as socioNombre,
        	r.Descripcion as socioRubro, s.RUC as socioRUC, s.PorcentajeRetorno as socioPorcentajeRetorno, s.Categoria as socioCategoria,
             s.Telefonocontacto as socioTelefonoContacto,
             s.RUC as socioRUC
        from se_socio s        
        	inner join se_rubro r on s.Rubro = r.Rubro
        where s.Estado = 1;     
    END IF;
    
    IF ve_opcion = 'opc_grabar_socio' THEN    	
    	INSERT INTO se_socio(RazonSocial, NombreComercial, Rubro, RUC, Direccion, TelefonoContacto, TelefonoAtencion, Email, NroCuenta, ContactoResponsable, PorcentajeRetorno, Categoria, Estado)
        	VALUES(ve_socioRazonSocial, ve_socioNombreComercial, ve_socioRubro, ve_socioRUC, ve_socioDireccion, ve_socioTelefonoContacto, ve_socioTelefonoAtencion, ve_socioEmail, ve_socioNroCuenta, ve_socioContactoResponsable, ve_socioPorcentajeRetorno, ve_socioCategoria, 1);                  
         set @idsocio = (SELECT Socio from se_socio where RUC = ve_socioRUC and Estado = 1);
         INSERT INTO se_usuario(Socio, Login, Password, FechaRegistro, Estado)
         	values(@idsocio, ve_socioRUC, md5('123456'), CURRENT_DATE(), 1);
         set @idusuario = (SELECT Usuario from se_usuario where Socio = @idsocio);
         INSERT INTO se_rolusuario(rol, usuario, estado)
         	VALUES(2, @idusuario, 1);
         select 1 as 'resultado';
    END IF;
    
    IF ve_opcion = 'opc_eliminar_socio' THEN
    	update se_socio set Estado = 0 where Socio = ve_socioID;
    END IF;
    
    IF ve_opcion = 'opc_habilitar_socio' THEN
    	update se_socio set Estado = 1 where RUC = ve_socioRUC;
    END IF;
    
    IF ve_opcion = 'opc_contar_viajeros' THEN   
       SELECT count(v.Viajero) AS 'total' FROM se_viajero v inner join se_persona p on p.Persona = v.Persona WHERE p.Estado = 1;
    END IF;

    IF ve_opcion = 'opc_listar_viajeros' THEN
      select v.Viajero as viajeroID, p.Nombres as viajeroNombre,
          p.Apellidos as viajeroApellidos, p.DNI as viajeroDNI, p.TelefonoMovil as viajeroCelular, v.NroPasaporte as viajeroNroPasaporte, 'Cuzco' as viajeroPaqueteObjetivo, 0 as viajeroAcumulado,
             1 as viajeroEstadoPago, (case when v.ViajeroAbierto = 0 THEN 'SÍ' ELSE 'NO' end) as viajeroAbierto
        from se_viajero v
          inner join se_persona p on v.Persona = p.Persona          
        where p.Estado = 1;     
    END IF;
	
    IF ve_opcion = 'opc_eliminar_viajero' THEN
    	set @idpersona = (select Persona from se_viajero
                         where Viajero = ve_viajeroID);
    	update se_persona set Estado = 0 where Persona = @idpersona;
    END IF;

	IF ve_opcion = 'opc_grabar_viajero' THEN
    	insert into se_persona(Nombres, Apellidos, DNI, Direccion, FechaNacimiento, TelefonoFijo, TelefonoMovil, Email, Estado) values (ve_viajeroNombre, viajeroApellidos, ve_viajeroDNI, ve_viajeroDireccion, ve_viajeroNacimiento, ve_viajeroTelefonoFijo, ve_viajeroTelefonoCelular, ve_viajeroEmail, 1);
        set @idpersona = (select Persona from se_persona where DNI = ve_viajeroDNI);
        insert into se_viajero(Persona, NroPasaporte, ViajeroAbierto) values(@idpersona, ve_viajeroNroPasaporte, ve_viajeroAbierto);
        INSERT INTO se_usuario(Persona, Login, Password, FechaRegistro, Estado)
         	values(@idpersona, ve_viajeroDNI, md5('123456'), CURRENT_DATE(), 1);
         set @idusuario = (SELECT Usuario from se_usuario where Persona = @idpersona);
         INSERT INTO se_rolusuario(rol, usuario, estado)
         	VALUES(3, @idusuario, 1);
        select 1 as 'resultado';
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_dashboard` (IN `ve_opcion` VARCHAR(30), IN `ve_usuarioIDrol` INT)  NO SQL
BEGIN

	IF ve_opcion = 'opc_cargar_dashboard' THEN
    	IF ve_usuarioIDRol = 1 THEN
        	select 0.0 as mundipackComisiones, 
            (select count(*) from se_socio
             	where Estado = 1) as mundipackSocios, 
            (select count(*) 
             	from se_viajero v 
             	inner join se_persona p on v.Persona = p.Persona
             where p.Estado = 1) as mundipackTravelers;
        END IF;
        IF ve_usuarioIDRol = 2 THEN
        	select 0.0 as socioMontoVentas, 
            0 as socioCantidadVentas;
        END IF;
        
        IF ve_usuarioIDRol = 3 THEN
        	select 0 as travelerAcumulado, 
            'Cuzco' as travelerPaquete,
            1000 as travelerImportePaquete,
            0 as travelerPorcentajePaquete;
        END IF;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_menu` (IN `opcion` VARCHAR(30), IN `usuarioId` INT, IN `menuId` INT)  NO SQL
BEGIN
	IF opcion = 'opc_obtenerMenuPadres' THEN
    	SELECT M.Menu, M.Nombre, 
        		M.Icono, IFNULL(M.URL, '0') as URL 
        FROM se_menu M
        	INNER JOIN se_permiso P on P.Menu = M.Menu
            INNER JOIN se_rol R on R.Rol = P.Rol
            INNER JOIN se_rolusuario RU on RU.Rol = R.Rol            
        WHERE M.Estado = 1 AND M.MenuPadre is null
        	AND RU.Usuario = usuarioId
        ORDER BY M.Orden;
    END IF;
    
    IF opcion = 'opc_obtenerMenuHijos' THEN
    	SELECT M.Menu, M.Nombre, 
        		M.Icono, IFNULL(M.URL, '0') as URL 
        FROM se_menu M
        	INNER JOIN se_permiso P on P.Menu = M.Menu
            INNER JOIN se_rol R on R.Rol = P.Rol
            INNER JOIN se_rolusuario RU on RU.Rol = R.Rol                    
        WHERE M.Estado = 1 AND M.MenuPadre = menuId
        	AND RU.Usuario = usuarioId
        ORDER BY M.Orden;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_usuario` (IN `opcion` VARCHAR(30), IN `usuario` VARCHAR(30), IN `password` CHAR(32))  NO SQL
BEGIN
	IF opcion='opc_login_respuesta' THEN
      SET @CORRECTO = (SELECT COUNT(*) 
          FROM  se_usuario usu
          WHERE 
            usu.Login = usuario AND
            usu.Password = password AND
            usu.Estado = 1);
          IF @CORRECTO>0 THEN
            SELECT '1' AS 'respuesta';
          ELSE
            SELECT 'Usuario o clave incorrectos' AS 'respuesta';
          END IF;
    END IF;

    IF opcion='opc_login_listar' THEN    
      (select u.Usuario as idusuario, u.Login as usuario, p.DNI as NIF, p.Nombres as nombres, p.Apellidos as apellidos, d.Nombre as dashboard, d.URL as dashboardURL,
r.Rol as idRol, r.Nombre as rol, u.Imagen as usuarioImagen
      	
          from se_usuario u 
            inner join se_persona p on p.Persona = u.Persona
            inner join se_rolusuario ru on ru.Usuario = u.Usuario
            inner join se_rol r on r.Rol = ru.Rol
            inner join se_dashboard d on d.Rol = r.Rol             
            where u.Login = usuario and u.Password = password)
     UNION
     	(select u.Usuario as idusuario, u.Login as usuario, s.RUC as NIF, s.RazonSocial as nombres, '' as apellidos, d.Nombre as dashboard, d.URL as dashboardURL,
r.Rol as idRol, r.Nombre as rol, u.Imagen as usuarioImagen
      	
          from se_usuario u 
            inner join se_socio s on s.Socio = u.Socio
            inner join se_rolusuario ru on ru.Usuario = u.Usuario
            inner join se_rol r on r.Rol = ru.Rol
            inner join se_dashboard d on d.Rol = r.Rol             
            where u.Login = usuario and u.Password = password);
     
     END IF;    
        
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_contador`
--

CREATE TABLE `se_contador` (
  `Contador` int(11) NOT NULL,
  `Viajero` int(11) NOT NULL,
  `MontoAcumulado` double NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_dashboard`
--

CREATE TABLE `se_dashboard` (
  `Dashboard` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Descripcion` varchar(60) NOT NULL,
  `Orden` int(11) NOT NULL,
  `URL` varchar(150) NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Rol` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_dashboard`
--

INSERT INTO `se_dashboard` (`Dashboard`, `Nombre`, `Descripcion`, `Orden`, `URL`, `Estado`, `Rol`) VALUES
(1, 'Administrador', 'Dashboard de consulta del administrador del portal Mundipack', 1, 'administrador_dashboard.php', b'1', 1),
(2, 'Socio', 'Dashboard de consulta del socio del portal Mundipack', 2, 'socio_dashboard.php', b'1', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_menu`
--

CREATE TABLE `se_menu` (
  `Menu` int(11) NOT NULL,
  `MenuPadre` int(11) DEFAULT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Orden` int(11) NOT NULL,
  `Icono` varchar(100) NOT NULL,
  `URL` varchar(100) DEFAULT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_menu`
--

INSERT INTO `se_menu` (`Menu`, `MenuPadre`, `Nombre`, `Orden`, `Icono`, `URL`, `Estado`) VALUES
(1, NULL, 'Dashboard', 1, 'fa fa-tachometer', '../dashboard/', b'1'),
(2, NULL, 'Administrador', 2, 'fa fa-user', NULL, b'1'),
(3, 2, 'Net Partners', 1, 'fa fa-tasks', '../administrador/socios.php', b'1'),
(4, 2, 'Travelers', 2, 'fa fa-suitcase', '../administrador/viajeros.php', b'1'),
(5, NULL, 'Gestion Financiera', 3, 'fa fa-money', NULL, b'1'),
(6, 5, 'Depositos Viajeros', 1, 'fa fa-paper-plane-o', '', b'1'),
(7, 5, 'Porcentaje Consumos', 2, 'fa fa-percent', '', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_movimiento`
--

CREATE TABLE `se_movimiento` (
  `Movimiento` int(11) NOT NULL,
  `TipoMovimiento` int(11) NOT NULL,
  `Socio` int(11) DEFAULT NULL,
  `Viajero` int(11) DEFAULT NULL,
  `FechaMovimiento` date NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_movimiento`
--

INSERT INTO `se_movimiento` (`Movimiento`, `TipoMovimiento`, `Socio`, `Viajero`, `FechaMovimiento`, `Estado`) VALUES
(1, 4, NULL, 1, '2017-06-10', 1),
(2, 4, NULL, 5, '2017-06-10', 1),
(3, 4, NULL, 6, '2017-06-10', 1),
(4, 4, NULL, 7, '2017-06-10', 1),
(5, 1, 11, NULL, '2017-06-10', 1),
(6, 1, 12, NULL, '2017-06-10', 1),
(7, 1, 13, NULL, '2017-06-10', 1),
(8, 2, 11, NULL, '2017-06-11', 1),
(9, 2, 12, NULL, '2017-06-13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_pagocuotasocio`
--

CREATE TABLE `se_pagocuotasocio` (
  `PagoCuotaSocio` int(11) NOT NULL,
  `Socio` int(11) NOT NULL,
  `NroOperacion` varchar(15) NOT NULL,
  `Monto` double NOT NULL,
  `FechaPago` date NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_pagocuotaviajero`
--

CREATE TABLE `se_pagocuotaviajero` (
  `PagoCuotaViajero` int(11) NOT NULL,
  `Viajero` int(11) NOT NULL,
  `NroOperacion` varchar(15) NOT NULL,
  `MontoCuota` double NOT NULL,
  `FechaPago` date NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_paquete`
--

CREATE TABLE `se_paquete` (
  `Paquete` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text NOT NULL,
  `Precio` double NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_paquetes`
--

CREATE TABLE `se_paquetes` (
  `Paquete` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Descripcion` text NOT NULL,
  `Precio` double NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_permiso`
--

CREATE TABLE `se_permiso` (
  `Permiso` int(11) NOT NULL,
  `Menu` int(11) NOT NULL,
  `Rol` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_permiso`
--

INSERT INTO `se_permiso` (`Permiso`, `Menu`, `Rol`, `Estado`) VALUES
(1, 1, 1, b'1'),
(2, 2, 1, b'1'),
(3, 3, 1, b'1'),
(4, 4, 1, b'1'),
(5, 5, 1, b'1'),
(8, 6, 1, b'1'),
(9, 7, 1, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_persona`
--

CREATE TABLE `se_persona` (
  `Persona` int(11) NOT NULL,
  `Nombres` varchar(150) NOT NULL,
  `Apellidos` varchar(150) NOT NULL,
  `DNI` char(8) NOT NULL,
  `Direccion` text NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `TelefonoFijo` varchar(10) DEFAULT NULL,
  `TelefonoMovil` varchar(10) DEFAULT NULL,
  `Email` varchar(150) NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_persona`
--

INSERT INTO `se_persona` (`Persona`, `Nombres`, `Apellidos`, `DNI`, `Direccion`, `FechaNacimiento`, `TelefonoFijo`, `TelefonoMovil`, `Email`, `Estado`) VALUES
(1, 'Alvaro Alfredo', 'Vargas Otiniano', '70673610', '', '1993-09-10', '04401498', '984799195', 'alvaro.vargas.1487@gmail.com', b'1'),
(2, 'Marleny', 'Otiniano Villanueva', '17396402', '', '1960-05-01', NULL, '978203741', 'marleny1487@gmail.com', b'1'),
(3, 'Romer Angel', 'Vargas Otiniano', '92830175', '', '2007-05-01', NULL, '937201862', 'romo077@gmail.com', b'1'),
(12, 'Maria', 'Salirrosas Haro', '10192831', 'Manco Inca 723', '1954-01-20', '044401421', '987483201', 'rosaflora@gmail.com', b'1'),
(10, 'Jorge', 'Sandoval Rodrigo', '72937490', 'Jr. Union 1498', '1991-04-02', '044728393', '987203946', 'jsandoval@gmail.com', b'1'),
(11, 'Rosa Flor', 'Villanueva Zavaleta', '80192837', 'Manco Inca 723', '1954-01-20', '044401421', '987483201', 'rosaflora@gmail.com', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_rol`
--

CREATE TABLE `se_rol` (
  `Rol` int(11) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Descripcion` varchar(60) NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_rol`
--

INSERT INTO `se_rol` (`Rol`, `Nombre`, `Descripcion`, `Estado`) VALUES
(1, 'Administrador', 'Administrador de la plataforma Mundipack', b'1'),
(2, 'Socio', 'Socio cliente de Mundipack', b'1'),
(3, 'Viajero', 'Viajero cliente de Mundipack', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_rolusuario`
--

CREATE TABLE `se_rolusuario` (
  `RolUsuario` int(11) NOT NULL,
  `Rol` int(11) NOT NULL,
  `Usuario` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_rolusuario`
--

INSERT INTO `se_rolusuario` (`RolUsuario`, `Rol`, `Usuario`, `Estado`) VALUES
(1, 1, 1, b'1'),
(2, 2, 2, b'1'),
(3, 2, 3, b'1'),
(4, 3, 5, b'1'),
(5, 2, 6, b'1'),
(6, 3, 7, b'1'),
(7, 3, 8, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_rubro`
--

CREATE TABLE `se_rubro` (
  `Rubro` int(11) NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_rubro`
--

INSERT INTO `se_rubro` (`Rubro`, `Descripcion`, `Estado`) VALUES
(1, 'Restaurante', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_socio`
--

CREATE TABLE `se_socio` (
  `Socio` int(11) NOT NULL,
  `RazonSocial` varchar(150) NOT NULL,
  `NombreComercial` varchar(150) NOT NULL,
  `Rubro` int(11) NOT NULL,
  `RUC` char(11) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `TelefonoContacto` varchar(10) DEFAULT NULL,
  `TelefonoAtencion` varchar(10) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `NroCuenta` varchar(30) NOT NULL,
  `ContactoResponsable` varchar(200) NOT NULL,
  `PorcentajeRetorno` int(11) NOT NULL,
  `Categoria` int(11) NOT NULL,
  `FechaPago` date DEFAULT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_socio`
--

INSERT INTO `se_socio` (`Socio`, `RazonSocial`, `NombreComercial`, `Rubro`, `RUC`, `Direccion`, `TelefonoContacto`, `TelefonoAtencion`, `Email`, `NroCuenta`, `ContactoResponsable`, `PorcentajeRetorno`, `Categoria`, `FechaPago`, `Estado`) VALUES
(12, 'Restaurante PEPI S.A.C.', 'Restaurante Pepito', 1, '12345678901', 'DirecciÃ³n del restaurante de Pepito', '044401498', '044401566', 'rpepito@gmail.com', '192843049394940', 'Pepe Aguilar Rodriguez', 12, 4, NULL, b'0'),
(11, 'kjbkijokj', 'kjhfijnpoihiu', 1, '87988698089', 'kjbkboiuhioh oiuh\r\n iuoh oih13oi oh o1', '044829384', '019283745', 'email@kjbkj.com', '2093840434', 'jsbnd lkdndo\r\n kfukfuhf diubff', 10, 0, NULL, b'0'),
(13, 'Restaurante DoÃ±a Peta S.A.C.', 'DoÃ±a Peta', 1, '12345678901', 'JosÃ© Olaya 1487', '044782937', '979302647', 'contacto@donapeta.com', '910293848393', 'Peta Rodriguez AlcÃ¡ntara', 10, 5, NULL, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_tipomovimiento`
--

CREATE TABLE `se_tipomovimiento` (
  `TipoMovimiento` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_tipomovimiento`
--

INSERT INTO `se_tipomovimiento` (`TipoMovimiento`, `Descripcion`) VALUES
(1, 'Nuevo Net Partner'),
(2, 'Baja de Net Partner'),
(3, 'Reactivacion de Net Partner'),
(4, 'Nuevo Traveler'),
(5, 'Baja de Traveler'),
(6, 'Reactivacion de Traveler');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_transaccion`
--

CREATE TABLE `se_transaccion` (
  `Transaccion` int(11) NOT NULL,
  `Serie` varchar(5) NOT NULL,
  `Numero` varchar(7) NOT NULL,
  `Viajero` int(11) DEFAULT NULL,
  `Socio` int(11) DEFAULT NULL,
  `Importe` double NOT NULL,
  `FechaTransaccion` date NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_usuario`
--

CREATE TABLE `se_usuario` (
  `Usuario` int(11) NOT NULL,
  `Persona` int(11) DEFAULT NULL,
  `Socio` int(11) DEFAULT NULL,
  `Login` varchar(20) NOT NULL,
  `Password` char(32) NOT NULL,
  `FechaRegistro` datetime NOT NULL,
  `Imagen` varchar(200) DEFAULT NULL,
  `FechaCese` datetime DEFAULT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_usuario`
--

INSERT INTO `se_usuario` (`Usuario`, `Persona`, `Socio`, `Login`, `Password`, `FechaRegistro`, `Imagen`, `FechaCese`, `Estado`) VALUES
(1, 1, NULL, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2017-04-14 00:00:00', 'view/default/assets/images/users/admin_profile.jpg', NULL, b'1'),
(2, NULL, 11, '87988698089', 'e10adc3949ba59abbe56e057f20f883e', '2017-05-31 00:00:00', NULL, NULL, b'1'),
(3, NULL, 12, '1234567890', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-01 00:00:00', NULL, NULL, b'1'),
(4, NULL, 9, '72937490', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-02 00:00:00', NULL, NULL, b'1'),
(5, 10, NULL, '72937490', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-02 00:00:00', NULL, NULL, b'1'),
(6, NULL, 13, '12345678901', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-11 00:00:00', NULL, NULL, b'1'),
(7, 11, NULL, '80192837', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-11 00:00:00', NULL, NULL, b'1'),
(8, 12, NULL, '10192831', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-11 00:00:00', NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_viajero`
--

CREATE TABLE `se_viajero` (
  `Viajero` int(11) NOT NULL,
  `Persona` int(11) NOT NULL,
  `NroPasaporte` varchar(20) DEFAULT NULL,
  `ViajeroAbierto` bit(1) NOT NULL,
  `FechaPago` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_viajero`
--

INSERT INTO `se_viajero` (`Viajero`, `Persona`, `NroPasaporte`, `ViajeroAbierto`, `FechaPago`) VALUES
(1, 2, '1234123412341234', b'0', NULL),
(5, 10, '91028489374', b'1', NULL),
(6, 11, '192038491023', b'1', NULL),
(7, 12, '192038491000', b'0', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_viajeropaquetecomprado`
--

CREATE TABLE `se_viajeropaquetecomprado` (
  `ViajeroPaqueteComprado` int(11) NOT NULL,
  `Paquete` int(11) NOT NULL,
  `Viajero` int(11) NOT NULL,
  `ViajeroPaquetesPosibles` int(11) NOT NULL,
  `Monto` double NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_viajeropaquetesposibles`
--

CREATE TABLE `se_viajeropaquetesposibles` (
  `ViajeroPaquetesPosibles` int(11) NOT NULL,
  `Viajero` int(11) NOT NULL,
  `Paquete` int(11) NOT NULL,
  `Prioridad` int(11) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `se_contador`
--
ALTER TABLE `se_contador`
  ADD PRIMARY KEY (`Contador`),
  ADD KEY `Viajero` (`Viajero`);

--
-- Indices de la tabla `se_dashboard`
--
ALTER TABLE `se_dashboard`
  ADD PRIMARY KEY (`Dashboard`);

--
-- Indices de la tabla `se_menu`
--
ALTER TABLE `se_menu`
  ADD PRIMARY KEY (`Menu`);

--
-- Indices de la tabla `se_movimiento`
--
ALTER TABLE `se_movimiento`
  ADD PRIMARY KEY (`Movimiento`),
  ADD KEY `TipoMovimiento` (`TipoMovimiento`);

--
-- Indices de la tabla `se_pagocuotasocio`
--
ALTER TABLE `se_pagocuotasocio`
  ADD PRIMARY KEY (`PagoCuotaSocio`),
  ADD KEY `Socio` (`Socio`);

--
-- Indices de la tabla `se_pagocuotaviajero`
--
ALTER TABLE `se_pagocuotaviajero`
  ADD PRIMARY KEY (`PagoCuotaViajero`),
  ADD KEY `Viajero` (`Viajero`);

--
-- Indices de la tabla `se_paquete`
--
ALTER TABLE `se_paquete`
  ADD PRIMARY KEY (`Paquete`);

--
-- Indices de la tabla `se_paquetes`
--
ALTER TABLE `se_paquetes`
  ADD PRIMARY KEY (`Paquete`);

--
-- Indices de la tabla `se_permiso`
--
ALTER TABLE `se_permiso`
  ADD PRIMARY KEY (`Permiso`),
  ADD KEY `Menu` (`Menu`),
  ADD KEY `Rol` (`Rol`);

--
-- Indices de la tabla `se_persona`
--
ALTER TABLE `se_persona`
  ADD PRIMARY KEY (`Persona`);

--
-- Indices de la tabla `se_rol`
--
ALTER TABLE `se_rol`
  ADD PRIMARY KEY (`Rol`);

--
-- Indices de la tabla `se_rolusuario`
--
ALTER TABLE `se_rolusuario`
  ADD PRIMARY KEY (`RolUsuario`),
  ADD KEY `Rol` (`Rol`);

--
-- Indices de la tabla `se_rubro`
--
ALTER TABLE `se_rubro`
  ADD PRIMARY KEY (`Rubro`);

--
-- Indices de la tabla `se_socio`
--
ALTER TABLE `se_socio`
  ADD PRIMARY KEY (`Socio`);

--
-- Indices de la tabla `se_tipomovimiento`
--
ALTER TABLE `se_tipomovimiento`
  ADD PRIMARY KEY (`TipoMovimiento`);

--
-- Indices de la tabla `se_transaccion`
--
ALTER TABLE `se_transaccion`
  ADD PRIMARY KEY (`Transaccion`),
  ADD KEY `Socio` (`Socio`),
  ADD KEY `Viajero` (`Viajero`);

--
-- Indices de la tabla `se_usuario`
--
ALTER TABLE `se_usuario`
  ADD PRIMARY KEY (`Usuario`),
  ADD KEY `Persona` (`Persona`),
  ADD KEY `Socio` (`Socio`);

--
-- Indices de la tabla `se_viajero`
--
ALTER TABLE `se_viajero`
  ADD PRIMARY KEY (`Viajero`);

--
-- Indices de la tabla `se_viajeropaquetecomprado`
--
ALTER TABLE `se_viajeropaquetecomprado`
  ADD PRIMARY KEY (`ViajeroPaqueteComprado`),
  ADD KEY `Paquete` (`Paquete`),
  ADD KEY `Viajero` (`Viajero`),
  ADD KEY `ViajeroPaquetesPosibles` (`ViajeroPaquetesPosibles`);

--
-- Indices de la tabla `se_viajeropaquetesposibles`
--
ALTER TABLE `se_viajeropaquetesposibles`
  ADD PRIMARY KEY (`ViajeroPaquetesPosibles`),
  ADD KEY `Viajero` (`Viajero`),
  ADD KEY `Paquete` (`Paquete`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `se_contador`
--
ALTER TABLE `se_contador`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_dashboard`
--
ALTER TABLE `se_dashboard`
  MODIFY `Dashboard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `se_menu`
--
ALTER TABLE `se_menu`
  MODIFY `Menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `se_movimiento`
--
ALTER TABLE `se_movimiento`
  MODIFY `Movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `se_pagocuotasocio`
--
ALTER TABLE `se_pagocuotasocio`
  MODIFY `PagoCuotaSocio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_pagocuotaviajero`
--
ALTER TABLE `se_pagocuotaviajero`
  MODIFY `PagoCuotaViajero` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_paquete`
--
ALTER TABLE `se_paquete`
  MODIFY `Paquete` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_paquetes`
--
ALTER TABLE `se_paquetes`
  MODIFY `Paquete` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_permiso`
--
ALTER TABLE `se_permiso`
  MODIFY `Permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `se_persona`
--
ALTER TABLE `se_persona`
  MODIFY `Persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `se_rol`
--
ALTER TABLE `se_rol`
  MODIFY `Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `se_rolusuario`
--
ALTER TABLE `se_rolusuario`
  MODIFY `RolUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `se_rubro`
--
ALTER TABLE `se_rubro`
  MODIFY `Rubro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `se_socio`
--
ALTER TABLE `se_socio`
  MODIFY `Socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `se_tipomovimiento`
--
ALTER TABLE `se_tipomovimiento`
  MODIFY `TipoMovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `se_transaccion`
--
ALTER TABLE `se_transaccion`
  MODIFY `Transaccion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_usuario`
--
ALTER TABLE `se_usuario`
  MODIFY `Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `se_viajero`
--
ALTER TABLE `se_viajero`
  MODIFY `Viajero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `se_viajeropaquetecomprado`
--
ALTER TABLE `se_viajeropaquetecomprado`
  MODIFY `ViajeroPaqueteComprado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_viajeropaquetesposibles`
--
ALTER TABLE `se_viajeropaquetesposibles`
  MODIFY `ViajeroPaquetesPosibles` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
