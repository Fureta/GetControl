<?php

class Users
{
	public function GetUserById($usuario)
	{
		include "Conexiones.php";
		
		$query="SELECT * FROM usuario where NUSUARIO='".$usuario."'";

		$req = $Conexion->query($query);
		
		while ($rows = $req->fetch_assoc()) 
		{
			$res=array($rows);
		}
		return json_encode($res);
	}    
	public function GetUsers($usuario)
	{
		include "Conexiones.php";
		
		$query="select EMPRESA, NCLIENTE,PERFIL as 'NPERFIL',u.MAIL,u.NUSUARIO,'****' as 'CLAVE', u.NOMBRE,CASE WHEN PERFIL=1 THEN 'Administrador' else 'Usuario' end as 'PERFIL'
		FROM usuario u
		join cliente c 
		on c.ncliente=u.cliente
		ORDER BY NUSUARIO";

		$req = $Conexion->query($query);
		
		$users=array();

		while ($rows = $req->fetch_assoc()) 
		{
			
			$users []= $rows; 
		
		}
		return json_encode($users);
	}
	
	public function DeleteUsers($id) 
	{	
		include "Conexiones.php";
		
		$sentenciaSQL=("delete from usuario where NUSUARIO=".$id);
		$query = $Conexion->query($sentenciaSQL);

		$res=array("res"=>"Delete");
		echo json_encode($res);
		
	}
	
	
	public function UpdateUsers($id,$nombre,$cliente,$perfil,$mail) 
	{	
		include "Conexiones.php";

		$query=("update usuario 
				SET NOMBRE='".$nombre."',CLIENTE='".$cliente."',PERFIL='".$perfil."',MAIL='".$mail."'
				where NUSUARIO=".$id);
		$req = $Conexion->query($query);
		
		$res=array("res"=>"Update");
		echo json_encode($res);		
	}
	
	public function InsertUsers($nombre,$cliente,$perfil,$mail) 
	{
		
		include "Conexiones.php";
		
		$sentenciaSQL=("select * from cliente where NCLIENTE=".$cliente);
		$query = $Conexion->query($sentenciaSQL);
		
		$fechaActual = date('Y');
		
		
		while ($rows = $query->fetch_assoc()) 
		{
			$clave=str_replace(' ', '', $rows["EMPRESA"]).$fechaActual;
			$clave=password_hash($clave, PASSWORD_DEFAULT);
		}

		$sentenciaSQL="
			INSERT INTO usuario (CLAVE,NOMBRE,CLIENTE,PERFIL,MAIL) 
			VALUES
			(
				'".$clave."',
				'".$nombre."',
				'".$cliente."',
				'".$perfil."',
				'".$mail."'
			)
			";
			
		$query=$Conexion->query($sentenciaSQL);
		
		$res=array("res"=>"Insert");
		echo json_encode($res);
	}                                                                                                                          
}

?>
