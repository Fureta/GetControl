<?php
session_start();
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
include "../controller/Conexiones.php";

$usuario=$_POST['user'];
$pass=$_POST['password'];


if (isset($_SESSION['usuario']))
{
	$res=array("res"=>"ok");
	echo json_encode($res);
}else if (!empty($usuario) && !empty($pass))
{

	$sentenciaSQL= "SELECT NUSUARIO,CLAVE,PERFIL,CLIENTE,NOMBRE FROM usuario ";
	$resultado = $Conexion->query($sentenciaSQL);
	
	while ($row = $resultado->fetch_assoc()) 
	{
			
		if($row['NUSUARIO']===$usuario)
		{
			$hash=$row["CLAVE"];

			if (password_verify($pass, $hash))
			{
				$_SESSION['usuario']=$row['NUSUARIO'];
				$_SESSION['perfil']=$row['PERFIL'];
				$_SESSION['cliente']=$row['CLIENTE'];
				$_SESSION['nombre']=$row['NOMBRE'];
				
				$res=array("res"=>"ok");
				echo json_encode($res);
				break;
			}else
			{
				$res=array("res"=>"noPass");
				break;
			}	
		}else
		{
			$res=array("res"=>"no");
		}
	}
	echo json_encode($res);
}

?>