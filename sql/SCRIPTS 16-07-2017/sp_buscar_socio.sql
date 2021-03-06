CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_socio`(IN `opcion` VARCHAR(300), IN `p_dni` VARCHAR(8))
    NO SQL
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
    
    
    
END