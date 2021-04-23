<?php

class Clients
{
    public function GetClients($cliente,$perfil)
	{
		include "Conexiones.php";
		if ($perfil=="1")
		{
            $query="SELECT * FROM cliente ";
        }
        else
        {
            $query="SELECT * FROM cliente where ncliente=".$cliente;
        }
		$req = $Conexion->query($query);

		$clients=array();

		while ($rows = $req->fetch_assoc()) 
		{
			
			$clients []= $rows; 
		
		}
		return json_encode($clients);
	}
	public function GetClientsMails($mes,$perfil)
	{
		include "Conexiones.php";
		if ($perfil=="1")
		{
            $query="SELECT distinct	NCLIENTE,MAIL FROM cliente c join proyecto p on p.cliente=c.ncliente join usuario u on u.cliente=c.ncliente where  MONTH(FECHA) = ".$mes;
        }
        $req = $Conexion->query($query);

		$clients=array();

		while ($rows = $req->fetch_assoc()) 
		{
			
			$clients []= $rows; 
		
		}
		return json_encode($clients);
	}
	public function GetClientsMailsEndPlan()
	{
		include "Conexiones.php";

        $query="SELECT * from contrato co join cliente c on co.cliente=c.ncliente where oc='PLAN' and ESTADO=1 and DATE_ADD(FECHAFIN, INTERVAL -1 month)='2021-02-04'";
        $req = $Conexion->query($query);

		$clients=array();

		while ($rows = $req->fetch_assoc()) 
		{
			
			$clients []= $rows; 
		
		}
		return json_encode($clients);
	}
	public function GetClientsById($cliente)
	{
		include "Conexiones.php";
		
        $query="SELECT * FROM cliente where ncliente=".$cliente;

		$req = $Conexion->query($query);

		$clients=array();

		while ($rows = $req->fetch_assoc()) 
		{
			
			$clients []= $rows; 
		
		}
		return $clients;
    }

    public function DeleteClients($id) 
	{	
		include "Conexiones.php";
        
        $query=("delete from cliente where NCLIENTE=".$id);
        $req = $Conexion->query($query);
        
        $res=array("res"=>"Delete");
		echo json_encode($res);
    
	}
	
	
	public function UpdateClients($id,$empresa,$cuil,$direccion,$mailfacturacion) 
	{	
		include "Conexiones.php";
		
		$query=("update cliente 
                        set EMPRESA='".$empresa."',CUIL='".$cuil."',DIRECCION='".$direccion."',MAIL_FACTURACION='".$mailfacturacion."'
                        where NCLIENTE=".$id);
                        
        $req = $Conexion->query($query);

        $res=array("res"=>"Update");
		echo json_encode($res);	
	} 
    
    public function InsertClients($empresa,$cuil,$direccion,$mailfacturacion,$horascontratadas) 
	{	  
		include "Conexiones.php";
        		
		$query="
			INSERT INTO cliente 
			(
				CUIL,DIRECCION,EMPRESA,MAIL_FACTURACION,CANTIDAD_HORAS
			)
			VALUES(
			 '".$cuil."', 
			 '".$direccion."',
			 '".$empresa."', 
			 '".$mailfacturacion."',
             '".$horascontratadas."'
		 	)
			";
		
        $req=$Conexion->query($query);

        $res=array("res"=>"Insert");
		echo json_encode($res);	
	}
}
?>