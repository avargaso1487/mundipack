CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_ofertas`(IN `opcion` VARCHAR(300), IN `p_descripcion` VARCHAR(300), IN `p_fechaInicio` DATE, IN `p_fechaFin` DATE, IN `p_stock` VARCHAR(11), IN `p_ruta` VARCHAR(200), IN `p_usuario` INT, IN `p_codigo` VARCHAR(5), IN `p_porcentaje` VARCHAR(1))
    NO SQL
BEGIN
	IF opcion = 'opc_add_oferta' THEN
		SET @SOCIOID = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		INSERT INTO se_promocion (Descripcion, FechaInicio, FechaFin, Stock, FechaIngreso, Socio, Imagen, Estado, Porcentaje) 
			VALUES (p_descripcion, p_fechaInicio, p_fechaFin, p_stock, curdate(), @SOCIOID, p_ruta, 1, p_porcentaje);            
    END IF;
    IF opcion = 'opc_total_ofertas' THEN
		SET @SOCIOID = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT COUNT(*) AS total FROM se_promocion WHERE Socio = @SOCIOID;
	END IF; 
    IF opcion = 'opc_listar_oferta' THEN
		SET @SOCIOID = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
		SELECT 
			Promocion AS PROMO_ID,
            Descripcion AS DESCRIPCION,
            FechaInicio AS FECHA_INICIO,
            FechaFin AS FECHA_FIN,
            Stock AS STOCK,
            Imagen AS IMAGEN,
            Estado AS ESTADO,
            Porcentaje AS PORCENTAJE
		FROM se_promocion WHERE Socio = @SOCIOID;
	END IF;
    IF opcion = 'opc_eliminar_oferta' THEN		
		UPDATE se_promocion SET Estado = 0 WHERE Promocion = p_codigo;
	END IF;
    IF opcion = 'opc_activar_oferta' THEN		
		UPDATE se_promocion SET Estado = 1 WHERE Promocion = p_codigo;
	END IF;
    IF opcion = 'opc_obtener_oferta' THEN		
		SELECT 
			Promocion AS PROMO_ID,
            Descripcion AS DESCRIPCION,
            FechaInicio AS FECHA_INICIO,
            FechaFin AS FECHA_FIN,
            Stock AS STOCK,
            Imagen AS IMAGEN,
            Estado AS ESTADO,
            Porcentaje AS PORCENTAJE
		FROM se_promocion WHERE Promocion = p_codigo;
	END IF;
    IF opcion = 'opc_update_oferta' THEN	
		IF p_ruta = '' THEN 
			UPDATE se_promocion			
				SET Descripcion = p_descripcion,
				 FechaInicio = p_fechaInicio,
				 FechaFin = p_fechaFin,
				 Stock = p_stock,              
				 Porcentaje = p_porcentaje
			WHERE Promocion = p_codigo;
        ELSE
			UPDATE se_promocion			
				SET Descripcion = p_descripcion,
				 FechaInicio = p_fechaInicio,
				 FechaFin = p_fechaFin,
				 Stock = p_stock,  
				 Imagen = p_ruta,
				 Porcentaje = p_porcentaje
			WHERE Promocion = p_codigo;
        END IF;
		
	END IF;
    
    
    
END