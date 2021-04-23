<?php

class ControlPanel
{
	
	public function GetCards($cliente,$perfil)
	{
		include "Conexiones.php";
		include "SqlContracts.php";

		date_default_timezone_set("America/Argentina/Buenos_Aires");
		$mes = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"][date("n") - 1];
		
		
		if ($perfil=="1")
		{
			$query="SELECT 
			'findcontrol' AS CLIENTE,
			IFNULL(SUM(CASE WHEN I.ESTADO IN ('ABIERTO','PENDIENTE') THEN 1 ELSE 0 END),0) AS 'TAREAS',
			IFNULL(SUM(HORAS),0) AS 'HORASMESCURSO',
			IFNULL(SUM(HORAS),0) AS 'HORASTOTALES',
			IFNULL(SUM(COALESCE(HORAS*VALORHORACON,0)),0) AS 'SALDOMESPASADO'
			FROM proyecto P 
			JOIN cliente C 
			ON P.CLIENTE=C.NCLIENTE 
			JOIN item I 
			ON I.CLIENTE=P.CLIENTE AND I.PROYECTO=P.NPROYECTO
			JOIN contrato CON 
			ON P.CONTRATO=CON.NCONTRATO
			WHERE CAST(FECHA AS DATE) BETWEEN CAST(DATE_FORMAT(CURDATE(), '%y-%m-01') AS DATE) AND CAST(LAST_DAY(NOW()) AS DATE ) ";

			$req = $Conexion->query($query);
			$res = $req->fetch_assoc(); 
			
			echo json_encode($res);

		}else 
		{
		    $InfoClient= new Contracts();
	    	$InfoClient=$InfoClient->GetContractsById($cliente);
		
		
			if(!empty($InfoClient[0]["OC"]))
			{
				$query="SELECT 
				P.CLIENTE,
				IFNULL(".$InfoClient[0]['HORASCONTRATADAS'].",0) AS 'CANTIDAD_HORAS',
				IFNULL(SUM(CASE WHEN I.ESTADO IN ('ABIERTO','PENDIENTE') THEN 1 ELSE 0 END),0) AS 'TAREAS', 
				IFNULL(".$InfoClient[0]['HORASMESPASADO'].",0) AS 'HORASMESPASADO',
				IFNULL(".$InfoClient[0]['HORASMESCURSO'].",0) AS 'HORASMESCURSO',
				IFNULL(".$InfoClient[0]['HORASTOTALES'].",0) AS 'HORASTOTALES',
				IFNULL(".$InfoClient[0]['SALDOMESPASADO'].",0) AS 'SALDOMESPASADO',
				IFNULL(".$InfoClient[0]['FECHAFIN'].",0) AS 'FECHAFINCONTRATO'
				FROM proyecto P 
				JOIN cliente C 
				ON P.CLIENTE=C.NCLIENTE 
				JOIN item I 
				ON I.CLIENTE=P.CLIENTE AND I.PROYECTO=P.NPROYECTO
				WHERE C.NCLIENTE=".$cliente."  AND P.CONTRATO=".$InfoClient[0]['NCONTRATO']."
				GROUP BY 1";	

				$req = $Conexion->query($query);
				$res = $req->fetch_assoc(); 
				
				if (empty($res))
				{
					$res=array("res"=>"NoHours");
					echo json_encode($res);
				}
				else 
				{
					echo json_encode($res);
				}
			}else
			{
				$res=array("res"=>"NoContract");
				echo json_encode($res);
			}
		}
	}
		
}
?>












