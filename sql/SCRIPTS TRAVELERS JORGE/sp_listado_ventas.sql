CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listado_ventas`(IN `p_usuario` INT, IN `opcion` VARCHAR(200), IN `p_codigo` INT)
    NO SQL
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
    
END