CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_combos`(IN `opcion` VARCHAR(30))
    NO SQL
BEGIN
	IF opcion = 'opc_listar_tipo_documento' THEN
		SELECT * FROM se_tipodocumento;
	END IF; 
    IF opcion = 'opc_listar_socios' THEN
		SELECT * FROM se_socio;
	END IF;
    
END