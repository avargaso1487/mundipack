-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-07-2017 a las 05:29:05
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jenner_bdmundipack`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_socio` (IN `opcion` VARCHAR(300), IN `p_dni` VARCHAR(8))  NO SQL
BEGIN
	IF opcion = 'opc_buscar_socio' THEN
		SET @EXISTE = (SELECT count(*) FROM se_viajero V INNER JOIN se_persona P ON P.Persona = V.Persona WHERE P.DNI = p_dni);
        IF @EXISTE > 0 THEN
			SELECT V.Viajero AS SOCIOID, concat(P.Nombres,' ',P.Apellidos) AS SOCIO FROM se_viajero V INNER JOIN se_persona P ON P.Persona = V.Persona WHERE P.DNI = p_dni;
        ELSE
			SELECT '0' AS SOCIOID;
        END IF;
	END IF;    
    
    IF opcion = 'opc_obtener_venta' THEN
		select t.Transaccion, t.Serie, t.Numero, t.Importe, t.FechaTransaccion, t.TipoDocumento, p.DNI, CONCAT(p.Nombres, ' ', Apellidos), t.Socio from se_transaccion t inner join se_viajero v on v.Viajero = t.Viajero inner join se_persona p on p.Persona = v.Persona where t.Transaccion = p_dni;
	END IF; 
    
    IF opcion = 'opc_contar_socios' THEN
		SELECT COUNT(*) as total FROM se_socio WHERE Estado = 1;
	END IF; 
    
    IF opcion = 'opc_get_four_all_socios' THEN
		SELECT 
			S.NombreComercial AS NOMBRE, 
			S.TelefonoAtencion AS TELEFONO, 
			S.CartaPresentacion AS CARTA_PRESENTACION, 
			S.Direccion AS DIRECCION,
			U.Imagen AS FOTO_PERFIL
		FROM se_socio S
			LEFT JOIN se_usuario U ON U.Socio = S.Socio
		WHERE S.Estado = 1 LIMIT 4;
	END IF; 	  
    
    IF opcion = 'opc_get_all_socios' THEN
		SELECT 
			S.NombreComercial AS NOMBRE, 
			S.TelefonoAtencion AS TELEFONO, 
			S.CartaPresentacion AS CARTA_PRESENTACION, 
			S.Direccion AS DIRECCION,
			U.Imagen AS FOTO_PERFIL
		FROM se_socio S
			LEFT JOIN se_usuario U ON U.Socio = S.Socio
		WHERE S.Estado = 1;
	END IF; 
    
    IF opcion = 'opc_contar_ofertas' THEN
		SELECT COUNT(*) as total FROM se_promocion P WHERE P.Estado = 1;
	END IF; 
    
    IF opcion = 'opc_get_four_all_ofertas' THEN
		SELECT 
			P.Descripcion AS DESCRIPCION,
			P.FechaInicio AS INICIO,
			P.FechaFin AS FIN,
			S.NombreComercial AS SOCIO,
			S.Direccion AS DIRECCION,
			S.TelefonoAtencion AS TELEFONO,
			P.Imagen AS IMAGEN,
            IF( P.Porcentaje = 1,'SI','NO') AS RETORNO
		FROM se_promocion P  
		INNER JOIN se_socio S ON S.Socio = P.Socio
		WHERE P.Estado = 1  ORDER BY P.FechaInicio DESC LIMIT 4;
	END IF; 
    
    IF opcion = 'opc_get_all_ofertas' THEN
		SELECT 
			P.Descripcion AS DESCRIPCION,
			P.FechaInicio AS INICIO,
			P.FechaFin AS FIN,
			S.NombreComercial AS SOCIO,
			S.Direccion AS DIRECCION,
			S.TelefonoAtencion AS TELEFONO,
			P.Imagen AS IMAGEN,
            IF( P.Porcentaje = 1,'SI','NO') AS RETORNO
		FROM se_promocion P  
		INNER JOIN se_socio S ON S.Socio = P.Socio
		WHERE P.Estado = 1 ORDER BY P.FechaInicio;
	END IF; 
    
    IF opcion = 'opc_listar_pagos_traveler' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
		SELECT PagoCuotaViajero, NroOperacion, MontoCuota, FechaPago, Estado FROM se_pagocuotaviajero WHERE Viajero = @VIAJERO;
	END IF;  
    
    IF opcion = 'opc_contar_pagos_traveler' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
		SELECT COUNT(*) AS total FROM se_pagocuotaviajero WHERE Estado = 1 AND Viajero = @VIAJERO;
	END IF; 
    
    IF opcion = 'opc_contar_traveler_abierto' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SELECT 
			COUNT(*) as total
		FROM se_viajero V 
			INNER JOIN se_persona P ON P.Persona = V.Persona WHERE P.Persona <> @PERSONA;
	END IF; 
    
    IF opcion = 'opc_get_four_travelers_abiertos' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SELECT 
			CONCAT(P.Nombres,' ',P.Apellidos) AS TRAVELER,
			P.TelefonoFijo AS TELEFONO,
			P.Email AS EMAIL,
			'' AS PAQUETE,
            Imagen AS IMAGEN
		FROM se_viajero V 
			INNER JOIN se_persona P ON P.Persona = V.Persona 
			INNER JOIN se_usuario U ON U.Persona = P.Persona
		WHERE P.Persona <> @PERSONA AND V.ViajeroAbierto = 1 LIMIT 4;
	END IF; 
    
    IF opcion = 'opc_get_travelers_abiertos' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SELECT 
			CONCAT(P.Nombres,' ',P.Apellidos) AS TRAVELER,
			P.TelefonoFijo AS TELEFONO,
			P.Email AS EMAIL,
			'' AS PAQUETE,
            Imagen AS IMAGEN
		FROM se_viajero V 
			INNER JOIN se_persona P ON P.Persona = V.Persona 
			INNER JOIN se_usuario U ON U.Persona = P.Persona
		WHERE P.Persona <> @PERSONA AND V.ViajeroAbierto = 1;
	END IF; 
    
    IF opcion = 'opc_obtener_comision' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
        SELECT IFNULL(MontoAcumulado,0) as total FROM se_contador WHERE Viajero = @VIAJERO AND Estado = 1;
	END IF; 
    
    IF opcion = 'opc_dashboard_total_socios' THEN		
        SELECT COUNT(*) as total FROM se_socio WHERE Estado = 1;
	END IF; 
    
    IF opcion = 'opc_dashboard_total_viajeros' THEN		
        SELECT COUNT(*) as total FROM se_viajero;
	END IF; 	
    
    IF opcion = 'opc_dashboard_ultimos_movimientos' THEN		
        SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
        
        SELECT 'PAGO DE COUTAS' AS MOVIMIENTO, PV.MontoCuota AS MONTO, IF(PV.Estado = 1,'REALIZADO','') AS ESTADO, PV.FechaPago AS FECHA, 'PAGO COUTA' AS TIPO_MOVIMIENTO FROM se_pagocuotaviajero PV
			INNER JOIN se_viajero V ON V.Viajero = PV.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
		WHERE PV.Estado = 1 AND PV.Viajero = @VIAJERO
		UNION ALL
		SELECT 'GASTOS EN NET PARTNERS' AS MOVIMIENTO, T.Importe AS MONTO, 
			CASE T.Estado WHEN '1' THEN 'CONFIRMADO' WHEN '0' THEN 'PENDIENTE' WHEN '2' THEN 'RECHAZADO' END
			AS ESTADO, T.FechaTransaccion AS FECHA, 'COMPRAS' AS TIPO_MOVIMIENTO FROM se_transaccion T
			INNER JOIN se_viajero V ON V.Viajero = T.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
		WHERE V.Viajero = @VIAJERO
		ORDER BY FECHA DESC LIMIT 13;
	
	END IF; 	
    
    IF opcion = 'opc_contar_transacciones_traveler' THEN	
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
        
        SELECT count(*) as total FROM se_transaccion T
			INNER JOIN se_viajero V ON V.Viajero = T.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
		WHERE V.Viajero = @VIAJERO;
	END IF; 
    
    IF opcion = 'opc_listar_pagos_partner' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_dni);		
		SELECT PagoCuotaSocio, NroOperacion, Monto, FechaPago, Estado FROM se_pagocuotasocio WHERE Socio = @SOCIO;
	END IF; 
    
    IF opcion = 'opc_contar_pagos_partner' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_dni);
		SELECT COUNT(*) AS total FROM se_pagocuotasocio WHERE Socio = @SOCIO;
	END IF; 
    
    IF opcion = 'opc_listar_pagos_partner_pendientes' THEN		
		SELECT 
			S.RazonSocial,
			PS.PagoCuotaSocio, 
            PS.NroOperacion, 
            PS.Monto, 
            PS.FechaPago, 
            PS.Estado 
		FROM se_pagocuotasocio PS
        INNER JOIN se_socio S ON S.Socio = PS.Socio;
	END IF;
    
    IF opcion = 'opc_contar_pagos_partner_pendientes' THEN		
		SELECT COUNT(*) AS total FROM se_pagocuotasocio;
	END IF; 
    
    
    
    
    IF opcion = 'opc_listar_pagos_traveler_pendientes' THEN
		
		SELECT 
			CONCAT(P.Nombres, ' ', P.Apellidos) AS Traveler,
			PV.PagoCuotaViajero, 
            PV.NroOperacion, 
            PV.MontoCuota, 
            PV.FechaPago, 
            PV.Estado 
		FROM se_pagocuotaviajero PV
        INNER JOIN se_viajero V ON V.Viajero = PV.Viajero
        INNER JOIN se_persona P ON P.Persona = V.Persona;
	END IF; 
    
    IF opcion = 'opc_contar_pagos_traveler_pendientes' THEN		
		SELECT COUNT(*) AS total FROM se_pagocuotaviajero;
	END IF; 
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_administrador` (IN `ve_opcion` VARCHAR(20), IN `ve_socioNombreComercial` VARCHAR(150), IN `ve_socioRubro` VARCHAR(50), IN `ve_socioRUC` CHAR(11), IN `ve_socioDireccion` VARCHAR(200), IN `ve_socioTelefonoContacto` VARCHAR(10), IN `ve_socioTelefonoAtencion` VARCHAR(10), IN `ve_socioEmail` VARCHAR(100), IN `ve_socioRazonSocial` VARCHAR(200), IN `ve_socioNroCuenta` VARCHAR(30), IN `ve_socioContactoResponsable` VARCHAR(200), IN `ve_socioPorcentajeRetorno` INT, IN `ve_socioPrecioDesde` DOUBLE, IN `ve_socioID` INT, IN `ve_viajeroID` INT, IN `ve_viajeroNombre` VARCHAR(100), IN `viajeroApellidos` VARCHAR(100), IN `ve_viajeroDNI` CHAR(8), IN `ve_viajeroDireccion` TEXT, IN `ve_viajeroNacimiento` DATE, IN `ve_viajeroTelefonoFijo` VARCHAR(10), IN `ve_viajeroTelefonoCelular` VARCHAR(10), IN `ve_viajeroEmail` VARCHAR(150), IN `ve_viajeroNroPasaporte` VARCHAR(20), IN `ve_viajeroAbierto` BOOLEAN)  NO SQL
BEGIN
    IF ve_opcion = 'opc_contar_socios' THEN   
       SELECT count(s.Socio) AS "total" FROM se_socio s WHERE Estado = 1;
    END IF;
    
    IF ve_opcion = 'opc_listar_socios' THEN
    	select s.Socio as socioID, s.NombreComercial as socioNombre,
        	r.Descripcion as socioRubro, s.RUC as socioRUC, s.PorcentajeRetorno as socioPorcentajeRetorno, s.PrecioDesde as socioPrecioDesde,
             s.Telefonocontacto as socioTelefonoContacto,
             s.RUC as socioRUC, s.PrecioDesde as socioPrecioDesde
        from se_socio s        
        	inner join se_rubro r on s.Rubro = r.Rubro
        where s.Estado = 1;     
    END IF;
    
    IF ve_opcion = 'opc_grabar_socio' THEN    	
    	INSERT INTO se_socio(RazonSocial, NombreComercial, Rubro, RUC, Direccion, TelefonoContacto, TelefonoAtencion, Email, NroCuenta, ContactoResponsable, PorcentajeRetorno, PrecioDesde, Estado)
        	VALUES(ve_socioRazonSocial, ve_socioNombreComercial, ve_socioRubro, ve_socioRUC, ve_socioDireccion, ve_socioTelefonoContacto, ve_socioTelefonoAtencion, ve_socioEmail, ve_socioNroCuenta, ve_socioContactoResponsable, ve_socioPorcentajeRetorno, ve_socioPrecioDesde, 1);                  
         set @idsocio = (SELECT Socio from se_socio where RUC = ve_socioRUC and Estado = 1);
         INSERT INTO se_usuario(Socio, Login, Password, FechaRegistro, Imagen, Estado)
         	values(@idsocio, ve_socioRUC, md5('123456'), CURRENT_DATE(), 'view/default/assets/images/users/netpartner_default_profile.jpg', 1);
         set @idusuario = (SELECT Usuario from se_usuario where Socio = @idsocio);
         INSERT INTO se_rolusuario(rol, usuario, estado)
         	VALUES(2, @idusuario, 1);
         INSERT INTO se_movimiento(Tipomovimiento, Socio, FechaMovimiento, Estado) values(1, @idsocio, now(), 1);
         select 1 as 'resultado';
    END IF;
    
    IF ve_opcion = 'opc_eliminar_socio' THEN
    	update se_socio set Estado = 0 where Socio = ve_socioID;
        INSERT INTO se_movimiento(Tipomovimiento, Socio, FechaMovimiento, Estado) values(2, ve_socioID, now(), 1);
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
        INSERT INTO se_movimiento(Tipomovimiento, Socio, FechaMovimiento, Estado) values(6, ve_viajeroID, now(), 1);
    END IF;

    IF ve_opcion = 'opc_grabar_viajero' THEN
    	insert into se_persona(Nombres, Apellidos, DNI, Direccion, FechaNacimiento, TelefonoFijo, TelefonoMovil, Email, Estado) values (ve_viajeroNombre, viajeroApellidos, ve_viajeroDNI, ve_viajeroDireccion, ve_viajeroNacimiento, ve_viajeroTelefonoFijo, ve_viajeroTelefonoCelular, ve_viajeroEmail, 1);
        set @idpersona = (select Persona from se_persona where DNI = ve_viajeroDNI);
        insert into se_viajero(Persona, NroPasaporte, ViajeroAbierto) values(@idpersona, ve_viajeroNroPasaporte, ve_viajeroAbierto);
        INSERT INTO se_usuario(Persona, Login, Password, FechaRegistro, Imagen, Estado)
         	values(@idpersona, ve_viajeroDNI, md5('123456'), CURRENT_DATE(), 'view/default/assets/images/users/traveler_default_profile.png', 1);
         set @idusuario = (SELECT Usuario from se_usuario where Persona = @idpersona);
         INSERT INTO se_rolusuario(rol, usuario, estado)
         	VALUES(3, @idusuario, 1);
         set @idviajero = (SELECT Viajero from se_viajero where Persona = @idpersona);
         INSERT INTO se_movimiento(Tipomovimiento, Socio, FechaMovimiento, Estado) values(5, @idviajero, now(), 1);
        select 1 as 'resultado';
    END IF;

    IF ve_opcion = 'opc_get_NP' THEN    
        select s.RazonSocial, s.NombreComercial, r.Descripcion as Rubro, u.Imagen, s.RUC, s.Direccion,
           s.TelefonoContacto, s.TelefonoAtencion, s.Email, s.NroCuenta, s.ContactoResponsable,
           s.PorcentajeRetorno, s.PrecioDesde, s.DiaPago
           from se_socio s
               inner join se_rubro r on r.Rubro = s.Rubro
               inner join se_usuario u on u.Socio = s.Socio
           where s.Socio = ve_socioID;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_combos` (IN `opcion` VARCHAR(30))  NO SQL
