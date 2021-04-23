<?php

session_start();

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");

include "../controller/SqlClients.php";

$cliente=$_SESSION['cliente'];
$perfil=$_SESSION['perfil'];

$config=new Clients();
$res=$config->GetClients($cliente,$perfil);
echo $res;

?>