<?php 

class Conexion_Model{
	public static function getConexion(){

		//$conexion = mysqli_connect('localhost','cpses_jeFpfYPi6n','mundipack2017','jenner_bdmundipack');

		$conexion = mysqli_connect('localhost','root','','bdmundipack');

		return $conexion;
	}
}

 ?>