CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_combos`(IN `opcion` VARCHAR(30))
    NO SQL
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
    
    
    
END