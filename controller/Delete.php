
<?php

$tipo=$_POST["type"];

if ($tipo=="DeleteClients")
{

	require "SqlClients.php";
    $Clientes= new Clients();
    $Clientes->DeleteClients($_POST["id"]);
}

if ($tipo=="DeleteContracts")
{

	require "SqlContracts.php";
    $Clientes= new Contracts();
    $Clientes->DeleteContracts($_POST["id"]);
}

else if ($tipo=="DeleteUsers")
{
	require "SqlUser.php";
    $usuarios= new Users();
    $usuarios->DeleteUsers($_POST["id"]);
}
else if ($tipo=="DeleteItems")
{
	require "SqlItems.php";
    $usuarios= new Items();
    $usuarios->DeleteItems($_POST["id"]);
}
else if ($tipo=="DeleteProjects")
{
    $id=$_POST["id"];

	require "SqlProjects.php";
    $Proyectos= new Projects();
    $Proyectos->DeleteProjects($id);
} 
?>