CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestionar_notificaciones`(IN `opcion` VARCHAR(30))
    NO SQL
BEGIN
	IF opcion = 'opc_noti_pre_pago_socio' THEN
		SELECT COUNT(*) AS respuesta FROM se_pagocuotasocio WHERE Estado = 0;			
    END IF; 
    
    IF opcion = 'opc_noti_pre_pago_traveler' THEN
		SELECT COUNT(*) AS respuesta FROM se_pagocuotaviajero WHERE Estado = 0;		
    END IF;
    
    IF opcion = 'opc_item_noti_pago_socio' THEN
		SELECT S.NombreComercial AS NOMBRE, PS.Monto AS IMPORTE FROM se_pagocuotasocio PS
			INNER JOIN se_socio S ON S.Socio = PS.Socio
		WHERE PS.Estado = 0 ORDER BY PS.PagoCuotaSocio LIMIT 3;			
    END IF;
    
    IF opcion = 'opc_item_noti_pago_traveler' THEN
		SELECT CONCAT(P.Nombres,' ',P.Apellidos) AS NOMBRE, PV.MontoCuota AS IMPORTE FROM se_pagocuotaviajero PV 
			INNER JOIN se_viajero V ON V.Viajero = PV.Viajero
			INNER JOIN se_persona P ON P.Persona = V.Persona
		WHERE PV.Estado = 0 ORDER BY PV.PagoCuotaViajero DESC LIMIT 3;
    END IF;
    
    
    
END