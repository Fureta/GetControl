<?php


class Items 
{

    public function GetItems($id,$cliente,$perfil)
	{
		include "Conexiones.php";

		date_default_timezone_set("America/Argentina/Buenos_Aires");
		$mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][date("n") - 1];
		
		
			$query="select 
			coalesce(i.nitem,'') as 'NITEM',
			coalesce(i.item,'') as 'ITEM',
			coalesce(i.descripcion,'') as 'DESCRIPCION',
			coalesce(i.horas,'') as 'HORAS',
            coalesce(i.precio,'') as 'PRECIO',
			coalesce(u.nombre,'') as 'USUARIO',
			coalesce(i.estado,'') as 'ESTADO',
			coalesce(ncliente,'') as 'NCLIENTE',
			coalesce(nproyecto,'') as 'NPROYECTO',
			coalesce(p.descripcion,'') as 'PRODESCRIPCION',
			coalesce(".$perfil.",'') as 'PERFIL'
            from proyecto p
            left join item i 
            on p.nproyecto=i.proyecto 
            left join cliente c 
            on c.ncliente=p.cliente
            left join usuario u
            on u.nusuario=i.usuario 
            where p.nproyecto=".$id."
			";

			
		$req = $Conexion->query($query);

		$projects=array();

		while ($rows = $req->fetch_assoc()) 
		{
			
			$projects []= $rows; 
		
		}
		return json_encode($projects);
	}

	public function InsertItems($item,$horas,$descripcion,$estado,$usuario,$id,$cliente) 
	{
		include "Conexiones.php";
  		$fechaActual = date('d-m-Y H:i:s');
		
		$query=
		("
			INSERT INTO item 
			(
				ITEM,PROYECTO,CLIENTE,DESCRIPCION,HORAS,VALOR_HORA,PRECIO,USUARIO,ESTADO
			) 
			select
			 '".$item."', 
			 '".$id."',
			 '".$cliente."', 
			 '".$descripcion."',
			 '".$horas."',
			 VALORHORACON,
			  ".$horas."*VALORHORACON,
			 '".$usuario."',
			 '".$estado."'
			from proyecto p
			join cliente c
			on p.cliente=c.ncliente
			join contrato con
			on con.ncontrato=p.contrato
			where con.estado=1 and p.nproyecto=".$id
		);

		$req=$Conexion->query($query);	

		$res=array("res"=>"Insert");
		echo json_encode($res);
	} 

	public function DeleteItems($item) 
	{	

		include "Conexiones.php";

		$query=("delete from item where nitem=".$item);
		
		$req = $Conexion->query($query);

		$res=array("res"=>"Insert");
		echo json_encode($res);
	}

	public function UpdateItems($item,$horas,$descripcion,$estado,$usuario,$nitem,$cliente) 
	{	
		include "Conexiones.php";

		$fechaActual = date('d-m-Y H:i:s');

		$sentenciaSQL=("update item
		set ITEM='".$item."',HORAS='".$horas."',PRECIO=".$horas."*VALOR_HORA,DESCRIPCION='".$descripcion."',ESTADO='".$estado."',USUARIO='".$usuario."'
		where NITEM=".$nitem);

		$query = $Conexion->query($sentenciaSQL);

		$res=array("res"=>"Update");
		echo json_encode($res);
	}
	 
}






?>