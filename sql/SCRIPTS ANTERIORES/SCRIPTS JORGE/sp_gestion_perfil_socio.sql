use bdmundipack;
drop procedure IF EXISTS sp_gestion_perfil_socio;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_perfil_socio`(
	IN `opcion` VARCHAR(30), 
    IN `p_usuario` VARCHAR(8), 
    IN `p_contacto` VARCHAR(30), 
    IN `p_atencion` VARCHAR(30), 
    IN `p_password` VARCHAR(300), 
    IN `p_foto_perfil` text, 
    IN `p_foto_carta` text)
    NO SQL
BEGIN
	IF opcion = 'opc_obtener_perfil_socio' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);
        select 
			S.RazonSocial, 
			S.RUC, 
			S.NombreComercial,
			R.Descripcion,
			S.Direccion,
			S.Email,
			S.TelefonoContacto,
			S.TelefonoAtencion,
			U.Imagen
		from se_socio S 
			INNER JOIN se_rubro R ON R.Rubro = S.Rubro
			INNER JOIN se_usuario U ON U.Socio = S.Socio 
		where S.socio =  @SOCIO;				
	END IF;    	
    IF opcion = 'opc_update_perfil_socio' THEN
		SET @SOCIO = (SELECT Socio FROM se_usuario WHERE Usuario = p_usuario);        
        IF (p_password = 'd41d8cd98f00b204e9800998ecf8427e') THEN
			IF (p_foto_perfil = '' OR p_foto_carta = '') THEN
				IF (p_foto_carta = '' AND p_foto_perfil <> '') THEN
					UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion					
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil
					WHERE Usuario = p_usuario;
				ELSE 
					IF (p_foto_perfil = '' AND p_foto_carta <> '') THEN 
						UPDATE se_socio 
							SET TelefonoContacto = p_contacto,
							TelefonoAtencion = p_atencion,
							CartaPresentacion = p_foto_carta
						WHERE Socio = @SOCIO;	
					ELSE 
						IF (p_foto_perfil = '' AND p_foto_carta = '') THEN
							UPDATE se_socio 
								SET TelefonoContacto = p_contacto,
								TelefonoAtencion = p_atencion				
							WHERE Socio = @SOCIO;													
                        END IF;
					END IF;
				END IF;	
			ELSE 
				UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion,
                        CartaPresentacion = p_foto_carta
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil,
                        Password = p_password
					WHERE Usuario = p_usuario;
			END IF;
		ELSE 
			IF (p_foto_perfil = '' OR p_foto_carta = '') THEN
				IF (p_foto_carta = '' AND p_foto_perfil <> '') THEN
					UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion					
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil,
                        Password = p_password
					WHERE Usuario = p_usuario;
				ELSE 
					IF (p_foto_perfil = '' AND p_foto_carta <> '') THEN 
						UPDATE se_socio 
							SET TelefonoContacto = p_contacto,
							TelefonoAtencion = p_atencion,
							CartaPresentacion = p_foto_carta
						WHERE Socio = @SOCIO;
                        
                        UPDATE se_usuario 
							SET Password = p_password
						WHERE Usuario = p_usuario;
                                                
					ELSE 
						IF (p_foto_perfil = '' AND p_foto_carta = '') THEN
							UPDATE se_socio 
								SET TelefonoContacto = p_contacto,
								TelefonoAtencion = p_atencion				
							WHERE Socio = @SOCIO;	
                            
                            UPDATE se_usuario 
								SET Password = p_password
							WHERE Usuario = p_usuario;                           
                        END IF;
					END IF;
				END IF;	
			ELSE 
				UPDATE se_socio 
						SET TelefonoContacto = p_contacto,
						TelefonoAtencion = p_atencion,
                        CartaPresentacion = p_foto_carta
					WHERE Socio = @SOCIO;
					
					UPDATE se_usuario 
						SET Imagen = p_foto_perfil,
                        Password = p_password
					WHERE Usuario = p_usuario;
			END IF;            
		END IF;		        
	END IF;    	
END$$

DELIMITER ;