BEGIN
	IF opcion = 'opc_listar_tipo_documento' THEN
		SELECT * FROM se_tipodocumento;
	END IF; 
    IF opcion = 'opc_listar_socios' THEN
		SELECT * FROM se_socio;
	END IF;
    IF opcion = 'opc_listar_traveler' THEN		
		SELECT V.Viajero, CONCAT(P.Nombres,' ', P.Apellidos)
		FROM se_viajero V 
		INNER JOIN se_persona P ON P.Persona = V.Persona;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_ofertas` (IN `opcion` VARCHAR(300), IN `p_descripcion` VARCHAR(300), IN `p_fechaInicio` DATE, IN `p_fechaFin` DATE, IN `p_stock` VARCHAR(11), IN `p_ruta` VARCHAR(200), IN `p_usuario` INT, IN `p_codigo` VARCHAR(5), IN `p_porcentaje` VARCHAR(1))  NO SQL
BEGIN
	IF opcion = 'opc_add_oferta' THEN
		SET @SOCIOID = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		INSERT INTO se_promocion (Descripcion, FechaInicio, FechaFin, Stock, FechaIngreso, Socio, Imagen, Estado, Porcentaje) 
			VALUES (p_descripcion, p_fechaInicio, p_fechaFin, p_stock, curdate(), @SOCIOID, p_ruta, 1, p_porcentaje);            
    END IF;
    IF opcion = 'opc_total_ofertas' THEN
		SET @SOCIOID = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT COUNT(*) AS total FROM se_promocion WHERE Socio = @SOCIOID;
	END IF; 
    IF opcion = 'opc_listar_oferta' THEN
		SET @SOCIOID = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT 
			Promocion AS PROMO_ID,
            Descripcion AS DESCRIPCION,
            FechaInicio AS FECHA_INICIO,
            FechaFin AS FECHA_FIN,
            Stock AS STOCK,
            Imagen AS IMAGEN,
            Estado AS ESTADO,
            Porcentaje AS PORCENTAJE
		FROM se_promocion WHERE Socio = @SOCIOID;
	END IF;
    IF opcion = 'opc_eliminar_oferta' THEN		
		UPDATE se_promocion SET Estado = 0 WHERE Promocion = p_codigo;
	END IF;
    IF opcion = 'opc_activar_oferta' THEN		
		UPDATE se_promocion SET Estado = 1 WHERE Promocion = p_codigo;
	END IF;
    IF opcion = 'opc_obtener_oferta' THEN		
		SELECT 
			Promocion AS PROMO_ID,
            Descripcion AS DESCRIPCION,
            FechaInicio AS FECHA_INICIO,
            FechaFin AS FECHA_FIN,
            Stock AS STOCK,
            Imagen AS IMAGEN,
            Estado AS ESTADO,
            Porcentaje AS PORCENTAJE
		FROM se_promocion WHERE Promocion = p_codigo;
	END IF;
    IF opcion = 'opc_update_oferta' THEN		
		UPDATE se_promocion			
            SET Descripcion = p_descripcion,
             FechaInicio = p_fechaInicio,
             FechaFin = p_fechaFin,
             Stock = p_stock,  
             Imagen = p_ruta,
             Porcentaje = p_porcentaje
		WHERE Promocion = p_codigo;
	END IF;
    
    
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_porcentaje` (IN `opcion` VARCHAR(30), IN `p_porcentaje` DECIMAL(8,2), IN `p_usuario` INT)  NO SQL
BEGIN
	IF opcion = 'opc_verificar_porcentaje' THEN
		SET @CONTADOR = (SELECT COUNT(*) FROM se_comision WHERE Estado = 1);
        IF (@CONTADOR > 0) THEN
			SELECT '1' AS 'respuesta';
		ELSE
			SELECT '0' AS 'respuesta';
        END IF;
	END IF;
    IF opcion = 'opc_add_porcentaje' THEN
		SET @CONTADOR = (SELECT COUNT(*) FROM se_comision WHERE Estado = 1);
        IF (@CONTADOR > 0) THEN
			SET @COMISION_ID = (SELECT Comision FROM se_comision WHERE Estado = 1);
            UPDATE se_comision SET Estado = 0 WHERE Comision = @COMISION_ID;
            INSERT INTO se_comision (Porcentaje, FechaRegistro, UsuarioRegistro, Estado) VALUES (p_porcentaje, now(), p_usuario, 1);
            SELECT '1' AS 'respuesta';
		ELSE
			INSERT INTO se_comision (Porcentaje, FechaRegistro, UsuarioRegistro, Estado) VALUES (p_porcentaje, now(), p_usuario, 1);
            SELECT '1' AS 'respuesta';
        END IF;        
	END IF;
    IF opcion = 'opc_valor_porcentaje' THEN
		SELECT Porcentaje FROM se_comision WHERE Estado = 1;        
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_tipo_cambio` (IN `opcion` VARCHAR(30), IN `p_montoCompra` DECIMAL(8,2), IN `p_montoVenta` DECIMAL(8,2))  NO SQL
BEGIN
	IF opcion = 'opc_grabar_tipo_cambio' THEN
		SET @INICIAR = (SELECT COUNT(*) FROM se_tipocambio);
        IF (@INICIAR = 0) THEN 
			INSERT INTO se_tipocambio (MontoCompra, MontoVenta, FechaRegistro, Estado) VALUES (p_montoCompra,p_montoVenta,NOW(),1);
            SELECT '1' AS 'respuesta';
        ELSE 
			SET @VALIDAR = (SELECT COUNT(*) FROM se_tipocambio WHERE FechaRegistro = CURDATE());
			IF(@VALIDAR = 0) THEN
				SET @TIPO_ID = (SELECT MAX(TipoCambio) FROM se_tipocambio);
                UPDATE se_tipocambio SET Estado = 0 WHERE TipoCambio = @TIPO_ID;
				INSERT INTO se_tipocambio (MontoCompra, MontoVenta, FechaRegistro, Estado) VALUES (p_montoCompra,p_montoVenta,NOW(),1);
				SELECT '1' AS 'respuesta';
			ELSE
				SET @TIPO_ID = (SELECT TipoCambio FROM se_tipocambio WHERE FechaRegistro = CURDATE());
				UPDATE se_tipocambio SET MontoCompra = p_montoCompra, MontoVenta = p_montoVenta WHERE TipoCambio = @TIPO_ID;
                SELECT '0' AS 'respuesta';
			END IF;
        END IF;					
    END IF;
    IF opcion = 'opc_ver_tipo_cambio' THEN
		SET @VERIFICAR = (SELECT COUNT(*) FROM se_tipocambio WHERE FechaRegistro = CURDATE());
		IF (@VERIFICAR > 0) THEN
			SELECT MontoCompra, MontoVenta, '1' AS Respuesta FROM se_tipocambio WHERE FechaRegistro = CURDATE() AND  Estado = 1;
		ELSE
			SELECT MontoCompra, MontoVenta, '0' AS Respuesta FROM se_tipocambio WHERE FechaRegistro = CURDATE()-1 AND Estado = 0;
		END IF;
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
     	(select u.Usuario as idusuario, u.Login as usuario, s.RUC as NIF, s.NombreComercial as nombres, '' as apellidos, d.Nombre as dashboard, d.URL as dashboardURL,
r.Rol as idRol, r.Nombre as rol, u.Imagen as usuarioImagen
      	
          from se_usuario u 
            inner join se_socio s on s.Socio = u.Socio
            inner join se_rolusuario ru on ru.Usuario = u.Usuario
            inner join se_rol r on r.Rol = ru.Rol
            inner join se_dashboard d on d.Rol = r.Rol             
            where u.Login = usuario and u.Password = password);
     
     END IF;    
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestionar_pagos` (IN `opcion` VARCHAR(300), IN `p_operacion` VARCHAR(300), IN `p_monto` DOUBLE, IN `p_fecha` DATE, IN `p_pagoID` INT, IN `p_usuario` INT)  NO SQL
BEGIN
	IF opcion = 'opc_registrar_pago' THEN
		SET @VALIDAOPERACION = (SELECT COUNT(*) FROM se_pagocuotaviajero WHERE NroOperacion = p_operacion);
        SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
        IF @VALIDAOPERACION > 0 THEN
			SELECT '0' AS respuesta;
        ELSE
			INSERT INTO se_pagocuotaviajero (Viajero, NroOperacion, MontoCuota, FechaPago, Estado) VALUES (@VIAJERO, p_operacion, p_monto, p_fecha, 0);
            SELECT 'Se registro correctamente el pago realizado' AS respuesta;
        END IF;
	END IF; 	
    	
    IF opcion = 'opc_obtener_pago' THEN
		SELECT * FROM se_pagocuotaviajero WHERE PagoCuotaViajero = p_pagoID;
	END IF; 
    	
    IF opcion = 'opc_update_pago' THEN
		UPDATE se_pagocuotaviajero 
				SET NroOperacion = p_operacion,
                MontoCuota = p_monto,
                FechaPago =  p_fecha               
            WHERE PagoCuotaViajero = p_pagoID;
            
            SELECT 'El pago se modifico correctamente.' AS respuesta;
	END IF; 
    	
    IF opcion = 'opc_registrar_pago_partner' THEN
		SET @VALIDAOPERACION = (SELECT COUNT(*) FROM se_pagocuotasocio WHERE NroOperacion = p_operacion);
        SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);		
        IF @VALIDAOPERACION > 0 THEN
			SELECT '0' AS respuesta;
        ELSE
			INSERT INTO se_pagocuotasocio (Socio, NroOperacion, Monto, FechaPago, Estado) VALUES (@SOCIO, p_operacion, p_monto, p_fecha, 0);
            SELECT 'Se registro correctamente el pago realizado' AS respuesta;
        END IF;
	END IF; 
    
    IF opcion = 'opc_registrar_pago_partner_admin' THEN
		SET @VALIDAOPERACION = (SELECT COUNT(*) FROM se_pagocuotasocio WHERE NroOperacion = p_operacion);        
        IF @VALIDAOPERACION > 0 THEN
			SELECT '0' AS respuesta;
        ELSE
			INSERT INTO se_pagocuotasocio (Socio, NroOperacion, Monto, FechaPago, Estado) VALUES (p_pagoID, p_operacion, p_monto, p_fecha, 1);
            SELECT 'Se registro correctamente el pago realizado' AS respuesta;
        END IF;
	END IF; 
    
    IF opcion = 'opc_obtener_pago_partner' THEN
		SELECT 
			PS.PagoCuotaSocio, 
            PS.Socio, 
            PS.NroOperacion, 
            PS.Monto, 
            PS.FechaPago, 
            PS.Estado, 
            S.RazonSocial 
		FROM se_pagocuotasocio PS
		INNER JOIN se_socio S on S.Socio = PS.Socio
		WHERE PS.PagoCuotaSocio = p_pagoID;
	END IF; 
    	
    IF opcion = 'opc_update_pago_partner' THEN
		UPDATE se_pagocuotasocio 
				SET NroOperacion = p_operacion,
                Monto = p_monto,
                FechaPago =  p_fecha               
            WHERE PagoCuotaSocio = p_pagoID;
            
            SELECT 'El pago se modifico correctamente.' AS respuesta;
	END IF; 
    
    IF opcion = 'aprobar_pago_partners' THEN
		UPDATE se_pagocuotasocio 
				SET Estado = 1
		WHERE PagoCuotaSocio = p_pagoID;            
	END IF; 
    
    IF opcion = 'opc_registrar_pago_traveler_admin' THEN
		SET @VALIDAOPERACION = (SELECT COUNT(*) FROM se_pagocuotaviajero WHERE NroOperacion = p_operacion);        
        IF @VALIDAOPERACION > 0 THEN
			SELECT '0' AS respuesta;
        ELSE
			INSERT INTO se_pagocuotaviajero (Viajero, NroOperacion, MontoCuota, FechaPago, Estado) VALUES (p_pagoID, p_operacion, p_monto, p_fecha, 1);
            SELECT 'Se registro correctamente el pago realizado' AS respuesta;
        END IF;
	END IF; 
    
    IF opcion = 'opc_obtener_pago_traveler' THEN
		SELECT 
			PV.PagoCuotaViajero, 
			PV.Viajero, 
			PV.NroOperacion, 
			PV.MontoCuota, 
			PV.FechaPago, 
			PV.Estado, 
			CONCAT(P.Nombres,' ',P.Apellidos) 
		FROM se_pagocuotaviajero PV
		INNER JOIN se_viajero V on V.Viajero = PV.Viajero
		INNER JOIN se_persona P ON P.Persona = V.Persona
		WHERE PV.PagoCuotaViajero = p_pagoID;
	END IF;     
     
	IF opcion = 'aprobar_pago_traveler' THEN
		UPDATE se_pagocuotaviajero 
				SET Estado = 1
		WHERE PagoCuotaViajero = p_pagoID;            
	END IF; 
        
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_perfiles` (IN `opcion` VARCHAR(30), IN `p_usuario` VARCHAR(8))  NO SQL
BEGIN
	IF opcion = 'opc_obtener_perfil_socio' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        select 
			S.RazonSocial, 
			S.RUC, 
			S.NombreComercial,
			R.Descripcion,
			S.Direccion,
			S.Email,
			S.TelefonoContacto,
			S.TelefonoContacto,
			U.Imagen
		from se_socio S 
			INNER JOIN se_rubro R ON R.Rubro = S.Rubro
			INNER JOIN se_usuario U ON U.Socio = S.Socio 
		where S.socio =  @SOCIO;				
	END IF;    	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_perfil_socio` (IN `opcion` VARCHAR(30), IN `p_usuario` VARCHAR(8), IN `p_contacto` VARCHAR(30), IN `p_atencion` VARCHAR(30), IN `p_password` VARCHAR(300), IN `p_foto_perfil` TEXT, IN `p_foto_carta` TEXT)  NO SQL
