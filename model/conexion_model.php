<?php 

class Conexion_Model{
	public static function getConexion(){

		//$conexion = mysqli_connect('localhost','jenner_mundipack','mundipack2017','jenner_bdmundipacktest');
		$conexion = mysqli_connect('localhost','root','','bdmundipack3');

		return $conexion;
	}
}

 ?>