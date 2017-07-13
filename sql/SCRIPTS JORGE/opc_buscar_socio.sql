use bdmundipack;
drop procedure IF EXISTS sp_buscar_socio;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_socio`(IN `opcion` VARCHAR(30), IN `p_dni` VARCHAR(8))
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
		select t.Transaccion, t.Serie, t.Numero, t.Importe, t.FechaTransaccion, t.TipoDocumento, p.DNI, CONCAT(p.Nombres, ' ', Apellidos) from se_transaccion t inner join se_viajero v on v.Viajero = t.Viajero inner join se_persona p on p.Persona = v.Persona where t.Transaccion = p_dni;
	END IF; 
END$$

DELIMITER ;