BEGIN
	IF opcion = 'opc_obtener_perfil_socio' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        select 
			S.RazonSocial, 
			S.RUC, 
			S.NombreComercial,
			R.Descripcion,
			S.Direccion,
			S.Email,
			S.TelefonoContacto,
			S.TelefonoAtencion,
			U.Imagen
		from se_socio S 
			INNER JOIN se_rubro R ON R.Rubro = S.Rubro
			INNER JOIN se_usuario U ON U.Socio = S.Socio 
		where S.socio =  @SOCIO;				
	END IF;    	
    IF opcion = 'opc_update_perfil_socio' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);        
        IF (p_password = 'd41d8cd98f00b204e9800998ecf8427e') THEN
			IF (p_foto_perfil = '' OR p_foto_carta = '') THEN
				IF (p_foto_carta = '' AND p_foto_perfil <> '') THEN
					UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion					
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil
					WHERE Usuario = p_usuario;
				ELSE 
					IF (p_foto_perfil = '' AND p_foto_carta <> '') THEN 
						UPDATE se_socio 
							SET TelefonoContacto = p_contacto,
							TelefonoAtencion = p_atencion,
							CartaPresentacion = p_foto_carta
						WHERE Socio = @SOCIO;	
					ELSE 
						IF (p_foto_perfil = '' AND p_foto_carta = '') THEN
							UPDATE se_socio 
								SET TelefonoContacto = p_contacto,
								TelefonoAtencion = p_atencion				
							WHERE Socio = @SOCIO;													
                        END IF;
					END IF;
				END IF;	
			ELSE 
				UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion,
                        CartaPresentacion = p_foto_carta
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil,
                        Password = p_password
					WHERE Usuario = p_usuario;
			END IF;
		ELSE 
			IF (p_foto_perfil = '' OR p_foto_carta = '') THEN
				IF (p_foto_carta = '' AND p_foto_perfil <> '') THEN
					UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion					
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil,
                        Password = p_password
					WHERE Usuario = p_usuario;
				ELSE 
					IF (p_foto_perfil = '' AND p_foto_carta <> '') THEN 
						UPDATE se_socio 
							SET TelefonoContacto = p_contacto,
							TelefonoAtencion = p_atencion,
							CartaPresentacion = p_foto_carta
						WHERE Socio = @SOCIO;
                        
                        UPDATE se_usuario 
							SET Password = p_password
						WHERE Usuario = p_usuario;
                                                
					ELSE 
						IF (p_foto_perfil = '' AND p_foto_carta = '') THEN
							UPDATE se_socio 
								SET TelefonoContacto = p_contacto,
								TelefonoAtencion = p_atencion				
							WHERE Socio = @SOCIO;	
                            
                            UPDATE se_usuario 
								SET Password = p_password
							WHERE Usuario = p_usuario;                           
                        END IF;
					END IF;
				END IF;	
			ELSE 
				UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion,
                        CartaPresentacion = p_foto_carta
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil,
                        Password = p_password
					WHERE Usuario = p_usuario;
			END IF;            
		END IF;		        
	END IF;    	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_perfil_travelers` (IN `opcion` VARCHAR(300), IN `p_usuario` VARCHAR(5), IN `p_fijo` VARCHAR(500), IN `p_movil` VARCHAR(500), IN `p_password` VARCHAR(500), IN `p_fotoPerfil` TEXT)  NO SQL
BEGIN
	IF opcion = 'opc_obtener_perfil_travelers' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
        SELECT 
			P.Nombres AS NOMBRES,
			P.Apellidos AS APELLIDOS,
            P.Direccion AS DIRECCION,
			P.DNI AS DNI,
			P.Email AS EMAIL,
			P.FechaNacimiento AS NACIMIENTO,
			P.TelefonoFijo AS FIJO,
			P.TelefonoMovil AS MOVIL,
			V.NroPasaporte AS PASAPORTE,
            U.Imagen AS IMAGEN
		FROM se_persona P 
		INNER JOIN se_viajero V ON V.Persona = P.Persona
        INNER JOIN se_usuario U ON U.Persona = P.Persona
		WHERE P.Persona = @PERSONA;	
	END IF;    	
    
    IF opcion = 'opc_update_perfil_socio' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
        IF p_password = 'd41d8cd98f00b204e9800998ecf8427e' THEN
			IF p_fotoPerfil = '' THEN
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;
            ELSE
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;

				UPDATE se_usuario 
					SET Imagen = p_fotoPerfil
				WHERE Usuario = p_usuario;
            END IF;			
        ELSE
			IF p_fotoPerfil = '' THEN
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;
                
                UPDATE se_usuario 					
                    SET Password = p_password
				WHERE Usuario = p_usuario;
                
            ELSE
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;

				UPDATE se_usuario 
					SET Imagen = p_fotoPerfil,
                    Password = p_password
				WHERE Usuario = p_usuario;
            END IF;
        END IF;
	END IF;    	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_transaccion` (IN `opcion` VARCHAR(30), IN `p_clienteID` INT, IN `p_tipoDoc` INT, IN `p_serie` VARCHAR(8), IN `p_numero` VARCHAR(8), IN `p_importe` DECIMAL(8,2), IN `p_fecha` DATE, IN `p_usuario` INT, IN `p_codigo` INT)  NO SQL
