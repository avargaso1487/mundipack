use bdmundipack;
drop procedure IF EXISTS sp_gestion_transaccion;
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_transaccion`(IN `opcion` VARCHAR(30), IN `p_clienteID` INT, IN `p_tipoDoc` INT, IN `p_serie` VARCHAR(8), IN `p_numero` VARCHAR(8), IN `p_importe` DECIMAL(8,2), IN `p_fecha` DATE, IN `p_usuario` INT, IN `p_codigo` INT)
    NO SQL
BEGIN
	IF opcion = 'opc_registrar_transaccion' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        SET @PORCRETORNO = (SELECT PorcentajeRetorno FROM se_socio WHERE Socio = @SOCIO);
        SET @COMISION = (SELECT Porcentaje FROM se_comision WHERE Estado = 1);
        SET @VALIDADOC = (SELECT COUNT(*) FROM se_transaccion WHERE Serie = p_serie AND Numero = p_numero AND TipoDocumento = p_tipoDoc);
        
        SET @VALIDARCONTADOR = (SELECT COUNT(*) FROM se_contador WHERE Viajero = p_clienteID);
        
        IF (@VALIDADOC > 0) THEN 
			SELECT 'El documento ya ingresado ya existe' AS respuesta;
        ELSE
			IF (@VALIDARCONTADOR = 0) THEN
				INSERT INTO se_transaccion (Serie, Numero, Viajero, Socio, Importe, FechaTransaccion, Estado, TipoDocumento) 
					VALUES (p_serie, p_numero, p_clienteID, @SOCIO, p_importe, p_fecha, 1, p_tipoDoc);				
				SET @MONTORETORNO = (cast(p_importe as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100);		-- 75		
				SET @RETORNOVIAJERO = (cast(@MONTORETORNO as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100);	 			
				SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOVIAJERO);				
				INSERT INTO se_contador (Viajero, MontoAcumulado, Estado) VALUES (p_clienteID, @MONTOVIAJERO, 1);				
				SET @TRANSAC_ID = (SELECT MAX(Transaccion) FROM se_transaccion);
				SET @CONT_ID = (SELECT MAX(Contador) FROM se_contador);				
				INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, @TRANSAC_ID, @COMISION, 1);				
                INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('9', @SOCIO, now(), 1);
				SELECT 'Registro Correcto' AS respuesta;
            ELSE
				INSERT INTO se_transaccion (Serie, Numero, Viajero, Socio, Importe, FechaTransaccion, Estado, TipoDocumento)
					VALUES (p_serie, p_numero, p_clienteID, @SOCIO, p_importe, p_fecha, 1, p_tipoDoc);
				SET @MONTORETORNO = (cast(p_importe as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100);				
				SET @RETORNOVIAJERO = (cast(@MONTORETORNO as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100);				
				SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOVIAJERO);	
                
                SET @MONTOACUMULADO = (SELECT MontoAcumulado FROM se_contador WHERE Viajero = p_clienteID);
                SET @TRANSAC_ID = (SELECT MAX(Transaccion) FROM se_transaccion);
				SET @CONT_ID = (SELECT Contador FROM se_contador WHERE Viajero = p_clienteID);	
                
                UPDATE se_contador SET MontoAcumulado = (cast(@MONTOACUMULADO as decimal(8,2)) + @MONTOVIAJERO) WHERE Contador = @CONT_ID;
                INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, @TRANSAC_ID, @COMISION, 1);				
                INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('9', @SOCIO, now(), 1);
				SELECT 'Registro Correcto' AS respuesta;										
            END IF;                							
        END IF;
	END IF; 
    
    IF opcion = 'opc_update_transaccion' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        SET @PORCRETORNO = (SELECT PorcentajeRetorno FROM se_socio WHERE Socio = @SOCIO);
        SET @COMISION = (SELECT Porcentaje FROM se_comision WHERE Estado = 1);
        SET @VALIDADOC = (SELECT COUNT(*) FROM se_transaccion WHERE Serie = p_serie AND Numero = p_numero AND TipoDocumento = p_tipoDoc);
		SET @MONTOANTIGUO = (SELECT Importe FROM se_transaccion WHERE Transaccion = p_codigo);
        
			IF (@MONTOANTIGUO = p_importe) THEN
				UPDATE se_transaccion 
					SET Serie = p_serie,
					Numero = p_numero,
					-- Importe= p_importe,
					FechaTransaccion = p_fecha,
					TipoDocumento = p_tipoDoc
				WHERE Transaccion = p_codigo;
                INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('11', @SOCIO, now(), 1);
				SELECT 'Registro Correcto' AS respuesta;
			ELSE
				SET @MONTORETORNOANTIGUO = (cast(@MONTOANTIGUO as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100); -- 75			
				SET @RETORNOVIAJEROANTIGUO = (cast(@MONTORETORNOANTIGUO as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100); -- 15			
				SET @MONTOVIAJEROANTIGUO = (@MONTORETORNOANTIGUO - @RETORNOVIAJEROANTIGUO); -- 60
                
                SET @MONTOACUMULADOANTIGUO = (SELECT MontoAcumulado FROM se_contador WHERE Viajero = p_clienteID); -- 120               
				SET @CONT_ID = (SELECT Contador FROM se_contador WHERE Viajero = p_clienteID); -- 5
                
                UPDATE se_contador SET MontoAcumulado = (cast(@MONTOACUMULADOANTIGUO as decimal(8,2)) - cast(@MONTOVIAJEROANTIGUO as decimal(8,2))) WHERE Contador = @CONT_ID;
                -- MontoAcumulado = 60
                UPDATE se_transaccion 
					SET Serie = p_serie,
					Numero = p_numero,
					Importe= p_importe,
					FechaTransaccion = p_fecha,
					TipoDocumento = p_tipoDoc
				WHERE Transaccion = p_codigo;
				
                SET @MONTORETORNO = (cast(p_importe as decimal(8,2))*(cast(@PORCRETORNO as decimal(8,2)))/100); -- 50		
				SET @RETORNOVIAJERO = (cast(@MONTORETORNO as decimal(8,2))*(cast(@COMISION as decimal(8,2)))/100); -- 10			
				SET @MONTOVIAJERO = (@MONTORETORNO - @RETORNOVIAJERO); -- 40
                
                SET @MONTOACUMULADO = (SELECT MontoAcumulado FROM se_contador WHERE Viajero = p_clienteID); -- 60          
				SET @CONT_ID = (SELECT Contador FROM se_contador WHERE Viajero = p_clienteID);
                UPDATE se_contador SET MontoAcumulado = (cast(@MONTOACUMULADO as decimal(8,2)) + @MONTOVIAJERO) WHERE Contador = @CONT_ID;
                
                -- INSERT INTO se_transaccioncontador (Contador, Transaccion, Comision, Estado) VALUES (@CONT_ID, p_codigo, @COMISION, 1);				
                 UPDATE se_transaccioncontador 
					 SET Contador = @CONT_ID, Comision = @COMISION WHERE Transaccion = p_codigo;
				INSERT INTO se_movimiento (TipoMovimiento, Socio, FechaMovimiento, Estado) VALUES ('11', @SOCIO, now(), 1);
				SELECT 'Registro Correcto' AS respuesta;
            END IF;
        END IF;
		
        	
    
     
END$$

DELIMITER ;