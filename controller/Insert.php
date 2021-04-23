
<?php
session_start();

$tipo=$_POST["type"];

if ($tipo=="InsertClients")
{
	$empresa=$_POST["Empresa"];
	$cuil=$_POST["Cuil"];
	$direccion=$_POST["Direccion"];
	$mailfacturacion=$_POST["MailFacturacion"];
	$horascontratadas=$_POST["HorasContratadas"];

	require "SqlClients.php";
    $Clientes= new Clients();
    $Clientes->InsertClients($empresa,$cuil,$direccion,$mailfacturacion,$horascontratadas);
}

if ($tipo=="InsertContracts")
{

	$cliente=$_POST['cliente'];
	$oc=$_POST['oc'];
	$valorhora=$_POST['valorhora'];
	$packhoras=$_POST['packhoras'];
	$estado=$_POST['estado'];
	$fecini=$_POST['fecini'];
	$fecfin=$_POST['fecfin'];
	
	require "SqlContracts.php";
    $proyectos= new Contracts();
    $proyectos->InsertContracts($cliente,$oc,$valorhora,$packhoras,$estado,$fecini,$fecfin);
}

if ($tipo=="InsertUsers")
{
	
	$nombre=$_POST['Nombre'];
	$mail=$_POST['Mail'];
	$cliente=$_POST['Clientes'];
	$perfil=$_POST['Perfil'];
	
	require "SqlUser.php";
    $proyectos= new Users();
    $proyectos->InsertUsers($nombre,$cliente,$perfil,$mail);
}

if ($tipo=="InsertProjects")
{
	$descripcion=$_POST["Descripcion"];
	$deadline=$_POST["DeadLine"];
	$fecha=$_POST["Fecha"];
	$cliente=$_POST['Clientes'];
	$proyectosingular=$_POST['ProyectoSingular'];

	require "SqlProjects.php";
    $proyectos= new Projects();
    $proyectos->InsertProjects($descripcion,$deadline,$fecha,$cliente,$proyectosingular);
}

if ($tipo=="InsertItems")
{
	$item=$_POST["Item"];
	$horas=$_POST["Horas"];
	$descripcion=$_POST["Descripcion"];
	$estado=$_POST["Estado"];
	$usuario=$_SESSION["usuario"];
	$id=$_SESSION["id"];
	$cliente=$_SESSION["cliente"];

	require "SqlItems.php";
    $usuarios= new Items();
    $usuarios->InsertItems($item,$horas,$descripcion,$estado,$usuario,$id,$cliente);
}

if ($tipo=="InsertEncuestas")
{
	$proyecto=$_POST["Proyecto"];
	$cliente=$_POST["Cliente"];
	$nombre=$_POST["Nombre"];
	$pregunta1=$_POST["Pregunta1"];
	$pregunta2=$_POST["Pregunta2"];
	$pregunta3=$_POST["Pregunta3"];
	$pregunta4=$_POST["Pregunta4"];
	$pregunta5=$_POST["Pregunta5"];

	require "SqlEncuestas.php";
    $Clientes= new Encuestas();
    $Clientes->InsertEncuestas($proyecto,$cliente,$nombre,$pregunta1,$pregunta2,$pregunta3,$pregunta4,$pregunta5);
}
?>