BEGIN
	IF opcion = 'opc_registrar_transaccion' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        SET @PORCRETORNO = (SELECT PorcentajeRetorno FROM se_socio WHERE Socio = @SOCIO);
        SET @COMISION = (SELECT Porcentaje FROM se_comision WHERE Estado = 1);
        SET @COMISIONID = (SELECT Comision FROM se_comision WHERE Estado = 1);
        SET @VALIDADOC = (SELECT COUNT(*) FROM se_transaccion WHERE Serie = p_serie AND Numero = p_numero AND TipoDocumento = p_tipoDoc);
        
        SET @VALIDARCONTADOR = (SELECT COUNT(*) FROM se_contador WHERE Viajero = p_clienteID);
        SET @VALIDARCONTADORSOCIO = (SELECT COUNT(*) FROM se_contadorsocio WHERE Socio = @SOCIO);        
        SET @VALIDARCONTADORMUNDI = (SELECT COUNT(*) FROM se_contadormundi); 
        
        IF (@VALIDADOC > 0) THEN 
			SELECT 'El documento ya ingresado ya existe' AS respuesta;
        ELSE
			IF (@VALIDARCONTADOR = 0) THEN
				INSERT INTO se_transaccion (Serie, Numero, Viajero, Socio, Importe, FechaTransaccion, Estado, TipoDocumento) 
					VALUES (p_serie, p_numero, p_clienteID, @SOCIO, p_importe, p_fecha, 1, p_tipoDoc);	                                        
				SET @MONTORETORNO = (cast(p_importe as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100);	                SET @RETORNOMUNDI = (cast(p_importe as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100);					SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOMUNDI);                 SET @MONTOSOCIO = (cast(p_importe as decimal(8,2))-cast(@MONTORETORNO as decimal(8,2)));
                
                				INSERT INTO se_contador (Viajero, MontoAcumulado, Estado) VALUES (p_clienteID, @MONTOVIAJERO, 1);	                
				SET @TRANSAC_ID = (SELECT MAX(Transaccion) FROM se_transaccion);                
				SET @CONT_ID = (SELECT MAX(Contador) FROM se_contador);				                
				INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, @TRANSAC_ID, @COMISIONID, 1);				
                INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('9', @SOCIO, now(), 1);
                
                                IF @VALIDARCONTADORSOCIO = 0 THEN
					INSERT INTO se_contadorsocio (Socio, MontoAcumulado, Estado) VALUES (@SOCIO, @MONTOSOCIO, 1);
					SET @CONTSOCIO_ID = (SELECT MAX(ContadorSocio) FROM se_contadorsocio);
					INSERT INTO se_transaccioncontadorsocio (ContadorSocio, Transaccion, PorcentajeRetorno, Estado) VALUES (@CONTSOCIO_ID, @TRANSAC_ID, cast(@PORCRETORNO as decimal(8,2)), 1);
					
				ELSE
					SET @MONTOACUMULADOSOCIO = (SELECT MontoAcumulado FROM se_contadorsocio WHERE Socio = @SOCIO);
					SET @CONTSOCIO_ID = (SELECT ContadorSocio FROM se_contadorsocio WHERE Socio = @SOCIO);
					UPDATE se_contadorsocio SET MontoAcumulado = (cast(@MONTOACUMULADOSOCIO as decimal(8,2)) + @MONTOSOCIO) WHERE ContadorSocio = @CONTSOCIO_ID;
					INSERT INTO se_transaccioncontadorsocio (ContadorSocio, Transaccion, PorcentajeRetorno, Estado) VALUES (@CONTSOCIO_ID, @TRANSAC_ID, cast(@PORCRETORNO as decimal(8,2)), 1);
						
                END IF;
                
                IF @VALIDARCONTADORMUNDI = 0 THEN
					INSERT INTO se_contadormundi (MontoAcumulado, Estado) VALUES (@RETORNOMUNDI ,1);
					SET @MUNDI_ID = (SELECT MAX(ContadorMundi) FROM se_contadormundi);
					INSERT INTO se_transaccioncontadormundi (ContadorMundi, Transaccion, Comision, Estado) VALUES (@MUNDI_ID, @TRANSAC_ID, @COMISIONID, 1);
					SELECT 'Registro Correcto' AS respuesta;
				ELSE
					SET @MUNDI_ID = (SELECT ContadorMundi FROM se_contadormundi);
					SET @MONTOACUMULADOMUNDI = (SELECT MontoAcumulado FROM se_contadormundi);
					SET @MONTOFINALMUNDI = (cast(@MONTOACUMULADOMUNDI as decimal(8,2))+@RETORNOMUNDI);
					UPDATE se_contadormundi SET MontoAcumulado = @MONTOFINALMUNDI WHERE ContadorMundi = @MUNDI_ID;
					INSERT INTO se_transaccioncontadormundi (ContadorMundi, Transaccion, Comision, Estado) VALUES (@MUNDI_ID, @TRANSAC_ID, @COMISIONID, 1);
                    SELECT 'Registro Correcto' AS respuesta;
                END IF;
                							
				
                
            ELSE
				INSERT INTO se_transaccion (Serie, Numero, Viajero, Socio, Importe, FechaTransaccion, Estado, TipoDocumento)
					VALUES (p_serie, p_numero, p_clienteID, @SOCIO, p_importe, p_fecha, 1, p_tipoDoc);
				SET @MONTORETORNO = (cast(p_importe as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100);				
				SET @RETORNOMUNDI = (cast(p_importe as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100);				
				SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOMUNDI);	                
                SET @MONTOACUMULADO = (SELECT MontoAcumulado FROM se_contador WHERE Viajero = p_clienteID);
                SET @TRANSAC_ID = (SELECT MAX(Transaccion) FROM se_transaccion);
				SET @CONT_ID = (SELECT Contador FROM se_contador WHERE Viajero = p_clienteID);	
                SET @MONTOSOCIO = (cast(p_importe as decimal(8,2))-cast(@MONTORETORNO as decimal(8,2)));
                
                                UPDATE se_contador SET MontoAcumulado = (cast(@MONTOACUMULADO as decimal(8,2)) + @MONTOVIAJERO) WHERE Contador = @CONT_ID;
                INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, @TRANSAC_ID, @COMISIONID, 1);				
                INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('9', @SOCIO, now(), 1);
                
                                SET @MONTOACUMULADOSOCIO = (SELECT MontoAcumulado FROM se_contadorsocio WHERE Socio = @SOCIO);
                SET @CONTSOCIO_ID = (SELECT ContadorSocio FROM se_contadorsocio WHERE Socio = @SOCIO);
                UPDATE se_contadorsocio SET MontoAcumulado = (cast(@MONTOACUMULADOSOCIO as decimal(8,2)) + @MONTOSOCIO) WHERE ContadorSocio = @CONTSOCIO_ID;
                INSERT INTO se_transaccioncontadorsocio (ContadorSocio, Transaccion, PorcentajeRetorno, Estado) VALUES (@CONTSOCIO_ID, @TRANSAC_ID, cast(@PORCRETORNO as decimal(8,2)), 1);
				                
                                SET @MUNDI_ID = (SELECT ContadorMundi FROM se_contadormundi);
                SET @MONTOACUMULADOMUNDI = (SELECT MontoAcumulado FROM se_contadormundi);
                SET @MONTOFINALMUNDI = (cast(@MONTOACUMULADOMUNDI as decimal(8,2))+@RETORNOMUNDI);
                UPDATE se_contadormundi SET MontoAcumulado = @MONTOFINALMUNDI WHERE ContadorMundi = @MUNDI_ID;
                INSERT INTO se_transaccioncontadormundi (ContadorMundi, Transaccion, Comision, Estado) VALUES (@MUNDI_ID, @TRANSAC_ID, @COMISIONID, 1);
                
                SELECT 'Registro Correcto' AS respuesta;
            END IF;                							
        END IF;
	END IF; 
    
    IF opcion = 'opc_update_transaccion' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        SET @PORCRETORNO = (SELECT PorcentajeRetorno FROM se_socio WHERE Socio = @SOCIO);
        SET @COMISION = (SELECT Porcentaje FROM se_comision WHERE Estado = 1);
        SET @COMISIONID = (SELECT Comision FROM se_comision WHERE Estado = 1);
        SET @VALIDADOC = (SELECT COUNT(*) FROM se_transaccion WHERE Serie = p_serie AND Numero = p_numero AND TipoDocumento = p_tipoDoc);
		SET @MONTOANTIGUO = (SELECT Importe FROM se_transaccion WHERE Transaccion = p_codigo);
        SET @TRANSACCONTANTIGUO =  (SELECT TransaccionContador FROM se_transaccioncontador WHERE Transaccion = p_codigo);
        
			IF (cast(@MONTOANTIGUO as decimal(8,2))=cast(p_importe as decimal(8,2))) THEN
				UPDATE se_transaccion 
					SET Serie = p_serie,
					Numero = p_numero,
										FechaTransaccion = p_fecha,
					TipoDocumento = p_tipoDoc
				WHERE Transaccion = p_codigo;
                INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('11', @SOCIO, now(), 1);
				SELECT 'Registro Correcto' AS respuesta;
			ELSE
				SET @MONTORETORNOANTIGUO = (cast(@MONTOANTIGUO as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100); 				SET @RETORNOMUNDIANTIGUO = (cast(@MONTOANTIGUO as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100); 				SET @MONTOVIAJEROANTIGUO = (@MONTORETORNOANTIGUO - @RETORNOMUNDIANTIGUO);                 SET @MONTOACUMULADOANTIGUO = (SELECT MontoAcumulado FROM se_contador WHERE Viajero = p_clienteID); 				SET @CONT_ID = (SELECT Contador FROM se_contador WHERE Viajero = p_clienteID);                 
                                 SET @MONTOACUMULADOANTIGUOSOCIO = (SELECT MontoAcumulado FROM se_contadorsocio WHERE Socio = @SOCIO);                 SET @CONTSOCIO_ID = (SELECT ContadorSocio FROM se_contadorsocio WHERE Socio = @SOCIO);                 SET @MONTOSOCIOANTIGUO = (cast(@MONTOANTIGUO as decimal(8,2))-cast(@MONTORETORNOANTIGUO as decimal(8,2)));                 
                SET @MONTOMUNDIANTIGUO = (SELECT MontoAcumulado FROM se_contadormundi);
                
                UPDATE se_contador SET MontoAcumulado = (cast(@MONTOACUMULADOANTIGUO as decimal(8,2)) - cast(@MONTOVIAJEROANTIGUO as decimal(8,2))) WHERE Contador = @CONT_ID;                                
                UPDATE se_contadorsocio SET MontoAcumulado = (cast(@MONTOACUMULADOANTIGUOSOCIO as decimal(8,2)) - cast(@MONTOSOCIOANTIGUO as decimal(8,2))) WHERE ContadorSocio = @CONTSOCIO_ID;                                
                UPDATE se_contadormundi SET MontoAcumulado = (cast(@MONTOMUNDIANTIGUO as decimal(8,2)) - cast(@RETORNOMUNDIANTIGUO as decimal(8,2)));                                
                
                UPDATE se_transaccion 
					SET Serie = p_serie,
					Numero = p_numero,
					Importe= p_importe,
					FechaTransaccion = p_fecha,
					TipoDocumento = p_tipoDoc
				WHERE Transaccion = p_codigo;
				
                SET @MONTORETORNO = (cast(p_importe as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100); 				SET @RETORNOMUNDI = (cast(p_importe as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100); 				SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOMUNDI);                 SET @MONTOACUMULADO = (SELECT MontoAcumulado FROM se_contador WHERE Viajero = p_clienteID); 				SET @CONT_ID = (SELECT Contador FROM se_contador WHERE Viajero = p_clienteID);			
                UPDATE se_contador SET MontoAcumulado = (cast(@MONTOACUMULADO as decimal(8,2)) + @MONTOVIAJERO) WHERE Contador = @CONT_ID;                
                SET @MONTOACUMULADOSOCIO = (SELECT MontoAcumulado FROM se_contadorsocio WHERE Socio = @SOCIO);                
                
                SET @MONTOACUMULADOMUNDI = (SELECT MontoAcumulado FROM se_contadormundi);                
                
                SET @MONTOSOCIONUEVO = (cast(p_importe as decimal(8,2))-cast(@MONTORETORNO as decimal(8,2)));                 UPDATE se_contadorsocio SET MontoAcumulado = (cast(@MONTOACUMULADOSOCIO as decimal(8,2)) + cast(@MONTOSOCIONUEVO as decimal(8,2))) WHERE ContadorSocio = @CONTSOCIO_ID;                                
                                 UPDATE se_transaccioncontador 
					 SET Contador = @CONT_ID, Comision = @COMISION WHERE Transaccion = p_codigo;
                     
				UPDATE se_contadormundi SET MontoAcumulado = (cast(@MONTOACUMULADOMUNDI as decimal(8,2)) + cast(@RETORNOMUNDI as decimal(8,2)));                                
                
				INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('11', @SOCIO, now(), 1);
                DELETE FROM se_transaccioncontador WHERE TransaccionContador = @TRANSACCONTANTIGUO ;
                INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, p_codigo, @COMISIONID, 1);														                
				SELECT 'Registro Correcto' AS respuesta;
            END IF;
        END IF;
		
        IF opcion = 'opc_pre_registrar_transaccion' THEN
			SET @VALIDADOC = (SELECT COUNT(*) FROM se_transaccion WHERE Serie = p_serie AND Numero = p_numero AND TipoDocumento = p_tipoDoc);
			SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
			SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
            
            IF (@VALIDADOC = 0) THEN
				INSERT INTO se_transaccion (Serie, Numero, Viajero, Socio, Importe, FechaTransaccion, Estado, TipoDocumento) VALUES (p_serie, p_numero, @VIAJERO, p_clienteID, p_importe, p_fecha, 0, p_tipoDoc);
				SELECT 'Registro Correcto' AS respuesta;
            ELSE
				SELECT '1' AS respuesta;
            END IF;
            
			
        END IF;
        
        IF opcion = 'opc_update_pre_transaccion' THEN					
            SET @VALIDADOC = (SELECT COUNT(*) FROM se_transaccion WHERE Serie = p_serie AND Numero = p_numero AND TipoDocumento = p_tipoDoc);
            
            IF (@VALIDADOC = 0) THEN
				UPDATE se_transaccion 
					SET Serie = p_serie,
					Numero = p_numero,
					Socio = p_clienteID,
					Importe = p_importe,
					FechaTransaccion = p_fecha,
					TipoDocumento = p_tipoDoc
				WHERE Transaccion = p_codigo;
				
				SELECT 'Registro Correcto' AS respuesta;
            ELSE
				SELECT '1' AS respuesta;
            END IF;
            
        END IF;
        	
    
     
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listado_ventas` (IN `p_usuario` INT, IN `opcion` VARCHAR(200), IN `p_codigo` INT)  NO SQL
BEGIN
	IF opcion = 'opc_contar_ventas_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT COUNT(*) AS total FROM se_transaccion WHERE Socio = @SOCIO AND Estado = 1;
	END IF; 
    
    IF opcion = 'opc_contar_ventas_pre_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT COUNT(*) AS total FROM se_transaccion WHERE Socio = @SOCIO AND (Estado = 0 OR Estado = 2);
	END IF; 
    
    IF opcion = 'opc_contar_ultimas_ventas_rgistradas' THEN		
		SELECT 10 AS total;
	END IF; 
    
    
    IF opcion = 'opc_listar_ventas_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT 
			T.Transaccion AS CODIGO,
			CONCAT(P.Nombres,' ',P.Apellidos) AS CLIENTE, 
			TD.Descripcion AS TIPO_DOCUMENTO, 
			CONCAT(T.Serie,'-',T.Numero) AS DOCUMENTO, 
			T.Importe AS IMPORTE,
			T.FechaTransaccion AS FECHA,
			T.Estado AS ESTADO
		FROM se_transaccion T
			INNER JOIN se_viajero V ON V.Viajero = T.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
			INNER JOIN se_tipodocumento TD ON TD.TipoDocumento = T.TipoDocumento
		WHERE T.Socio = @SOCIO AND T.Estado = 1 ORDER BY T.FechaTransaccion DESC;
	END IF;  
    
    IF opcion = 'opc_listar_ultimas_ventas_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT 
			T.Transaccion AS CODIGO,
			CONCAT(P.Nombres,' ',P.Apellidos) AS CLIENTE, 
			TD.Descripcion AS TIPO_DOCUMENTO, 
			CONCAT(T.Serie,'-',T.Numero) AS DOCUMENTO, 
			T.Importe AS IMPORTE,
			T.FechaTransaccion AS FECHA,
			T.Estado AS ESTADO
		FROM se_transaccion T
			INNER JOIN se_viajero V ON V.Viajero = T.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
			INNER JOIN se_tipodocumento TD ON TD.TipoDocumento = T.TipoDocumento
		WHERE T.Socio = @SOCIO AND T.Estado = 1 ORDER BY T.FechaTransaccion DESC limit 10;
	END IF;  
    
    IF opcion = 'opc_listar_ventas_pre_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT 
			T.Transaccion AS CODIGO,
			CONCAT(P.Nombres,' ',P.Apellidos) AS CLIENTE, 
			TD.Descripcion AS TIPO_DOCUMENTO, 
			CONCAT(T.Serie,'-',T.Numero) AS DOCUMENTO, 
			T.Importe AS IMPORTE,
			T.FechaTransaccion AS FECHA,
			T.Estado AS ESTADO
		FROM se_transaccion T
			INNER JOIN se_viajero V ON V.Viajero = T.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
			INNER JOIN se_tipodocumento TD ON TD.TipoDocumento = T.TipoDocumento
		WHERE T.Socio = @SOCIO AND (T.Estado = 0 OR T.Estado = 2) ORDER BY T.FechaTransaccion DESC;
	END IF;  
    
    
    IF opcion = 'opc_contar_tres_ventas_pre_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT 
			T.Transaccion AS CODIGO,
			CONCAT(P.Nombres,' ',P.Apellidos) AS CLIENTE, 
			TD.Descripcion AS TIPO_DOCUMENTO, 
			CONCAT(T.Serie,'-',T.Numero) AS DOCUMENTO, 
			T.Importe AS IMPORTE,
			T.FechaTransaccion AS FECHA,
			T.Estado AS ESTADO
		FROM se_transaccion T
			INNER JOIN se_viajero V ON V.Viajero = T.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
			INNER JOIN se_tipodocumento TD ON TD.TipoDocumento = T.TipoDocumento
		WHERE T.Socio = @SOCIO AND (T.Estado = 0 OR T.Estado = 2) ORDER BY T.FechaTransaccion DESC limit 3;
	END IF;  
    
    
    IF opcion = 'opc_aceptar_transaccion' THEN
		SET @CLIENTE = (SELECT Viajero FROM se_transaccion WHERE Transaccion = p_codigo AND (Estado = 0 OR Estado = 2));
        SET @SOCIO = (SELECT Socio FROM se_transaccion WHERE Transaccion = p_codigo AND (Estado = 0 OR Estado = 2));
		SET @VALIDARCONTADOR = (SELECT COUNT(*) FROM se_contador WHERE Viajero = @CLIENTE);
		SET @IMPORTE = (SELECT Importe FROM se_transaccion WHERE Transaccion = p_codigo AND (Estado = 0 OR Estado = 2));
        SET @PORCRETORNO = (SELECT PorcentajeRetorno FROM se_socio WHERE Socio = @SOCIO);
        SET @COMISION = (SELECT Porcentaje FROM se_comision WHERE Estado = 1);       
        SET @COMISIONID = (SELECT Comision FROM se_comision WHERE Estado = 1); 
        
        SET @VALIDARCONTADORSOCIO = (SELECT COUNT(*) FROM se_contadorsocio WHERE Socio = @SOCIO);        
        SET @VALIDARCONTADORMUNDI = (SELECT COUNT(*) FROM se_contadormundi); 
        
        
        IF (@VALIDARCONTADOR = 0) THEN
			SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
			UPDATE se_transaccion SET Estado = 1 WHERE Transaccion = p_codigo;		                    
			SET @MONTORETORNO = (cast(@IMPORTE as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100);		-- 12		
			SET @RETORNOMUNDI = (cast(@IMPORTE as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100);	 	-- 2	
			SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOMUNDI);	-- 10
			
            SET @MONTOSOCIO = (cast(@IMPORTE as decimal(8,2))-cast(@MONTORETORNO as decimal(8,2)));
            
			INSERT INTO se_contador (Viajero, MontoAcumulado, Estado) VALUES (@CLIENTE, @MONTOVIAJERO, 1);				
			SET @CONT_ID = (SELECT MAX(Contador) FROM se_contador);				
			INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, p_codigo, @COMISIONID, 1);				
			INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('10', @SOCIO, now(), 1);
            
            IF @VALIDARCONTADORSOCIO = 0 THEN
				INSERT INTO se_contadorsocio (Socio, MontoAcumulado, Estado) VALUES (@SOCIO, @MONTOSOCIO, 1);
				SET @CONTSOCIO_ID = (SELECT MAX(ContadorSocio) FROM se_contadorsocio);
				INSERT INTO se_transaccioncontadorsocio (ContadorSocio, Transaccion, PorcentajeRetorno, Estado) VALUES (@CONTSOCIO_ID, p_codigo, cast(@PORCRETORNO as decimal(8,2)), 1);
				
			ELSE
				SET @MONTOACUMULADOSOCIO = (SELECT MontoAcumulado FROM se_contadorsocio WHERE Socio = @SOCIO);
				SET @CONTSOCIO_ID = (SELECT ContadorSocio FROM se_contadorsocio WHERE Socio = @SOCIO);
				UPDATE se_contadorsocio SET MontoAcumulado = (cast(@MONTOACUMULADOSOCIO as decimal(8,2)) + @MONTOSOCIO) WHERE ContadorSocio = @CONTSOCIO_ID;
				INSERT INTO se_transaccioncontadorsocio (ContadorSocio, Transaccion, PorcentajeRetorno, Estado) VALUES (@CONTSOCIO_ID, p_codigo, cast(@PORCRETORNO as decimal(8,2)), 1);
					
			END IF;
            
            IF @VALIDARCONTADORMUNDI = 0 THEN
				INSERT INTO se_contadormundi (MontoAcumulado, Estado) VALUES (@RETORNOMUNDI ,1);
				SET @MUNDI_ID = (SELECT MAX(ContadorMundi) FROM se_contadormundi);
				INSERT INTO se_transaccioncontadormundi (ContadorMundi, Transaccion, Comision, Estado) VALUES (@MUNDI_ID, p_codigo, @COMISIONID, 1);
				SELECT 'Registro Correcto' AS respuesta;
			ELSE
				SET @MUNDI_ID = (SELECT ContadorMundi FROM se_contadormundi);
				SET @MONTOACUMULADOMUNDI = (SELECT MontoAcumulado FROM se_contadormundi);
				SET @MONTOFINALMUNDI = (cast(@MONTOACUMULADOMUNDI as decimal(8,2)) + @RETORNOMUNDI);
				UPDATE se_contadormundi SET MontoAcumulado = @MONTOFINALMUNDI WHERE ContadorMundi = @MUNDI_ID;
				INSERT INTO se_transaccioncontadormundi (ContadorMundi, Transaccion, Comision, Estado) VALUES (@MUNDI_ID, p_codigo, @COMISIONID, 1);
				SELECT 'Registro Correcto' AS respuesta;
			END IF;
            					
		ELSE
			SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
			UPDATE se_transaccion SET Estado = 1 WHERE Transaccion = p_codigo;	
				
			SET @MONTORETORNO = (cast(@IMPORTE as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100);	-- 12			
			SET @RETORNOMUNDI = (cast(@IMPORTE as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100);	-- 2
			SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOMUNDI);	-- 10
			
			SET @MONTOACUMULADO = (SELECT MontoAcumulado FROM se_contador WHERE Viajero = @CLIENTE);
			SET @TRANSAC_ID = (SELECT MAX(Transaccion) FROM se_transaccion);
			SET @CONT_ID = (SELECT Contador FROM se_contador WHERE Viajero = @CLIENTE);	
			
			UPDATE se_contador SET MontoAcumulado = (cast(@MONTOACUMULADO as decimal(8,2)) + @MONTOVIAJERO) WHERE Contador = @CONT_ID;
			INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, p_codigo, @COMISIONID, 1);				
			INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('10', @SOCIO, now(), 1);
            
            SET @MONTOSOCIO = (cast(@IMPORTE as decimal(8,2))-cast(@MONTORETORNO as decimal(8,2)));
            
            SET @MONTOACUMULADOSOCIO = (SELECT MontoAcumulado FROM se_contadorsocio WHERE Socio = @SOCIO);
			SET @CONTSOCIO_ID = (SELECT ContadorSocio FROM se_contadorsocio WHERE Socio = @SOCIO);
			UPDATE se_contadorsocio SET MontoAcumulado = (cast(@MONTOACUMULADOSOCIO as decimal(8,2)) + @MONTOSOCIO) WHERE ContadorSocio = @CONTSOCIO_ID;
			INSERT INTO se_transaccioncontadorsocio (ContadorSocio, Transaccion, PorcentajeRetorno, Estado) VALUES (@CONTSOCIO_ID, p_codigo, cast(@PORCRETORNO as decimal(8,2)), 1);
                
			SET @MUNDI_ID = (SELECT ContadorMundi FROM se_contadormundi);
			SET @MONTOACUMULADOMUNDI = (SELECT MontoAcumulado FROM se_contadormundi);
			SET @MONTOFINALMUNDI = (cast(@MONTOACUMULADOMUNDI as decimal(8,2)) + @RETORNOMUNDI);
			UPDATE se_contadormundi SET MontoAcumulado = @MONTOFINALMUNDI WHERE ContadorMundi = @MUNDI_ID;
			INSERT INTO se_transaccioncontadormundi (ContadorMundi, Transaccion, Comision, Estado) VALUES (@MUNDI_ID, p_codigo, @COMISIONID, 1);
                
			SELECT 'Registro Correcto' AS respuesta;										
            END IF;                       					
	END IF; 
    
    IF opcion = 'opc_rechazar_transaccion' THEN
		UPDATE se_transaccion SET Estado = 2 WHERE Transaccion = p_codigo;
    END IF;
    
    IF opcion = 'opc_total_ventas_socio' THEN
		SET @v_FechaActual = NOW();
    
		SET @v_dia_cierre_bd = 2;
     
		SET @v_anioActual = YEAR(@v_FechaActual);
		SET @v_mesActual = MONTH(@v_FechaActual);
		SET @v_diaActual = DAY(@v_FechaActual);

		SET @v_diaApertura = @v_dia_cierre_bd;
		SET @v_mesApertura = (CASE WHEN @v_dia_cierre_bd <= @v_diaActual THEN @v_mesActual ELSE @v_mesActual - 1 END);
		SET @v_anioApertura = (CASE @v_mesApertura WHEN 0 THEN (@v_anioActual - 1) ELSE @v_anioActual END);
		SET @v_mesApertura = (CASE @v_mesApertura WHEN 0 THEN 12 ELSE @v_mesApertura END);
         
		SET @v_FechaApertura = CAST(CONCAT(CAST(@v_anioApertura AS CHAR), '/',CAST(@v_mesApertura AS CHAR), '/',CAST(@v_diaApertura AS CHAR)) AS DATE);

		SET @v_FechaCierre = DATE_ADD(CAST(@v_FechaApertura as datetime), INTERVAL 1 MONTH);
        
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT COUNT(*) AS respuesta FROM se_transaccion WHERE Socio = @SOCIO AND FechaTransaccion >= @v_FechaApertura AND FechaTransaccion < @v_FechaCierre and Estado = 1;
	END IF; 
    
    IF opcion = 'opc_monto_total_ventas_socio' THEN			
		SET @v_FechaActual = NOW();
    
		SET @v_dia_cierre_bd = 2;
     
		SET @v_anioActual = YEAR(@v_FechaActual);
		SET @v_mesActual = MONTH(@v_FechaActual);
		SET @v_diaActual = DAY(@v_FechaActual);

		SET @v_diaApertura = @v_dia_cierre_bd;
		SET @v_mesApertura = (CASE WHEN @v_dia_cierre_bd <= @v_diaActual THEN @v_mesActual ELSE @v_mesActual - 1 END);
		SET @v_anioApertura = (CASE @v_mesApertura WHEN 0 THEN (@v_anioActual - 1) ELSE @v_anioActual END);
		SET @v_mesApertura = (CASE @v_mesApertura WHEN 0 THEN 12 ELSE @v_mesApertura END);
         
		SET @v_FechaApertura = CAST(CONCAT(CAST(@v_anioApertura AS CHAR), '/',CAST(@v_mesApertura AS CHAR), '/',CAST(@v_diaApertura AS CHAR)) AS DATE);

		SET @v_FechaCierre = DATE_ADD(CAST(@v_FechaApertura as datetime), INTERVAL 1 MONTH);

		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT IFNULL(SUM(Importe), 0) AS respuesta FROM se_transaccion WHERE Socio = @SOCIO AND FechaTransaccion >= @v_FechaApertura AND FechaTransaccion < @v_FechaCierre and Estado = 1;
	END IF; 
    
    IF opcion = 'opc_total_numro_socios' THEN
		SELECT COUNT(*) AS respuesta FROM se_viajero;
	END IF;
    
    IF opcion = 'opc_venta_neta_socio' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        SELECT PorcentajeRetorno as respuesta FROM se_socio WHERE Socio = @SOCIO;
	END IF;
    
    IF opcion = 'opc_contar_consumo_clientes' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
        SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
		SELECT COUNT(*) AS total FROM se_transaccion WHERE Viajero = @VIAJERO;
	END IF;
    
    IF opcion = 'opc_listar_consumo' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
        SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
        SELECT 
			T.Transaccion AS CODIGO,
            TP.Descripcion AS TIPO_DOCUMENTO,
			CONCAT(T.Serie,'-',T.Numero) AS DOCUMENTO,			 
			T.Importe AS IMPORTE,
			T.FechaTransaccion AS FECHA,
            T.Estado AS ESTADO,
			S.NombreComercial AS SOCIO
		FROM se_transaccion T 
		INNER JOIN se_tipodocumento TP ON TP.TipoDocumento = T.TipoDocumento 
        INNER JOIN se_socio S ON S.Socio = T.Socio
		WHERE Viajero = @VIAJERO;
	END IF;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_comision`
--

CREATE TABLE `se_comision` (
  `Comision` int(11) NOT NULL,
  `Porcentaje` int(11) NOT NULL,
  `FechaRegistro` date NOT NULL,
  `UsuarioRegistro` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_comision`
--

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

--
-- Volcado de datos para la tabla `se_contador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_contadormundi`
--

CREATE TABLE `se_contadormundi` (
  `ContadorMundi` int(11) NOT NULL,
  `MontoAcumulado` decimal(10,2) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_contadormundi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_contadorsocio`
--

CREATE TABLE `se_contadorsocio` (
  `ContadorSocio` int(11) NOT NULL,
  `Socio` int(11) NOT NULL,
  `MontoAcumulado` decimal(10,2) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_contadorsocio`
--

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
(2, 'Net Partner', 'Dashboard de consulta del Net Partner del portal Mundipack', 2, 'socio_dashboard.php', b'1', 2),
(3, 'Traveler', 'Dashboard de consulta del Traveler del portal Mundipack', 3, 'viajero_dashboard.php', b'1', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_menu`
--

CREATE TABLE `se_menu` (
  `Menu` int(11) NOT NULL,
  `MenuPadre` int(11) DEFAULT NULL,
  `Nombre` varchar(30) NOT NULL,
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
(6, 5, 'Depositos Viajeros', 1, 'fa fa-paper-plane-o', '../administrador/pagos_viajeros.php', b'1'),
(7, 5, 'Porcentaje Consumos', 2, 'fa fa-percent', '', b'1'),
(8, NULL, 'Ofertas', 4, 'fa fa-tasks', '../partners/Ofertas.php', b'1'),
(9, NULL, 'Ventas', 5, 'fa fa-money', NULL, b'1'),
(10, 9, 'Ventas Registradas', 1, '', '../partners/ventasRegistradas.php', b'1'),
(11, 9, 'Pre-Registradas', 2, '', '../partners/ventasPreRegistradas.php', b'1'),
(12, NULL, 'Paquetes de Viaje', 3, 'fa fa-plane', '../administrador/paquetesViaje.php', b'1'),
(13, NULL, 'Net Partners', 2, 'fa fa-home', NULL, b'1'),
(14, 13, 'Lista de Net Partners', 1, 'fa fa-home', '../travelers/netPartners.php', b'1'),
(15, 13, 'Ofertas', 2, 'fa fa-tasks', '../travelers/ofertas.php', b'1'),
(16, 5, 'Consumos', 1, 'fa fa-money', '../travelers/consumos.php', b'1'),
(17, 5, 'Pagos Realizados', 2, 'fa fa-money', '../travelers/pagos.php', b'1'),
(18, NULL, 'Travelers Abiertos', 4, 'fa fa-user', '../travelers/traveler_abiertos.php', b'1'),
(19, NULL, 'Paquetes de Viajes', 5, 'fa fa-plane', NULL, b'1'),
(20, 19, 'Paquetes Ofertados', 1, '', '../travelers/paquetes.php', b'1'),
(21, 19, 'Paquetes Adquiridos', 2, '', '../travelers/paquetes_adquiridos.php', b'1'),
(22, 5, 'Pagos Realizados', 2, 'fa fa-money', '../partners/pagos.php', b'1');

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

--
-- Volcado de datos para la tabla `se_pagocuotasocio`
--

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
(9, 7, 1, b'1'),
(10, 1, 2, b'1'),
(11, 8, 2, b'1'),
(12, 9, 2, b'1'),
(13, 10, 2, b'1'),
(14, 11, 2, b'1'),
(15, 1, 3, b'1'),
(16, 12, 1, b'1'),
(17, 13, 3, b'1'),
(18, 14, 3, b'1'),
(19, 15, 3, b'1'),
(20, 5, 3, b'1'),
(21, 16, 3, b'1'),
(22, 17, 3, b'1'),
(23, 18, 3, b'1'),
(24, 19, 3, b'1'),
(25, 20, 3, b'1'),
(26, 21, 3, b'1'),
(27, 5, 2, b'1'),
(28, 22, 2, b'1');

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
(1, 'MUNDIPACK', '', '00000000', '', '2017-01-01', '000000000', '000000000', 'mundipack@gmail.com', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_promocion`
--

CREATE TABLE `se_promocion` (
  `Promocion` int(11) NOT NULL,
  `Descripcion` varchar(500) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Stock` varchar(11) DEFAULT NULL,
  `FechaIngreso` date NOT NULL,
  `Socio` int(11) NOT NULL,
  `Imagen` varchar(500) NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Porcentaje` varchar(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_promocion`
--

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
(2, 'Net Partner', 'Net Partner de Mundipack', b'1'),
(3, 'Traveler', 'Traveler de Mundipack', b'1');

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
(1, 1, 1, b'1');

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
(1, 'Restaurante', 1),
(2, 'SPA', 1),
(3, 'Cafeteria', 3),
(4, 'Hotel', 1),
(5, 'Boutique', 1),
(6, 'Clinica', 1),
(7, 'Discoteca', 1);

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
  `PrecioDesde` double NOT NULL,
  `DiaPago` int(11) DEFAULT NULL,
  `Estado` bit(1) NOT NULL,
  `CartaPresentacion` text,
  `Categoria` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_socio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_tipocambio`
--

CREATE TABLE `se_tipocambio` (
  `TipoCambio` int(11) NOT NULL,
  `MontoCompra` decimal(8,2) NOT NULL,
  `MontoVenta` decimal(8,2) NOT NULL,
  `FechaRegistro` date NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_tipodocumento`
--

CREATE TABLE `se_tipodocumento` (
  `TipoDocumento` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_tipodocumento`
--

INSERT INTO `se_tipodocumento` (`TipoDocumento`, `Descripcion`) VALUES
(1, 'Boleta'),
(2, 'Factura');

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
(4, 'Pago de cuota de Net Parter'),
(5, 'Nuevo Traveler'),
(6, 'Baja de Traveler'),
(7, 'Reactivacion de Traveler'),
(8, 'Pago de cuota de Traveler'),
(9, 'Registro de Venta'),
(10, 'Aprobación de Venta'),
(11, 'Modificacion de Venta');

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
  `Estado` int(11) DEFAULT NULL,
  `TipoDocumento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_transaccion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_transaccioncontador`
--

CREATE TABLE `se_transaccioncontador` (
  `TransaccionContador` int(11) NOT NULL,
  `Contador` int(11) NOT NULL,
  `Transaccion` int(11) NOT NULL,
  `Comision` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_transaccioncontador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_transaccioncontadormundi`
--

CREATE TABLE `se_transaccioncontadormundi` (
  `TransaccionContadorMundi` int(11) NOT NULL,
  `ContadorMundi` int(11) NOT NULL,
  `Transaccion` int(11) NOT NULL,
  `Comision` int(11) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_transaccioncontadormundi`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_transaccioncontadorsocio`
--

CREATE TABLE `se_transaccioncontadorsocio` (
  `TransaccionContadorSocio` int(11) NOT NULL,
  `ContadorSocio` int(11) NOT NULL,
  `Transaccion` int(11) NOT NULL,
  `PorcentajeRetorno` decimal(10,2) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `se_transaccioncontadorsocio`
--

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
(1, 1, NULL, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2017-04-14 00:00:00', 'view/default/assets/images/users/admin_profile.png', NULL, b'1');

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
-- Indices de la tabla `se_comision`
--
ALTER TABLE `se_comision`
  ADD PRIMARY KEY (`Comision`),
  ADD KEY `UsuarioRegistro` (`UsuarioRegistro`);

--
-- Indices de la tabla `se_contador`
--
ALTER TABLE `se_contador`
  ADD PRIMARY KEY (`Contador`),
  ADD KEY `Viajero` (`Viajero`);

--
-- Indices de la tabla `se_contadormundi`
--
ALTER TABLE `se_contadormundi`
  ADD PRIMARY KEY (`ContadorMundi`);

--
-- Indices de la tabla `se_contadorsocio`
--
ALTER TABLE `se_contadorsocio`
  ADD PRIMARY KEY (`ContadorSocio`),
  ADD KEY `Socio` (`Socio`);

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
-- Indices de la tabla `se_promocion`
--
ALTER TABLE `se_promocion`
  ADD PRIMARY KEY (`Promocion`),
  ADD KEY `Socio` (`Socio`);

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
-- Indices de la tabla `se_tipocambio`
--
ALTER TABLE `se_tipocambio`
  ADD PRIMARY KEY (`TipoCambio`);

--
-- Indices de la tabla `se_tipodocumento`
--
ALTER TABLE `se_tipodocumento`
  ADD PRIMARY KEY (`TipoDocumento`);

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
  ADD KEY `Viajero` (`Viajero`),
  ADD KEY `TipoDocumento` (`TipoDocumento`);

--
-- Indices de la tabla `se_transaccioncontador`
--
ALTER TABLE `se_transaccioncontador`
  ADD PRIMARY KEY (`TransaccionContador`),
  ADD KEY `Contador` (`Contador`),
  ADD KEY `Transaccion` (`Transaccion`),
  ADD KEY `Comision` (`Comision`);

--
-- Indices de la tabla `se_transaccioncontadormundi`
--
ALTER TABLE `se_transaccioncontadormundi`
  ADD PRIMARY KEY (`TransaccionContadorMundi`),
  ADD KEY `ContadorMundi` (`ContadorMundi`),
  ADD KEY `Transaccion` (`Transaccion`),
  ADD KEY `Comision` (`Comision`);

--
-- Indices de la tabla `se_transaccioncontadorsocio`
--
ALTER TABLE `se_transaccioncontadorsocio`
  ADD PRIMARY KEY (`TransaccionContadorSocio`),
  ADD KEY `ContadorSocio` (`ContadorSocio`),
  ADD KEY `Transaccion` (`Transaccion`);

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
-- AUTO_INCREMENT de la tabla `se_comision`
--
ALTER TABLE `se_comision`
  MODIFY `Comision` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_contador`
--
ALTER TABLE `se_contador`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_contadormundi`
--
ALTER TABLE `se_contadormundi`
  MODIFY `ContadorMundi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_contadorsocio`
--
ALTER TABLE `se_contadorsocio`
  MODIFY `ContadorSocio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_dashboard`
--
ALTER TABLE `se_dashboard`
  MODIFY `Dashboard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `se_menu`
--
ALTER TABLE `se_menu`
  MODIFY `Menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `se_movimiento`
--
ALTER TABLE `se_movimiento`
  MODIFY `Movimiento` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `Permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `se_persona`
--
ALTER TABLE `se_persona`
  MODIFY `Persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `se_promocion`
--
ALTER TABLE `se_promocion`
  MODIFY `Promocion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_rol`
--
ALTER TABLE `se_rol`
  MODIFY `Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `se_rolusuario`
--
ALTER TABLE `se_rolusuario`
  MODIFY `RolUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `se_rubro`
--
ALTER TABLE `se_rubro`
  MODIFY `Rubro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `se_socio`
--
ALTER TABLE `se_socio`
  MODIFY `Socio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_tipocambio`
--
ALTER TABLE `se_tipocambio`
  MODIFY `TipoCambio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_tipodocumento`
--
ALTER TABLE `se_tipodocumento`
  MODIFY `TipoDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `se_tipomovimiento`
--
ALTER TABLE `se_tipomovimiento`
  MODIFY `TipoMovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `se_transaccion`
--
ALTER TABLE `se_transaccion`
  MODIFY `Transaccion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_transaccioncontador`
--
ALTER TABLE `se_transaccioncontador`
  MODIFY `TransaccionContador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_transaccioncontadormundi`
--
ALTER TABLE `se_transaccioncontadormundi`
  MODIFY `TransaccionContadorMundi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_transaccioncontadorsocio`
--
ALTER TABLE `se_transaccioncontadorsocio`
  MODIFY `TransaccionContadorSocio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `se_usuario`
--
ALTER TABLE `se_usuario`
  MODIFY `Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `se_viajero`
--
ALTER TABLE `se_viajero`
  MODIFY `Viajero` int(11) NOT NULL AUTO_INCREMENT;
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
