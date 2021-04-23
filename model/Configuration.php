<?php
session_start();
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
include "../controller/SqlConfiguration.php";

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


$config=new ControlPanel();
$res=$config->GetCards($clientActive,$perfilActive);
echo $res;

?>
