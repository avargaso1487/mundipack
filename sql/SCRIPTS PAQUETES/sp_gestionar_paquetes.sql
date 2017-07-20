CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestionar_paquetes`(
	IN `opcion` VARCHAR(300), 
    IN `p_nombre` VARCHAR(300), 
    IN `p_descripcion` TEXT, 
    IN `p_precio` DOUBLE, 
    IN `p_paqueteID` INT)
    NO SQL
BEGIN
	IF opcion = 'opc_registrar_paquete' THEN
		INSERT se_paquetes (Nombre, Descripcion, Precio, Estado) VALUES (p_nombre, p_descripcion, p_precio, 1);
        SELECT 'Registro Correcto' as respuesta;
	END IF;   
    
    IF opcion = 'opc_update_paquete' THEN
		UPDATE se_paquetes
			SET Nombre = p_nombre,
            Descripcion = p_descripcion,
            Precio = p_precio
        WHERE Paquete = p_paqueteID;
        SELECT 'Registro Correcto' as respuesta;
	END IF; 
    
    IF opcion = 'opc_eliminar_paquete' THEN
		UPDATE se_paquetes
			SET Estado = 0
        WHERE Paquete = p_paqueteID;
        SELECT 'El registro fue desactivado correctamente' as respuesta;
	END IF; 
    
    IF opcion = 'opc_activar_paquete' THEN
		UPDATE se_paquetes
			SET Estado = 1
        WHERE Paquete = p_paqueteID;
        SELECT 'El registro fue activado correctamente' as respuesta;
	END IF; 
    
    
END