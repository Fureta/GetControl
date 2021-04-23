<?php

class MAIL
{
	function GetHeader($cliente,$proyecto,$contrato,$ncontrato,$mes)
	{
		include "Conexiones.php";
		
		$infoProyecto=array();
		
			if ($contrato=="PLAN")
			{
				$consulta=("select EMPRESA,
                con.HORASCONTRATADAS as 'HORASCONTRATADAS',
				item.HORAS as 'TOTALHORAS' ,
                con.HORASCONTRATADAS-item.HORAS as 'RESTANTES'
				from contrato con 
				join cliente c 
				on c.ncliente=con.cliente 
				join ( 
					select i.cliente,sum(HORAS) as 'HORAS' 
					from item i 
					join proyecto pro 
					on i.proyecto=pro.NPROYECTO 
					join contrato con 
					on pro.contrato=con.ncontrato 
					where con.ncontrato=".$ncontrato." and i.cliente=".$cliente."  AND MONTH(pro.FECHA)=".$mes." 
					group by i.cliente 
				)item 
				on item.cliente=c.ncliente 
				where con.ncontrato=".$ncontrato." and ncliente=".$cliente);
			}
			else if ($contrato=="FIJO")
			{
				$consulta=("select 
				(case when con.HORASCONTRATADAS='0' then '70' else 0 end) AS 'PLAN', EMPRESA,
                con.HORASCONTRATADAS as 'HORASCONTRATADAS',item.HORAS as 'TOTALHORAS' ,
                con.HORASCONTRATADAS-item.HORAS as 'RESTANTES'
				from contrato con 
				join cliente c 
				on c.ncliente=con.cliente 
				join 
				(
					select i.cliente,sum(HORAS) as 'HORAS'
					from item i 
					join proyecto p
					on i.proyecto=p.NPROYECTO
					join contrato con
					on p.contrato=con.ncontrato
					where i.cliente=".$cliente." and con.estado=1
					group by cliente
				)item
				on item.cliente=c.ncliente
				where con.ncontrato=".$ncontrato." and ncliente=".$cliente);
			}
			else
			{
				$consulta=("select EMPRESA,
                'No Aplica' as 'HORASCONTRATADAS',
				item.HORAS as 'TOTALHORAS' ,
                con.HORASCONTRATADAS-item.HORAS as 'RESTANTES'
				from contrato con 
				join cliente c 
				on c.ncliente=con.cliente 
				join ( 
					select i.cliente,sum(HORAS) as 'HORAS' 
					from item i 
					join proyecto pro 
					on i.proyecto=pro.NPROYECTO 
					join contrato con 
					on pro.contrato=con.ncontrato 
					where con.ncontrato=".$ncontrato." and i.cliente=".$cliente."  AND MONTH(pro.FECHA)=".$mes." 
					group by i.cliente 
				)item 
				on item.cliente=c.ncliente 
				where con.ncontrato=".$ncontrato." and ncliente=".$cliente);
			}
		
		

		$Table = $Conexion->query($consulta);
				
		while ($inforows = $Table->fetch_assoc()) $infoProyecto[]=$inforows;
		
		return $infoProyecto;
	}
	function GetHeaderEndPlan($cliente)
	{
		include "Conexiones.php";
		
		$infoProyecto=array();
		
		$consulta=("SELECT * from contrato co join cliente c on co.cliente=c.ncliente where oc='PLAN' and ESTADO=1 and DATE_ADD(FECHAFIN, INTERVAL -1 month)='2021-02-04' and c.ncliente=".$cliente);
		
		$Table = $Conexion->query($consulta);
				
		while ($inforows = $Table->fetch_assoc()) $infoProyecto[]=$inforows;
		
		return $infoProyecto;
	}

}
?>		
	