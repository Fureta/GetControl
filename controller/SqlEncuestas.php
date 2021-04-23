<?php
class Encuestas
{
    public function GetEncuestas($id,$cliente)
	{
		include "Conexiones.php";

		$query="SELECT P.NPROYECTO,C.NCLIENTE,C.EMPRESA,P.DESCRIPCION,
        IFNULL(E.NOMBRE,'') AS 'NOMBRE',IFNULL(E.PREGUNTA1,'') AS 'PREGUNTA1',
        IFNULL(E.PREGUNTA2,'') AS 'PREGUNTA2',IFNULL(E.PREGUNTA3,'') AS 'PREGUNTA3',
        IFNULL(E.PREGUNTA4,'') AS 'PREGUNTA4',IFNULL(E.PREGUNTA5,'') AS 'PREGUNTA5'
		from proyecto P
		left join cliente C 
		ON P.CLIENTE=C.NCLIENTE 
		left join encuestas E
		ON E.NPROYECTO=P.NPROYECTO
		WHERE P.NPROYECTO=".$id." AND C.NCLIENTE=".$cliente;


		$req = $Conexion->query($query);

		$projects=array();

		while ($rows = $req->fetch_array()) 
		{
			
			$projects []= $rows; 
		
		}
		
		return json_encode($projects);
    }
    

    public function InsertEncuestas($proyecto,$cliente,$nombre,$pregunta1,$pregunta2,$pregunta3,$pregunta4,$pregunta5)
	{
        include "Conexiones.php";
  		
		$query="
			INSERT INTO encuestas 
			(
				NPROYECTO,NCLIENTE,NOMBRE,PREGUNTA1,PREGUNTA2,PREGUNTA3,PREGUNTA4,PREGUNTA5
			) 
			SELECT
             '".$proyecto."',
             '".$cliente."',
             '".$nombre."',
             '".$pregunta1."',
             '".$pregunta2."',
             '".$pregunta3."',
             '".$pregunta4."',
             '".$pregunta5."'";

		$req=$Conexion->query($query);

		$res=array("res"=>"Insert");
		echo json_encode($res);
    }

}

?>