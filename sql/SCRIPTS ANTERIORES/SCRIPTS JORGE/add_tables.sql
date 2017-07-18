USE bdmundipack;



-- CREACION DE TABLA CONTADOR SOCIO
CREATE TABLE se_contadorsocio (
	ContadorSocio 			int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Socio 					int NOT NULL,
    MontoAcumulado			DECIMAL(10,2) NOT NULL,    
    Estado 					INT NOT NULL,    
    FOREIGN KEY (Socio) REFERENCES se_socio(Socio)
);

-- CREACION DE TABLA TRANSACCION CONTADOR SOCIO
CREATE TABLE  se_transaccioncontadorsocio(
	TransaccionContadorSocio 		int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ContadorSocio 					int NOT NULL,
    Transaccion						INT NOT NULL,    
    PorcentajeRetorno 				DECIMAL(10,2) NOT NULL,    
    Estado 							INT NOT NULL,    
    FOREIGN KEY (ContadorSocio) REFERENCES se_contadorsocio(ContadorSocio),
    FOREIGN KEY (Transaccion) REFERENCES se_transaccion(Transaccion)
);

-- CREACION DE TABLA CONTADOR MUNDIPACK
CREATE TABLE se_contadormundi (
	ContadorMundi 			int NOT NULL AUTO_INCREMENT PRIMARY KEY,    
    MontoAcumulado			DECIMAL(10,2) NOT NULL,    
    Estado 					INT NOT NULL    
);

-- CREACION DE TABLA TRANSACCION CONTADOR MUNDI
CREATE TABLE  se_transaccioncontadormundi(
	TransaccionContadorMundi 		int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ContadorMundi 					int NOT NULL,
    Transaccion						INT NOT NULL,    
    Comision		 				INT NOT NULL,    
    Estado 							INT NOT NULL,    
    FOREIGN KEY (ContadorMundi) REFERENCES se_contadormundi(ContadorMundi),
    FOREIGN KEY (Transaccion) REFERENCES se_transaccion(Transaccion),
    FOREIGN KEY (Comision) REFERENCES se_comision(Comision)
);