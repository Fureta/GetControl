<?php

	$hostname = 'localhost';
	$database = 'findcontrol';
	$username = 'root';
	$password = '';
	global $Conexion;
	
	$Conexion = new mysqli();
	$Conexion->connect($hostname,$username,$password,$database);

	if ($Conexion->connect_error){
		console.log("no hubo conexion");
		die("no hubo conexion".$Conexion->connect_error);
	}
	
?>
