use bdmundipack;

-- CREACION DE TABLA TIPO_DOCUENTO
CREATE TABLE se_tipoDocumento (
	TipoDocumento		int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Descripcion 		VARCHAR(50) NOT NULL    
);

-- INSERTAR DATOS TIPO DOCUMENTO
INSERT INTO se_tipodocumento (Descripcion) values ('Boleta');
INSERT INTO se_tipodocumento (Descripcion) values ('Factura');


-- AGREGAR CAMPO Y CLAVE FORANEA DE TIPO_DOCUMENTO A LA TABLA TRASACCION
ALTER TABLE se_transaccion ADD TipoDocumento INT NOT NULL;

ALTER TABLE se_transaccion 
ADD FOREIGN KEY (TipoDocumento) REFERENCES se_tipoDocumento (TipoDocumento) 
ON UPDATE CASCADE;

-- CREACION DE TABLA TIPO_CAMBIO
CREATE TABLE se_tipoCambio (
	TipoCambio 			int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    MontoCompra 		DECIMAL(8,2) NOT NULL,
    MontoVenta 			DECIMAL(8,2) NOT NULL,
    FechaRegistro 		DATE NOT NULL,
    Estado 				BIT NOT NULL
);

-- CREACION DE TABLA COMISION
CREATE TABLE se_comision (
	Comision 			int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Porcentaje 			int NOT NULL,
    FechaRegistro		DATE NOT NULL,
    UsuarioRegistro		int NOT NULL,
    Estado 				BIT NOT NULL,    
    FOREIGN KEY (UsuarioRegistro) REFERENCES se_usuario(Usuario)
);

-- CREACION DE TABLA TRANSACCION_CONTADOR
CREATE TABLE se_transaccioncontador (
	TransaccionContador INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Contador			INT NOT NULL,
    Transaccion			INT NOT NULL,
    Comision			INT NOT NULL,
    Estado				BIT NOT NULL,
    FOREIGN KEY (Contador) REFERENCES se_contador(Contador),
    FOREIGN KEY (Transaccion) REFERENCES se_transaccion(Transaccion),
    FOREIGN KEY (Comision) REFERENCES se_comision(Comision)
);

-- CREACION DE TABLA PROMOCION
CREATE TABLE se_promocion (
	Promocion			INT NOT NULL PRIMARY KEY,
    Descripcion			VARCHAR(500) NOT NULL,
    FechaInicio			DATE NOT NULL,
    FechaFin			DATE NOT NULL,
    Stock				INT,
    FechaIngreso		DATE NOT NULL,
    Socio				INT NOT NULL,
    Imagen				VARCHAR(500) NOT NULL,    
    Estado				BIT NOT NULL,
    FOREIGN KEY (Socio) REFERENCES se_socio (Socio)
);