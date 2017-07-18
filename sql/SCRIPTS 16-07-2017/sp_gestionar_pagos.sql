CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestionar_pagos`(
	IN `opcion` VARCHAR(300), 
    IN `p_operacion` VARCHAR(300), 
    IN `p_monto` DOUBLE, 
    IN `p_fecha` DATE, 
    IN `p_pagoID` INT,
    IN `p_usuario` INT)
    NO SQL
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
        
        
END