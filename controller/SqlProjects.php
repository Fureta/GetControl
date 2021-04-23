<?php
	
class Projects
{
	public function GetProjects($cliente,$perfil)
	{
		include "Conexiones.php";

		date_default_timezone_set("America/Argentina/Buenos_Aires");
		$mes = ["enero", "febrero", "marzo", "abril", "Mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"][date("n") - 1];
		
		if ($perfil=="1")
		{
			$query="select 
			concat(coalesce(month(now()),''),coalesce(year(now()),'')) as 'MESACTUAL',
			concat(coalesce(month(p.fecha),''),coalesce(year(now()),'')) as 'MES',
			coalesce(c.empresa,'') as 'EMPRESA',
			coalesce(p.nproyecto,'') as 'NPROYECTO',
			coalesce(p.descripcion,'') as 'DESCRIPCION',
			coalesce(date_format(p.fecha,'%d/%m/%Y'),'') as 'FECHA',
			coalesce(date_format(p.fecha_entrega,'%Y-%m-%d'),'') as 'DEADLINE',
			coalesce(date_format(p.fecha_entrega,'%d/%m/%Y'),'') as 'FECHA_ENTREGA',
			coalesce(sum(i.horas),0) as 'HORAS',
			coalesce(sum(i.precio),0)  as 'PRECIO',
			MAX(case when t.ESTADOS>0 then 'Abierto' else 'Cerrado' end) as 'ESTADO',
			coalesce(u.nombre,'') as 'USUARIO',
			coalesce(ncliente,'') as 'NCLIENTE',
			coalesce(".$perfil.",'') as 'PERFIL',
			coalesce(date_format(p.FECHA,'%Y-%m-%d'),'') as 'FECHAMOD'
			from proyecto p
			left join cliente c on p.cliente=c.ncliente 
			left join item i on i.cliente=p.cliente and i.proyecto=p.nproyecto
			left join usuario u
			on u.nusuario=i.usuario
			left join (
				select p.NPROYECTO,sum(case when i.ESTADO='Abierto' then 1 else 0 end) as 'ESTADOS'
				from proyecto p 
				join item i
				on p.NPROYECTO=i.PROYECTO
				group by 1
			)t
			on t.NPROYECTO=p.NPROYECTO
			group by 1,2,3,4,5 order by cast(p.nproyecto as unsigned) desc limit 100
			";

		}else
		{
			$query="select 
			concat(coalesce(month(now()),''),coalesce(year(now()),'')) as 'MESACTUAL',
			concat(coalesce(month(p.fecha),''),coalesce(year(now()),'')) as 'MES',
			coalesce(c.empresa,'') as 'EMPRESA',
			coalesce(p.nproyecto,'') as 'NPROYECTO',
			coalesce(p.descripcion,'') as 'DESCRIPCION',
			coalesce(date_format(p.fecha,'%d/%m/%Y'),'') as 'FECHA',
			coalesce(date_format(p.fecha_entrega,'%Y-%m-%d'),'') as 'DEADLINE',
			coalesce(date_format(p.fecha_entrega,'%d/%m/%Y'),'') as 'FECHA_ENTREGA',
			coalesce(sum(i.horas),0) as 'HORAS',
			coalesce(sum(i.precio),0)  as 'PRECIO',
			MAX(case when t.ESTADOS>0 then 'Abierto' else 'Cerrado' end) as 'ESTADO',
			coalesce(u.nombre,0) as 'USUARIO',
			coalesce(ncliente,0) as 'NCLIENTE',
			coalesce(".$perfil.",'') as 'PERFIL',
			coalesce(date_format(p.FECHA,'%Y-%m-%d'),'') as 'FECHAMOD'
			from proyecto p
			left join cliente c on p.cliente=c.ncliente 
			left join item i on i.cliente=p.cliente and i.proyecto=p.nproyecto
			left join usuario u
			on u.nusuario=i.usuario
			left join (
				select p.NPROYECTO,sum(case when i.ESTADO='Abierto' then 1 else 0 end) as 'ESTADOS'
				from proyecto p 
				join item i
				on p.NPROYECTO=i.PROYECTO
				group by 1
			)t
			on t.NPROYECTO=p.NPROYECTO
			where c.ncliente=".$cliente."
			group by 1,2,3,4,5 order by cast(p.nproyecto as unsigned) desc limit 100
			";
		}

		$req = $Conexion->query($query);

		$projects=array();

		while ($rows = $req->fetch_array()) 
		{
			
			$projects []= $rows; 
		
		}
		
		return json_encode($projects);
	}
	

	public function InsertProjects($descripcion,$deadline,$fecha,$cliente,$proyectosingular) 
	{
		include "Conexiones.php";
  		date_default_timezone_set ('America/Argentina/Buenos_Aires');
		
		$fechaActual = date('d/m/Y');

		$query="
			INSERT INTO proyecto 
			(
				DESCRIPCION,FECHA,FECHA_ENTREGA,CLIENTE,CONTRATO
			) 
			SELECT
			 '".$descripcion."', 
			 DATE_FORMAT('".$fecha."', '%Y-%m-%d'),
			 DATE_FORMAT('".$deadline."', '%Y-%m-%d'), 
			 '".$cliente."',
			NCONTRATO
			FROM contrato 
			where estado=1 and cliente=".$cliente;

		$req=$Conexion->query($query);
		
		$res=array("res"=>"Insert");
		echo json_encode($res);
		
	}
	public function DeleteProjects($id) 
	{	
		include "Conexiones.php";
		
		$query=("delete from proyecto where NPROYECTO=".$id);
		$req = $Conexion->query($query);

		$query2=("delete from item where PROYECTO=".$id);
		$req2 = $Conexion->query($query2);

		$res="Delete";
		echo json_encode($res);
	}

	public function UpdateProjects($id,$descripcion,$deadline,$fecha,$cliente,$proyectosingular) 
	{	
		include "Conexiones.php";
				
			$query=("update proyecto p
			inner join contrato c on c.CLIENTE=".$cliente."
			set DESCRIPCION='".$descripcion."',FECHA_ENTREGA='".$deadline."',p.CLIENTE='".$cliente."'
			,FECHA='".$fecha."',CONTRATO=c.NCONTRATO
			where c.ESTADO=1 and p.NPROYECTO=".$id);

			$req = $Conexion->query($query);
			
			$query2=("update item
			set SINGULAR='".$proyectosingular."'
			where PROYECTO=".$id);
			$req2 = $Conexion->query($query2);
			
			$query3=("update item
			set CLIENTE='".$cliente."'
			where PROYECTO=".$id);
			$req3 = $Conexion->query($query3);

			$res=array("res"=>"Update");
			echo json_encode($res);
	}
}
?>












