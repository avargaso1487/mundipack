/*EN LOCAL*/
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_perfil_travelers`(
	IN `opcion` VARCHAR(300),
    IN `p_usuario` VARCHAR(5),
    IN `p_fijo` VARCHAR(500),
    IN `p_movil` VARCHAR(500),
    IN `p_password` VARCHAR(500),
    IN `p_fotoPerfil` TEXT)
    NO SQL
BEGIN
	IF opcion = 'opc_obtener_perfil_travelers' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
        SELECT 
			P.Nombres AS NOMBRES,
			P.Apellidos AS APELLIDOS,
            P.Direccion AS DIRECCION,
			P.DNI AS DNI,
			P.Email AS EMAIL,
			P.FechaNacimiento AS NACIMIENTO,
			P.TelefonoFijo AS FIJO,
			P.TelefonoMovil AS MOVIL,
			V.NroPasaporte AS PASAPORTE,
            U.Imagen AS IMAGEN
		FROM se_persona P 
		INNER JOIN se_viajero V ON V.Persona = P.Persona
        INNER JOIN se_usuario U ON U.Persona = P.Persona
		WHERE P.Persona = @PERSONA;	
	END IF;    	
    
    IF opcion = 'opc_update_perfil_socio' THEN
		SET @PERSONA = (SELECT Persona FROM se_usuario WHERE Usuario = p_usuario);
        IF p_password = 'd41d8cd98f00b204e9800998ecf8427e' THEN
			IF p_fotoPerfil = '' THEN
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;
            ELSE
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;

				UPDATE se_usuario 
					SET Imagen = p_fotoPerfil
				WHERE Usuario = p_usuario;
            END IF;			
        ELSE
			IF p_fotoPerfil = '' THEN
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;
                
                UPDATE se_usuario 					
                    SET Password = p_password
				WHERE Usuario = p_usuario;
                
            ELSE
				UPDATE se_persona
					SET TelefonoFijo = p_fijo,
					TelefonoMovil = p_movil    
				WHERE Persona = @PERSONA;

				UPDATE se_usuario 
					SET Imagen = p_fotoPerfil,
                    Password = p_password
				WHERE Usuario = p_usuario;
            END IF;
        END IF;
	END IF;    	
END