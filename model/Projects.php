<?php
session_start();

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");

include "../controller/SqlProjects.php";

if(empty($_POST["cliente"]))
{
    $clientActive=$_SESSION['cliente'];
    $perfilActive=$_SESSION['perfil'];
}
else
{
    $clientActive=$_POST['cliente'];
    $perfilActive='2'; 
}


$config=new Projects();
$res=$config->GetProjects($clientActive,$perfilActive);
echo $res;

?>
