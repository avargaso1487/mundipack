CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_transaccion`(IN `opcion` VARCHAR(30), IN `p_clienteID` INT, IN `p_tipoDoc` INT, IN `p_serie` VARCHAR(8), IN `p_numero` VARCHAR(8), IN `p_importe` DECIMAL(8,2), IN `p_fecha` DATE, IN `p_usuario` INT, IN `p_codigo` INT)
    NO SQL
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
			SET @TIPODOC =(SELECT TipoDocumento FROM se_transaccion WHERE Transaccion = p_codigo);
            SET @SERIE =(SELECT Serie FROM se_transaccion WHERE Transaccion = p_codigo);
            SET @NUMERO =(SELECT Numero FROM se_transaccion WHERE Transaccion = p_codigo);
			
            IF @TIPODOC = p_tipoDoc AND @SERIE = p_serie AND @NUMERO = p_numero THEN
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
					SELECT '0' AS respuesta;
				END IF;
            END IF;
                        
				
				
            
            
        END IF;
        	
    
     
END