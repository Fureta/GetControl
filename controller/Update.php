
<?php
session_start();

$tipo=$_POST["type"];


if ($tipo=="UpdateClients")
{
	$empresa=$_POST["Empresa"];
	$cuil=$_POST["Cuil"];
	$direccion=$_POST["Direccion"];
	$mailfacturacion=$_POST["MailFacturacion"];
	$id=$_POST["id"];
	
	require "SqlClients.php";
    $Clientes= new Clients();
    $Clientes->UpdateClients($id,$empresa,$cuil,$direccion,$mailfacturacion);
}

if ($tipo=="UpdateContracts")
{
	$id=$_POST['id'];
	$cliente=$_POST['cliente'];
	$oc=$_POST['oc'];
	$valorhora=$_POST['valorhora'];
	$packhoras=$_POST['packhoras'];
	$estado=$_POST['estado'];
	$fecini=$_POST['fecini'];
	$fecfin=$_POST['fecfin'];
	
	require "SqlContracts.php";
    $proyectos= new Contracts();
    $proyectos->UpdateContracts($id,$cliente,$oc,$valorhora,$packhoras,$estado,$fecini,$fecfin);
}

if ($tipo=="UpdateUsers")
{
	$nombre=$_POST["Nombre"];
	
	$mail=$_POST["Mail"];
	$cliente=$_POST["Clientes"];
	$perfil=$_POST["Perfil"];
	$id=$_POST["id"];

	require "SqlUser.php";
    $usuarios= new Users();
    $usuarios->UpdateUsers($id,$nombre,$cliente,$perfil,$mail);
}

if ($tipo=="UpdateProjects")
{
	$descripcion=$_POST["Descripcion"];
	$deadline=$_POST["DeadLine"];
	$fecha=$_POST["Fecha"];
	$clientes=$_POST["Clientes"];
	$id=$_POST["id"];
	$proyectosingular=$_POST['ProyectoSingular'];

	require "SqlProjects.php";
    $Proyectos= new Projects();
    $Proyectos->UpdateProjects($id,$descripcion,$deadline,$fecha,$clientes,$proyectosingular);
} 

if ($tipo=="UpdateItems")
{
	$item=$_POST["Item"];
	$horas=$_POST["Horas"];
	$descripcion=$_POST["Descripcion"];
	$estado=$_POST["Estado"];
	$usuario=$_SESSION["usuario"];
	$id=$_POST["id"];
	$cliente=$_SESSION["cliente"];
	
	require "SqlItems.php";
    $usuarios= new Items();
    $usuarios->UpdateItems($item,$horas,$descripcion,$estado,$usuario,$id,$cliente);
}

?>