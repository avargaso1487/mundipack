<?php 
	session_start();

	include_once "../../model/modeladministrador/administrador_model.php";

	$param = array();
	$param['opcion'] = '';

	//Socios	
	$param['socioID'] = 0;
	$param['socioRazonSocial'] = '';
	$param['socioRUC'] = '';
	$param['socioNombreComercial'] = '';
	$param['socioRubro'] = '';
	$param['socioDireccion'] = '';
	$param['socioTelefonoContacto'] = '';
	$param['socioTelefonoAtencion'] = '';	
	$param['socioEmail'] = '';

	$param['socioNroCuenta'] = '';
	$param['socioContactoResponsable'] = '';
	$param['socioPrctjRetorno'] = 0;
	$param['socioCategoria'] = 0;

	$param['viajeroID'] = 0;
	$param['viajeroNombre'] = '';
	$param['viajeroApellidos'] = '';
	$param['viajeroDNI'] = '';
	$param['viajeroDireccion'] = '';
	$param['viajeroNacimiento'] = '1900-01-01';
	$param['viajeroTelefonoFijo'] = '';
	$param['viajeroTelefonoCelular'] = '';
	$param['viajeroEmail'] = '';
	$param['viajeroNroPasaporte'] = '';
	$param['viajeroAbierto'] = 0;


	if(isset($_POST['opcion']))		$param['opcion'] = $_POST['opcion'];
	
	//Socios
	if(isset($_POST['socioID']))		$param['socioID'] = $_POST['socioID'];
	if(isset($_POST['socioRazonSocial']))		$param['socioRazonSocial'] = $_POST['socioRazonSocial'];
	if(isset($_POST['socioRUC']))		$param['socioRUC'] = $_POST['socioRUC'];
	if(isset($_POST['socioNombreComercial']))		$param['socioNombreComercial'] = $_POST['socioNombreComercial'];
	if(isset($_POST['socioRubro']))		$param['socioRubro'] = $_POST['socioRubro'];
	if(isset($_POST['socioDireccion']))		$param['socioDireccion'] = $_POST['socioDireccion'];
	if(isset($_POST['socioTelefonoContacto']))		$param['socioTelefonoContacto'] = $_POST['socioTelefonoContacto'];
	if(isset($_POST['socioTelefonoAtencion']))		$param['socioTelefonoAtencion'] = $_POST['socioTelefonoAtencion'];	
	if(isset($_POST['socioEmail']))		$param['socioEmail'] = $_POST['socioEmail'];
	if(isset($_POST['socioNroCuenta']))		$param['socioNroCuenta'] = $_POST['socioNroCuenta'];
	if(isset($_POST['socioContactoResponsable']))		$param['socioContactoResponsable'] = $_POST['socioContactoResponsable'];
	if(isset($_POST['socioPrctjRetorno']))		$param['socioPrctjRetorno'] = $_POST['socioPrctjRetorno'];
	if(isset($_POST['socioCategoria']))		$param['socioCategoria'] = $_POST['socioCategoria'];

	//Viajeros
	if(isset($_POST['viajeroID']))		$param['viajeroID'] = $_POST['viajeroID'];
	if(isset($_POST['viajeroNombre']))		$param['viajeroNombre'] = $_POST['viajeroNombre'];
	if(isset($_POST['viajeroApellidos']))		$param['viajeroApellidos'] = $_POST['viajeroApellidos'];
	if(isset($_POST['viajeroDNI']))		$param['viajeroDNI'] = $_POST['viajeroDNI'];
	if(isset($_POST['viajeroDireccion']))		$param['viajeroDireccion'] = $_POST['viajeroDireccion'];	
	if(isset($_POST['viajeroNacimiento']))		$param['viajeroNacimiento'] = $_POST['viajeroNacimiento'];
	if(isset($_POST['viajeroTelefonoFijo']))		$param['viajeroTelefonoFijo'] = $_POST['viajeroTelefonoFijo'];
	if(isset($_POST['viajeroTelefonoCelular']))		$param['viajeroTelefonoCelular'] = $_POST['viajeroTelefonoCelular'];
	if(isset($_POST['viajeroEmail']))		$param['viajeroEmail'] = $_POST['viajeroEmail'];
	if(isset($_POST['viajeroNroPasaporte']))		$param['viajeroNroPasaporte'] = $_POST['viajeroNroPasaporte'];
	if(isset($_POST['viajeroAbierto']))		$param['viajeroAbierto'] = $_POST['viajeroAbierto'];


	$Administrador = new Administrador_model();
	echo $Administrador->gestionar($param);
 ?>