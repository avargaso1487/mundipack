CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_dashboard`(IN `opcion` VARCHAR(300), IN `p_codigo` VARCHAR(8))
    NO SQL
BEGIN	

	IF opcion = 'opc_contar_ventas_pre_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_codigo);
		SELECT COUNT(*) AS total FROM se_transaccion WHERE Socio = @SOCIO AND (Estado = 0 OR Estado = 2);
	END IF; 
    
    IF opcion = 'opc_contar_tres_ventas_pre_rgistradas' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_codigo);
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
        
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_codigo);
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

		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_codigo);
		SELECT IFNULL(SUM(Importe), 0) AS respuesta FROM se_transaccion WHERE Socio = @SOCIO AND FechaTransaccion >= @v_FechaApertura AND FechaTransaccion < @v_FechaCierre and Estado = 1;
	END IF; 
    
    IF opcion = 'opc_total_numro_socios' THEN
		SELECT COUNT(*) AS respuesta FROM se_viajero;
	END IF;
    
    IF opcion = 'opc_venta_neta_socio' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_codigo);
        SELECT PorcentajeRetorno as respuesta FROM se_socio WHERE Socio = @SOCIO;
	END IF;
    
	IF opcion = 'opc_dashboard_paquete_adquirido' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
        SELECT P.Nombre AS respuesta FROM se_viajeropaquetesposibles PP
			INNER JOIN se_paquetes P ON P.Paquete = PP.Paquete
		WHERE PP.Viajero = @VIAJERO AND PP.Prioridad = 1;
	END IF;
    
    IF opcion = 'opc_dashboard_porcentaje_paquete' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
        SET @PAQUETE = (SELECT Paquete FROM se_viajeropaquetesposibles WHERE Viajero = @VIAJERO AND Prioridad = 1);
        SET @COMPRA = (SELECT CAST(MontoCompra AS DECIMAL(8,2)) FROM se_tipocambio WHERE Estado = 1);
		SET @PAGOS = (SELECT IFNULL(SUM(MontoCuota),0) AS PAGOS FROM se_pagocuotaviajero where Viajero = @VIAJERO AND Paquete = @PAQUETE);
		SET @ACUMULADO = (SELECT IFNULL(SUM(MontoAcumulado),0) AS ACUMULADO FROM se_contador WHERE Viajero = @VIAJERO AND Estado = 1);
		SET @TOTALACUMULADO = (SELECT @PAGOS + @ACUMULADO AS TOTALACUMULADO);
		SET @CAMBIO = (SELECT CAST(@TOTALACUMULADO / @COMPRA AS DECIMAL(8,3)));
		SET @PRECIO = (SELECT PrecioPromedio FROM se_paquetes WHERE Paquete = @PAQUETE AND Estado = 1);
		SET @PORCENTAJE = (SELECT (@CAMBIO*100)/@PRECIO);
		SELECT IFNULL(CAST(@PORCENTAJE AS DECIMAL(8,2)),0) AS PORCENTAJE;
	END IF;
	
    IF opcion = 'opc_dashboard_paquete_adquirido2' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
        SELECT P.Nombre AS respuesta FROM se_viajeropaquetesposibles PP
			INNER JOIN se_paquetes P ON P.Paquete = PP.Paquete
		WHERE PP.Viajero = @VIAJERO AND PP.Prioridad = 2;
	END IF;
    
    IF opcion = 'opc_dashboard_porcentaje_paquete2' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
        SET @PAQUETE = (SELECT Paquete FROM se_viajeropaquetesposibles WHERE Viajero = @VIAJERO AND Prioridad = 2);
        SET @COMPRA = (SELECT CAST(MontoCompra AS DECIMAL(8,2)) FROM se_tipocambio WHERE Estado = 1);
		SET @PAGOS = (SELECT IFNULL(SUM(MontoCuota),0) AS PAGOS FROM se_pagocuotaviajero where Viajero = @VIAJERO AND Paquete = @PAQUETE);
		SET @ACUMULADO = (SELECT IFNULL(SUM(MontoAcumulado),0) AS ACUMULADO FROM se_contador WHERE Viajero = @VIAJERO AND Estado = 1);
		SET @TOTALACUMULADO = (SELECT @PAGOS + @ACUMULADO AS TOTALACUMULADO);
		SET @CAMBIO = (SELECT CAST(@TOTALACUMULADO / @COMPRA AS DECIMAL(8,3)));
		SET @PRECIO = (SELECT PrecioPromedio FROM se_paquetes WHERE Paquete = @PAQUETE AND Estado = 1);
		SET @PORCENTAJE = (SELECT (@CAMBIO*100)/@PRECIO);
		SELECT IFNULL(CAST(@PORCENTAJE AS DECIMAL(8,2)),0) AS PORCENTAJE;
	END IF;
    
    IF opcion = 'opc_dashboard_paquete_adquirido3' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
        SELECT P.Nombre AS respuesta FROM se_viajeropaquetesposibles PP
			INNER JOIN se_paquetes P ON P.Paquete = PP.Paquete
		WHERE PP.Viajero = @VIAJERO AND PP.Prioridad = 3;
	END IF;
    
    IF opcion = 'opc_dashboard_porcentaje_paquete3' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
        SET @PAQUETE = (SELECT Paquete FROM se_viajeropaquetesposibles WHERE Viajero = @VIAJERO AND Prioridad = 3);
        SET @COMPRA = (SELECT CAST(MontoCompra AS DECIMAL(8,2)) FROM se_tipocambio WHERE Estado = 1);
		SET @PAGOS = (SELECT IFNULL(SUM(MontoCuota),0) AS PAGOS FROM se_pagocuotaviajero where Viajero = @VIAJERO AND Paquete = @PAQUETE);
		SET @ACUMULADO = (SELECT IFNULL(SUM(MontoAcumulado),0) AS ACUMULADO FROM se_contador WHERE Viajero = @VIAJERO AND Estado = 1);
		SET @TOTALACUMULADO = (SELECT @PAGOS + @ACUMULADO AS TOTALACUMULADO);
		SET @CAMBIO = (SELECT CAST(@TOTALACUMULADO / @COMPRA AS DECIMAL(8,3)));
		SET @PRECIO = (SELECT PrecioPromedio FROM se_paquetes WHERE Paquete = @PAQUETE AND Estado = 1);
		SET @PORCENTAJE = (SELECT (@CAMBIO*100)/@PRECIO);
		SELECT IFNULL(CAST(@PORCENTAJE AS DECIMAL(8,2)),0) AS PORCENTAJE;
	END IF;
    
    IF opcion = 'opc_dashboard_total_coutas' THEN		
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
        SELECT SUM(MontoCuota) as total FROM se_pagocuotaviajero WHERE Viajero = @VIAJERO AND Estado = 1;
	END IF;
    
    IF opcion = 'opc_obtener_comision' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo);
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = @PERSONA);
        SELECT IFNULL(SUM(MontoAcumulado), 0) as total FROM se_contador WHERE Viajero = @VIAJERO AND Estado = 1;
	END IF; 
    
    IF opcion = 'opc_noti_pago_traveler' THEN
		SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
		SET @CONTADOR = (SELECT Paquete FROM se_viajeropaquetecomprado WHERE Viajero = @VIAJERO);
        IF @CONTADOR > 0 THEN
			
			SET @DIAPAGO = (SELECT FechaPago FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
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
		SET @DIAPAGO = (SELECT FechaPago FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = p_codigo));
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
END