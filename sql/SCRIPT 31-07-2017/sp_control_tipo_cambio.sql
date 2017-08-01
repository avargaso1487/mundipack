CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_tipo_cambio`(IN `opcion` VARCHAR(30), IN `p_montoCompra` DECIMAL(8,2), IN `p_montoVenta` DECIMAL(8,2))
    NO SQL
BEGIN
	IF opcion = 'opc_grabar_tipo_cambio' THEN
		SET @INICIAR = (SELECT COUNT(*) FROM se_tipocambio);
        IF (@INICIAR = 0) THEN 
			INSERT INTO se_tipocambio (MontoCompra, MontoVenta, FechaRegistro, Estado) VALUES (p_montoCompra,p_montoVenta,NOW(),1);
            SELECT '1' AS 'respuesta';
        ELSE 
			SET @VALIDAR = (SELECT COUNT(*) FROM se_tipocambio WHERE FechaRegistro = CURDATE());
			IF(@VALIDAR = 0) THEN
				SET @TIPO_ID = (SELECT MAX(TipoCambio) FROM se_tipocambio);
                UPDATE se_tipocambio SET Estado = 0 WHERE TipoCambio = @TIPO_ID;
				INSERT INTO se_tipocambio (MontoCompra, MontoVenta, FechaRegistro, Estado) VALUES (p_montoCompra,p_montoVenta,NOW(),1);
				SELECT '1' AS 'respuesta';
			ELSE
				SET @TIPO_ID = (SELECT TipoCambio FROM se_tipocambio WHERE FechaRegistro = CURDATE());
				UPDATE se_tipocambio SET MontoCompra = p_montoCompra, MontoVenta = p_montoVenta WHERE TipoCambio = @TIPO_ID;
                SELECT '0' AS 'respuesta';
			END IF;
        END IF;					
    END IF;
    IF opcion = 'opc_ver_tipo_cambio' THEN
		SET @TOTAL = (SELECT COUNT(*) FROM se_tipocambio WHERE Estado = 1);
		SET @VERIFICAR = (SELECT COUNT(*) FROM se_tipocambio WHERE FechaRegistro = CURDATE());
        IF @TOTAL > 0 THEN
			IF (@VERIFICAR > 0) THEN
				SELECT MontoCompra, MontoVenta, '1' AS Respuesta FROM se_tipocambio WHERE FechaRegistro = CURDATE() AND  Estado = 1;
			ELSE
				SELECT MontoCompra, MontoVenta, '0' AS Respuesta FROM se_tipocambio WHERE FechaRegistro = CURDATE()-1 AND Estado = 1;
			END IF;
        ELSE
			SELECT '2' AS respuesta;
        END IF;
		
	END IF;
END