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
		SET @TASAMUNDI = (SELECT Porcentaje FROM se_comision WHERE Estado = 1);
		SELECT 
			S.NombreComercial AS NOMBRE, 
			S.TelefonoAtencion AS TELEFONO, 
			S.CartaPresentacion AS CARTA_PRESENTACION, 
			S.Direccion AS DIRECCION,
			U.Imagen AS FOTO_PERFIL,
            S.PorcentajeRetorno - @TASAMUNDI AS PORCENTAJE 
		FROM se_socio S
			LEFT JOIN se_usuario U ON U.Socio = S.Socio
		WHERE S.Estado = 1 LIMIT 4;
	END IF; 	  
    
    IF opcion = 'opc_get_all_socios' THEN
		SET @TASAMUNDI = (SELECT Porcentaje FROM se_comision WHERE Estado = 1);
		SELECT 
			S.NombreComercial AS NOMBRE, 
			S.TelefonoAtencion AS TELEFONO, 
			S.CartaPresentacion AS CARTA_PRESENTACION, 
			S.Direccion AS DIRECCION,
			U.Imagen AS FOTO_PERFIL,
            S.PorcentajeRetorno - @TASAMUNDI AS PORCENTAJE 
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
		SELECT COUNT(*) AS total FROM se_pagocuotaviajero WHERE Viajero = @VIAJERO;
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
			PA.Nombre AS PAQUETE,
            Imagen AS IMAGEN
		FROM se_viajero V 			
			INNER JOIN se_persona P ON P.Persona = V.Persona 
			INNER JOIN se_usuario U ON U.Persona = P.Persona
            INNER JOIN se_viajeropaquetesposibles PP ON PP.Viajero = V.Viajero
            INNER JOIN se_paquetes PA ON PA.Paquete = PP.Paquete
		WHERE P.Persona <> @PERSONA AND V.ViajeroAbierto = 1 AND PP.Prioridad = 1 AND PP.Estado = 1 LIMIT 4;
	END IF; 
    
    IF opcion = 'opc_get_travelers_abiertos' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SELECT 
			CONCAT(P.Nombres,' ',P.Apellidos) AS TRAVELER,
			P.TelefonoFijo AS TELEFONO,
			P.Email AS EMAIL,
			PA.Nombre AS PAQUETE,
            Imagen AS IMAGEN
		FROM se_viajero V 			
			INNER JOIN se_persona P ON P.Persona = V.Persona 
			INNER JOIN se_usuario U ON U.Persona = P.Persona
            INNER JOIN se_viajeropaquetesposibles PP ON PP.Viajero = V.Viajero
            INNER JOIN se_paquetes PA ON PA.Paquete = PP.Paquete
		WHERE P.Persona <> @PERSONA AND V.ViajeroAbierto = 1 AND PP.Prioridad = 1 AND PP.Estado = 1;
	END IF; 
    	
    IF opcion = 'opc_obtener_comision' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
        SELECT IFNULL(SUM(MontoAcumulado), 0) as total FROM se_contador WHERE Viajero = @VIAJERO AND Estado = 1;
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
    
    IF opcion = 'opc_contar_paquetes' THEN		
		SELECT COUNT(*) AS total FROM se_paquetes;
	END IF; 
    
    IF opcion = 'opc_listar_paquetes' THEN		
		SELECT * FROM se_paquetes;
	END IF;
    
    IF opcion = 'opc_obtener_paquete' THEN		
		SELECT * FROM se_paquetes WHERE Paquete = p_dni;
	END IF;
    
    
    IF opcion = 'opc_contar_paquetes_traveler' THEN		
		SELECT COUNT(*) AS total FROM se_paquetes WHERE Estado = 1;
	END IF; 
    
    IF opcion = 'opc_listar_paquetes_traveler' THEN		
		SELECT * FROM se_paquetes WHERE Estado = 1;
	END IF;
    
    
    IF opcion = 'opc_contar_paquetes_adquiridos' THEN	
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni));
		SELECT COUNT(*) as total FROM se_viajeropaquetecomprado PC 
			INNER JOIN se_paquetes P ON P.Paquete = PC.Paquete WHERE PC.Viajero = @VIAJERO AND P.Estado = 1;		
	END IF; 
    
    IF opcion = 'opc_listar_paquetes_adquiridos' THEN
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni));
        SET @PAQUETE = (SELECT Paquete FROM se_viajeropaquetecomprado WHERE Viajero = @VIAJERO);
		SELECT P.Paquete, P.Nombre AS Nombre, P.Descripcion as Descripcion , P.PrecioPromedio AS Precio, 'C' AS Estado FROM se_viajeropaquetecomprado PC 
			INNER JOIN se_paquetes P ON P.Paquete = PC.Paquete WHERE PC.Viajero = @VIAJERO AND P.Estado = 1;
		-- UNION
		/* SELECT  P.Nombre AS NOMBRE, P.Precio AS PRECIO, 'P' AS ESTADO FROM se_viajeropaquetesposibles VP 
			INNER JOIN se_paquetes P ON P.Paquete = VP.Paquete
			WHERE VP.Paquete <> @PAQUETE AND VP.Viajero = @VIAJERO AND P.Estado = 1; */
	END IF;  
    
    IF opcion = 'opc_noti_pago_traveler' THEN
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni));
		SET @CONTADOR = (SELECT Paquete FROM se_viajeropaquetecomprado WHERE Viajero = @VIAJERO);
        IF @CONTADOR > 0 THEN
			
			SET @DIAPAGO = (SELECT FechaPago FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni));
			SET @v_FechaActual = NOW();    
			SET @v_dia_cierre_bd = @DIAPAGO;
			SET @v_anioActual = YEAR(@v_FechaActual);
			SET @v_mesActual = MONTH(@v_FechaActual)+1;
			SET @v_diaActual = DAY(@v_FechaActual);
			SET @v_diaApertura = @v_dia_cierre_bd;
			SET @v_mesApertura = (CASE WHEN @v_dia_cierre_bd <= @v_diaActual THEN @v_mesActual ELSE @v_mesActual - 1 END);
			SET @v_anioApertura = (CASE @v_mesApertura WHEN 0 THEN (@v_anioActual - 1) ELSE @v_anioActual END);
			SET @v_mesApertura = (CASE @v_mesApertura WHEN 0 THEN 12 ELSE @v_mesApertura END);
			SET @v_FechaApertura = CAST(CONCAT(CAST(@v_anioApertura AS CHAR), '/',CAST(@v_mesApertura AS CHAR), '/',CAST(@v_diaApertura AS CHAR)) AS DATE);
			SET @v_FechaAlerta = DATE_ADD(CAST(@v_FechaApertura as datetime), INTERVAL -7 DAY);
				
            IF CAST(curdate() as DATE) >= CAST(@v_FechaAlerta as DATE) AND CAST(curdate() as DATE) < CAST(@v_FechaApertura as DATE) THEN            
				SELECT '1' AS respuesta;
            ELSE
				SELECT '0' AS respuesta;
            END IF;			
        ELSE
			SELECT '0' AS respuesta;
        END IF;
	END IF; 
    
    IF opcion = 'opc_dias_faltantes_pago' THEN		
		SET @DIAPAGO = (SELECT FechaPago FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni));
		SET @v_FechaActual = NOW();    
		SET @v_dia_cierre_bd = @DIAPAGO;
		SET @v_anioActual = YEAR(@v_FechaActual);
		SET @v_mesActual = MONTH(@v_FechaActual)+1;
		SET @v_diaActual = DAY(@v_FechaActual);
		SET @v_diaApertura = @v_dia_cierre_bd;
		SET @v_mesApertura = (CASE WHEN @v_dia_cierre_bd <= @v_diaActual THEN @v_mesActual ELSE @v_mesActual - 1 END);
		SET @v_anioApertura = (CASE @v_mesApertura WHEN 0 THEN (@v_anioActual - 1) ELSE @v_anioActual END);
		SET @v_mesApertura = (CASE @v_mesApertura WHEN 0 THEN 12 ELSE @v_mesApertura END);
		SET @v_FechaApertura = CAST(CONCAT(CAST(@v_anioApertura AS CHAR), '/',CAST(@v_mesApertura AS CHAR), '/',CAST(@v_diaApertura AS CHAR)) AS DATE);
		SET @v_FechaAlerta = DATE_ADD(CAST(@v_FechaApertura as datetime), INTERVAL -7 DAY);	
                
        SELECT DATEDIFF(CAST(@v_FechaAlerta as DATE),CAST(curdate() as DATE)) AS respuesta;
	END IF;
        
	IF opcion = 'opc_dashboard_paquete_adquirido' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni));
        SELECT P.Nombre AS respuesta FROM se_viajeropaquetesposibles PP
			INNER JOIN se_paquetes P ON P.Paquete = PP.Paquete
		WHERE PP.Viajero = @VIAJERO AND PP.Prioridad = 1 AND PP.Estado = 1;
	END IF;
    
    IF opcion = 'opc_dashboard_porcentaje_paquete' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_dni));
        SET @PAQUETE = (SELECT Paquete FROM se_viajeropaquetesposibles WHERE Viajero = @VIAJERO AND Prioridad = 1 AND Estado = 1);
        SET @COMPRA = (SELECT CAST(MontoCompra AS DECIMAL(8,2)) FROM se_tipocambio WHERE Estado = 1);
		SET @PAGOS = (SELECT IFNULL(SUM(MontoCuota),0) AS PAGOS FROM se_pagocuotaviajero where Viajero = @VIAJERO AND Paquete = @PAQUETE);
		SET @ACUMULADO = (SELECT IFNULL(SUM(MontoAcumulado),0) AS ACUMULADO FROM se_contador WHERE Viajero = @VIAJERO AND Estado = 1);
		SET @TOTALACUMULADO = (SELECT @PAGOS + @ACUMULADO AS TOTALACUMULADO);
		SET @CAMBIO = (SELECT CAST(@TOTALACUMULADO / @COMPRA AS DECIMAL(8,3)));
		SET @PRECIO = (SELECT PrecioPromedio FROM se_paquetes WHERE Paquete = @PAQUETE AND Estado = 1);
		SET @PORCENTAJE = (SELECT (@CAMBIO*100)/@PRECIO);
		SELECT  CAST(@PORCENTAJE AS DECIMAL(8,2)) AS PORCENTAJE;
	END IF;
        
END