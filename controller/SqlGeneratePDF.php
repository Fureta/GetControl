<?php

class PDF
{
	function GetHeader($cliente,$proyecto,$contrato,$ncontrato,$mes)
	{
		include "Conexiones.php";
		
		$infoProyecto=array();
		
		if($proyecto=="")
		{
			if ($contrato=="PLAN")
			{
				$consulta=("select con.HORASCONTRATADAS AS 'PLAN', EMPRESA, (con.HORASCONTRATADAS*3)-item.HORAS as 'TOTALHORAS' 
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
				con.HORASCONTRATADAS AS 'PLAN',
				EMPRESA, 
				(con.HORASCONTRATADAS)-item.HORAS as 'TOTALHORAS'
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
				$consulta=("select NPROYECTO,DESCRIPCION ,p.FECHA,p.FECHA_ENTREGA,NCLIENTE,EMPRESA 
				from proyecto p 
				join cliente c 
				on c.ncliente=p.cliente 
				where MONTH(p.fecha)=".$mes." and ncliente=".$cliente." limit 1");
			}
		}
		else
		{
			$consulta=("select NPROYECTO,DESCRIPCION ,p.FECHA,p.FECHA_ENTREGA,NCLIENTE,EMPRESA 
			from proyecto p 
			join cliente c 
			on c.ncliente=p.cliente 
			where nproyecto=".$proyecto." and ncliente=".$cliente." limit 1");
		}

		$Table = $Conexion->query($consulta);
				
		while ($inforows = $Table->fetch_assoc()) $infoProyecto[]=$inforows;
		
		return $infoProyecto;
	}


	function GetItems($cliente,$proyecto,$contrato,$ncontrato,$mes)
	{
		include "Conexiones.php";
		
		$items=array();
		
		if ($proyecto=="")
		{
			if ($contrato=="PLAN")
			{
				$query="select i.nitem as 'NITEM',p.descripcion as 'ITEM',CONCAT(i.item,': ',replace(i.descripcion,CHAR(10 using utf8),'<br>')) as 'DESCRIPCION',i.horas as 'HORAS',
				i.precio as 'PRECIO',u.nombre as 'USUARIO',i.estado as 'ESTADO',NCLIENTE,NPROYECTO,p.FECHA_ENTREGA,
				p.descripcion as 'PDESCRIPCION',MONTH(p.FECHA) as 'MES',NCLIENTE
				
				from item i
				join proyecto p 
				on p.nproyecto=i.proyecto
				join cliente c 
				on c.ncliente=p.cliente and c.ncliente=i.cliente
				join usuario u
				on u.nusuario=i.usuario
				join contrato con
				on con.ncontrato=p.contrato
				where con.ncontrato=".$ncontrato." and ncliente=".$cliente."
				order by p.nproyecto";
			}
			else if ($contrato=="FIJO")
			{
				$query="select i.nitem as 'NITEM',p.descripcion as 'ITEM',CONCAT(i.item,': ',replace(i.descripcion,CHAR(10 using utf8),'<br>')) as 'DESCRIPCION',i.horas as 'HORAS',
				i.precio as 'PRECIO',u.nombre as 'USUARIO',i.estado as 'ESTADO',NCLIENTE,NPROYECTO,p.FECHA_ENTREGA,
				p.descripcion as 'PDESCRIPCION',MONTH(p.FECHA) as 'MES',NCLIENTE
				
				from item i
				join proyecto p 
				on p.nproyecto=i.proyecto
				join cliente c 
				on c.ncliente=p.cliente and c.ncliente=i.cliente
				join usuario u
				on u.nusuario=i.usuario
				join contrato con
				on con.ncontrato=p.contrato
				where con.ncontrato=".$ncontrato." and ncliente=".$cliente;
			}
			else {
				$query="select i.nitem as 'NITEM',p.descripcion as 'ITEM',CONCAT(i.item,': ',replace(i.descripcion,CHAR(10 using utf8),'<br>')) as 'DESCRIPCION',i.horas as 'HORAS',
				i.precio as 'PRECIO',u.nombre as 'USUARIO',i.estado as 'ESTADO',NCLIENTE,NPROYECTO,p.FECHA_ENTREGA,p.descripcion as 'PDESCRIPCION'
				from item i
				join proyecto p 
				on p.nproyecto=i.proyecto
				join cliente c 
				on c.ncliente=p.cliente and c.ncliente=i.cliente
				join usuario u
				on u.nusuario=i.usuario
				where MONTH(p.fecha)=".$mes." and ncliente=".$cliente;
			}
		}
		else
		{
			$query="select i.nitem as 'NITEM',p.descripcion as 'ITEM',CONCAT(i.item,': ',replace(i.descripcion,CHAR(10 using utf8),'<br>')) as 'DESCRIPCION',i.horas as 'HORAS',
			i.precio as 'PRECIO',u.nombre as 'USUARIO',i.estado as 'ESTADO',NCLIENTE,NPROYECTO,p.FECHA_ENTREGA,
			p.descripcion as 'PDESCRIPCION'
			from item i 
			join proyecto p 
			on p.nproyecto=i.proyecto 
			join cliente c 
			on c.ncliente=p.cliente and c.ncliente=i.cliente
			join usuario u
			on u.nusuario=i.usuario
			where ncliente=".$cliente." and nproyecto=".$proyecto;
		}

		$response = $Conexion->query($query);

		while ($rows = $response->fetch_assoc()) $items[]=$rows; 
		return $items;

	}

	function GetSum($cliente,$proyecto,$contrato,$ncontrato,$mes)
	{
		include "Conexiones.php";

		$Totales=array();

		if($proyecto=="")
		{
			if ($contrato=="PLAN")
			{
				$consulta=("
                SELECT 
                		IFNULL(HT.HORASTOTALES,0) AS 'HORAS',
                		(CASE 
                		WHEN CO.HORASCONTRATADAS>0 AND HM.HORASMESCURSO>HORASCONTRATADAS THEN (VALORHORACON*HORASCONTRATADAS)+((HM.HORASMESCURSO-HORASCONTRATADAS)*CO.EXCEDENTE) 
                		WHEN CO.HORASCONTRATADAS=0 THEN HM.HORASMESCURSO*VALORHORACON 
                		ELSE VALORHORACON*HORASCONTRATADAS END) AS 'PRECIO'
                		
                        FROM contrato CO 
                        JOIN cliente C
                		ON CO.CLIENTE=C.NCLIENTE
                		LEFT JOIN (
                			SELECT P.CLIENTE,CONTRATO,
                			SUM(I.HORAS) AS 'HORASMESCURSO'
                			FROM proyecto P 
                			JOIN item I
                			ON P.NPROYECTO=I.PROYECTO
                			WHERE P.CLIENTE=".$cliente." AND MONTH(P.FECHA)=".$mes." 
                			GROUP BY P.CLIENTE,P.CONTRATO
                		)HM
                		ON HM.CLIENTE=C.NCLIENTE AND CO.NCONTRATO=HM.CONTRATO
                		LEFT JOIN (
                			SELECT P.CLIENTE,CONTRATO,
                			SUM(I.HORAS) AS 'HORASTOTALES'
                			FROM proyecto P 
                			JOIN item I
                			ON P.NPROYECTO=I.PROYECTO
                			WHERE P.CLIENTE=".$cliente." AND MONTH(P.FECHA)=".$mes." 
                			GROUP BY P.CLIENTE,P.CONTRATO
                		)HT
                		ON HT.CLIENTE=C.NCLIENTE AND CO.NCONTRATO=HT.CONTRATO
                		WHERE CO.ESTADO='1' AND C.NCLIENTE=".$cliente."
                		GROUP BY C.CLIENTE");
			}
			else if ($contrato=="FIJO")
			{
				$consulta=("select sum(horas) as 'HORAS',sum(HORAS)*con.valorhoracon as 'PRECIO' 
				from proyecto p 
				join item i 
				on i.proyecto=p.nproyecto 
				join cliente c 
				on c.ncliente=p.cliente and c.ncliente=i.cliente
				join contrato con
				on con.ncontrato=p.contrato
				where con.ncontrato=".$ncontrato." and ncliente=".$cliente." 
				group by p.cliente");
			}
			else
			{
				$consulta=("select sum(horas) as 'HORAS',sum(precio) as 'PRECIO' 
				from proyecto p 
				join item i 
				on i.proyecto=p.nproyecto 
				join cliente c 
				on c.ncliente=p.cliente and c.ncliente=i.cliente
				where MONTH(p.fecha)=".$mes." and  p.cliente=".$cliente." 
				group by p.cliente");
			}
		}
		else
		{
			$consulta=("select sum(horas) as 'HORAS',sum(horas)*con.valorhoracon as 'PRECIO' 
			from proyecto p 
			join item i 
			on i.proyecto=p.nproyecto 
			join cliente c 
			on c.ncliente=p.cliente and c.ncliente=i.cliente
			join contrato con
			on con.ncontrato=p.contrato
			where p.nproyecto=".$proyecto." and con.estado=1 and p.cliente=".$cliente." 
			group by p.cliente");
		}
		$Table = $Conexion->query($consulta);
		
		
		while ($inforows = $Table->fetch_assoc()) $Totales[]=$inforows;
		
		return $Totales;
	}
}
?>		
	