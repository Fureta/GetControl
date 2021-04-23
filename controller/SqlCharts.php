<?php

class GetCharts
{
    public function Pie($cliente,$perfil)
    {
        include "Conexiones.php";
		
		if ($perfil=="1")
		{
			$query="SELECT 
			p.cliente,
			p.DESCRIPCION,SUM(HORAS) as 'TOTAL',
			concat('#',SUBSTRING((lpad(hex(round(rand() * 10000000)),6,0)),-6)) as 'COLOR' 
			FROM proyecto p 
			join item i 
			on i.proyecto=p.nproyecto
			where CAST(fecha AS DATE) between  CAST(DATE_FORMAT(CURDATE(), '%Y-%m-01') AS DATE) AND CAST(LAST_DAY(NOW()) AS DATE )
			GROUP BY p.cliente,p.DESCRIPCION";
		}
		else 
		{
			$query="SELECT 
			p.cliente,
			p.DESCRIPCION,SUM(HORAS) as 'TOTAL',
			concat('#',SUBSTRING((lpad(hex(round(rand() * 10000000)),6,0)),-6)) as 'COLOR'  
			FROM proyecto p 
			join item i 
			on i.proyecto=p.nproyecto 
			where p.cliente=".$cliente." and CAST(fecha AS DATE) between  CAST(DATE_FORMAT(CURDATE(), '%Y-%m-01') AS DATE) AND CAST(LAST_DAY(NOW()) AS DATE )
			GROUP BY p.cliente,p.DESCRIPCION";
		}
		$req = $Conexion->query($query);
        
        $pie=array();
		while ($rows = $req->fetch_assoc()) 
		{
			$pie[]=$rows;
		}
		return json_encode($pie);
	}
	
	public function Bar($cliente,$perfil)
    {
        include "Conexiones.php";
		
		if ($perfil=="1")
		{
			$query="SELECT IFNULL(month(fecha),'') as 'Mes',sum(HORAS) as 'TOTAL',concat('#',SUBSTRING((lpad(hex(round(rand() * 10000000)),6,0)),-6)) as 'COLOR' FROM `proyecto` p join item i on i.proyecto=p.nproyecto group by IFNULL(monthname(fecha),'') order by cast(month(fecha) as integer)";
		}
		else 
		{
			$query="SELECT IFNULL(month(fecha),'') as 'Mes',sum(HORAS) as 'TOTAL',concat('#',SUBSTRING((lpad(hex(round(rand() * 10000000)),6,0)),-6)) as 'COLOR' FROM `proyecto` p join item i on i.proyecto=p.nproyecto where p.cliente=".$cliente." group by IFNULL(monthname(fecha),'') order by cast(month(fecha) as integer)";
		}
		$req = $Conexion->query($query);
        
        $bar=array();
		while ($rows = $req->fetch_assoc()) 
		{
			$bar[]=$rows;
		}
		return json_encode($bar);
    }
}


?>