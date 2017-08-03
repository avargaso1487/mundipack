CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_control_viajero_recomentado`(
	IN `ve_opcion` VARCHAR(300), 
    IN `ve_viajeroNombre` VARCHAR(300), 
    IN `viajeroApellidos` VARCHAR(300), 
    IN `ve_viajeroDNI` VARCHAR(300), 
    IN `ve_viajeroDireccion` VARCHAR(300), 
    IN `ve_viajeroNacimiento` VARCHAR(300), 
    IN `ve_viajeroTelefonoFijo` VARCHAR(300), 
    IN `ve_viajeroTelefonoCelular` VARCHAR(300), 
    IN `ve_viajeroEmail` VARCHAR(300), 
    IN `ve_viajeroNroPasaporte` VARCHAR(300), 
    IN `ve_viajeroAbierto` BOOLEAN,
    IN `ve_usuario` INT)
    NO SQL
BEGIN
	IF ve_opcion = 'opc_contar_viajeros_recomendados' THEN
		SELECT count(v.Viajero) AS 'total' FROM se_viajero v inner join se_persona p on p.Persona = v.Persona WHERE p.Estado = 2;
	END IF;  
    IF ve_opcion = 'opc_listar_viajeros_recomendados' THEN
		select v.Viajero as viajeroID, p.Nombres as viajeroNombre,
          p.Apellidos as viajeroApellidos, p.DNI as viajeroDNI, p.TelefonoMovil as viajeroCelular, v.NroPasaporte as viajeroNroPasaporte, 'Cuzco' as viajeroPaqueteObjetivo, 0 as viajeroAcumulado,
             1 as viajeroEstadoPago, (case when v.ViajeroAbierto = 0 THEN 'NO' ELSE 'SI' end) as viajeroAbierto
        from se_viajero v
          inner join se_persona p on v.Persona = p.Persona          
        where p.Estado = 2;     
	END IF;  
    
    IF ve_opcion = 'opc_grabar_viajero_recomendado' THEN
    	insert into se_persona(Nombres, Apellidos, DNI, Direccion, FechaNacimiento, TelefonoFijo, TelefonoMovil, Email, Estado) values (ve_viajeroNombre, viajeroApellidos, ve_viajeroDNI, ve_viajeroDireccion, ve_viajeroNacimiento, ve_viajeroTelefonoFijo, ve_viajeroTelefonoCelular, ve_viajeroEmail, 2);
        set @idpersona = (select Persona from se_persona where DNI = ve_viajeroDNI);
        SET @VIAJERO = (SELECT Viajero FROM se_viajero WHERE Persona = (SELECT Persona FROM se_usuario WHERE Usuario = ve_usuario));
        insert into se_viajero(Persona, NroPasaporte, ViajeroAbierto, FechaRegistro, ViajeroRegistro) values(@idpersona, ve_viajeroNroPasaporte, ve_viajeroAbierto, CURDATE(), @VIAJERO);
        INSERT INTO se_usuario(Persona, Login, Password, FechaRegistro, Imagen, Estado)
         	values(@idpersona, ve_viajeroDNI, md5('123456'), CURRENT_DATE(), 'view/default/assets/images/users/traveler_default_profile.png', 2);
         set @idusuario = (SELECT Usuario from se_usuario where Persona = @idpersona);
         INSERT INTO se_rolusuario(rol, usuario, estado)
         	VALUES(3, @idusuario, 1);
         set @idviajero = (SELECT Viajero from se_viajero where Persona = @idpersona);
         INSERT INTO se_movimiento(Tipomovimiento, Socio, FechaMovimiento, Estado) values(5, @idviajero, now(), 1);
        select 1 as 'resultado';
    END IF;

END