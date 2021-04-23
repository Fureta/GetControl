<?php

class Contracts
{
    public function GetContracts()
	{
		include "Conexiones.php";
		

        $query="SELECT NCONTRATO,NCLIENTE,EMPRESA,OC,VALORHORACON,HORASCONTRATADAS, NCLIENTE,
        CASE WHEN CO.ESTADO='1' THEN 'ACTIVA' ELSE 'INACTIVA' END AS 'ESTADO',
        CO.ESTADO AS 'ESTADOMOD',
		COALESCE(DATE_FORMAT(FECHAINICIO,'%d/%m/%y'),'') AS 'FECHAINICIO',
		COALESCE(DATE_FORMAT(FECHAFIN,'%d/%m/%y'),'') AS 'FECHAFIN',
		FECHAINICIO AS 'FECINIMOD',
		FECHAFIN AS 'FECFINMOD',
		EXCEDENTE
        FROM contrato CO 
        JOIN cliente C
        ON CO.CLIENTE=C.NCLIENTE";

		$req = $Conexion->query($query);

		$contracts=array();

		while ($rows = $req->fetch_assoc()) 
		{
			
			$contracts []= $rows; 
		
		}
		return json_encode($contracts);
    }
    
	public function GetContractsById($cliente)
	{
		include "Conexiones.php";
		$MES=date('n') - 1;

        $query="SELECT NCLIENTE,NCONTRATO,EMPRESA,OC,VALORHORACON,FECHAINICIO,FECHAFIN,
		IFNULL(HORASCONTRATADAS,0) AS 'HORASCONTRATADAS',
        IFNULL(H.HORASMESPASADO,0) AS 'HORASMESPASADO',
		IFNULL(HM.HORASMESCURSO,0) AS 'HORASMESCURSO',
		(CASE WHEN HM.HORASMESCURSO>HORASCONTRATADAS 
		THEN IFNULL(HT.HORASTOTALES,0)-(IFNULL(HM.HORASMESCURSO,0)-IFNULL(HORASCONTRATADAS,0))  ELSE IFNULL(HT.HORASTOTALES,0) END) AS 'HORASTOTALES',
		(CASE 
		WHEN CO.HORASCONTRATADAS>0 AND HM.HORASMESCURSO>HORASCONTRATADAS THEN IFNULL((VALORHORACON*HORASCONTRATADAS)+((HM.HORASMESCURSO-HORASCONTRATADAS)*CO.EXCEDENTE),0)
		WHEN CO.HORASCONTRATADAS=0 THEN IFNULL(HM.HORASMESCURSO*VALORHORACON,0) 
		ELSE IFNULL(VALORHORACON*HORASCONTRATADAS,0) END) AS 'SALDOMESPASADO'
		
        FROM contrato CO 
        JOIN cliente C
		ON CO.CLIENTE=C.NCLIENTE
		LEFT JOIN (
			SELECT P.CLIENTE,CONTRATO,
			SUM(I.HORAS) AS 'HORASMESPASADO'
			FROM proyecto P 
			JOIN item I
			ON P.NPROYECTO=I.PROYECTO
			WHERE P.CLIENTE=".$cliente." AND MONTH(FECHA) = ".$MES."
			GROUP BY P.CLIENTE,P.CONTRATO
		)H
		ON H.CLIENTE=C.NCLIENTE AND CO.NCONTRATO=H.CONTRATO
		LEFT JOIN (
			SELECT P.CLIENTE,CONTRATO,
			IFNULL(SUM(I.HORAS),0) AS 'HORASMESCURSO'
			FROM proyecto P 
			JOIN item I
			ON P.NPROYECTO=I.PROYECTO
			WHERE P.CLIENTE=".$cliente." AND CAST(FECHA AS DATE) BETWEEN CAST(DATE_FORMAT(CURDATE(), '%y-%m-01') AS DATE) AND CAST(LAST_DAY(NOW()) AS DATE ) 
			GROUP BY P.CLIENTE,P.CONTRATO
		)HM
		ON HM.CLIENTE=C.NCLIENTE AND CO.NCONTRATO=HM.CONTRATO
		LEFT JOIN (
			SELECT P.CLIENTE,CONTRATO,
			IFNULL(SUM(I.HORAS),0) AS 'HORASTOTALES'
			FROM proyecto P 
			JOIN item I
			ON P.NPROYECTO=I.PROYECTO
			WHERE P.CLIENTE=".$cliente."
			GROUP BY P.CLIENTE,P.CONTRATO
		)HT
		ON HT.CLIENTE=C.NCLIENTE AND CO.NCONTRATO=HT.CONTRATO
		WHERE CO.ESTADO='1' AND C.NCLIENTE=".$cliente;
        
       
		$req = $Conexion->query($query);
        
		$contracts=array();
       
		while ($rows = $req->fetch_assoc()) 
		{
			
			$contracts []= $rows; 
		
		}
		
		return $contracts;
    }

    public function DeleteContracts($id) 
	{	
		include "Conexiones.php";
        
        $query=("delete from contrato where NCONTRATO=".$id);
        $req = $Conexion->query($query);
        
        $res=array("res"=>"Delete");
		echo json_encode($res);
    
	}
	
	
	public function UpdateContracts($id,$cliente,$oc,$valorhora,$packhoras,$estado,$fecini,$fecfin) 
	{	
		include "Conexiones.php";
		
		$query=("update contrato 
                        set 
						CLIENTE='".$cliente."',
						OC='".$oc."',
						VALORHORACON='".$valorhora."',
                        HORASCONTRATADAS='".$packhoras."',
						ESTADO='".$estado."',
						FECHAINICIO=DATE_FORMAT('".$fecini."', '%Y-%m-%d'),
						FECHAFIN=DATE_FORMAT('".$fecfin."', '%Y-%m-%d')
                        where NCONTRATO=".$id);
                        
        $req = $Conexion->query($query);

        $res=array("res"=>"Update");
		echo json_encode($res);	
	} 
    
    public function InsertContracts($cliente,$oc,$valorhora,$packhoras,$estado,$fecini,$fecfin) 
	{	  
		include "Conexiones.php";
        		
		$query="
			INSERT INTO contrato 
			(
                CLIENTE,OC,VALORHORACON,HORASCONTRATADAS,ESTADO,FECHAINICIO,FECHAFIN
            )
			VALUES(
			 '".$cliente."', 
			 '".$oc."',
			 '".$valorhora."', 
			 '".$packhoras."',
			 '".$estado."',
			 DATE_FORMAT('".$fecini."', '%Y-%m-%d'),
			 DATE_FORMAT('".$fecfin."', '%Y-%m-%d')
		 	)
			";
		
        $req=$Conexion->query($query);

        $res=array("res"=>"Insert");
		echo json_encode($res);	
	}
}
?>