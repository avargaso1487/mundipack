DROP DATABASE IF EXISTS bdMundiPack;
CREATE DATABASE bdMundiPack;

USE bdMundiPack;


/*----------------------SEGURIDAD-------------------------*/
CREATE TABLE SE_Persona(
	Persona INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Nombres VARCHAR(150) NOT NULL,
	Apellidos VARCHAR(150) NOT NULL,
	DNI CHAR(8) NOT NULL,
	FechaNacimiento date NOT NULL,
	TelefonoFijo  VARCHAR(10) NULL,
	TelefonoMovil VARCHAR(10) NULL,
	Email VARCHAR(150) NOT NULL,
	Estado BIT NOT NULL
);

CREATE TABLE SE_Usuario(
	Persona INT NOT NULL PRIMARY KEY,
	Login VARCHAR(20) NOT NULL,
	Password CHAR(32) NOT NULL,
	FeCHARegistro DATETIME NOT NULL,
	FechaCese DATETIME NULL,
	Estado BIT NOT NULL,
	FOREIGN KEY (Persona) REFERENCES SE_Persona(Persona)
);

CREATE TABLE SE_Rol(
	Rol INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Nombre VARCHAR(25) NOT NULL,
	Descripcion VARCHAR(60) NOT NULL,
	Estado BIT NOT NULL
);

CREATE TABLE SE_RolUsuario(
	RolUsuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Rol INT NOT NULL,
	Persona INT NOT NULL,
	Estado BIT NOT NULL,
	FOREIGN KEY (Rol) REFERENCES SE_Rol(Rol)
);

CREATE TABLE SE_Menu(
	Menu INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	MenuPadre INT NULL,
	Nombre VARCHAR(20) NOT NULL,
	Descripcion VARCHAR(60) NOT NULL,
	Orden INT NOT NULL,
	URL VARCHAR(100) NOT NULL,
	Estado BIT NOT NULL,
	FOREIGN KEY (Menu) REFERENCES SE_Menu(Menu)
);

CREATE TABLE SE_Permiso(
	Permiso INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Menu INT NOT NULL,
	Rol INT NOT NULL,
	Estado BIT NOT NULL,
	FOREIGN KEY (Menu) REFERENCES SE_Menu(Menu),
	FOREIGN KEY (Rol) REFERENCES SE_Rol(Rol)
);

CREATE TABLE SE_Dashboard(
    Dashboard INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
    Nombre VARCHAR(20) NOT NULL,
    Descripcion VARCHAR(60) NOT NULL,
    Orden INT NOT NULL,
    URL VARCHAR(150) NOT NULL,
    Estado BIT NOT NULL,
    ROL INT NOT NULL REFERENCES SE_Rol(Rol)
);