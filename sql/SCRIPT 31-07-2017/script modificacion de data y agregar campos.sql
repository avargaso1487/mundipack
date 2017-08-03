
-- AGREGUE ESTOS DOS CAMPOS ---
ALTER TABLE se_viajero add FechaRegistro date default null;
ALTER TABLE se_viajero add ViajeroRegistro int default null;

-- MODIFIQUE EL TIPO DE DATO PARA EL ESTADO ---
ALTER TABLE se_persona MODIFY Estado INT;
ALTER TABLE se_usuario MODIFY Estado INT;
