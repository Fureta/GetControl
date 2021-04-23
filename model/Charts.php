<?php
session_start();

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");

include "../controller/SqlCharts.php";

$Chart=$_POST["Chart"];


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

if ($Chart=="Pie")
{
    $config=new GetCharts();
    $res=$config->Pie($clientActive,$perfilActive);
    echo $res;
}
else if ($Chart=="Bar")
{
    $config=new GetCharts();
    $bar=$config->Bar($clientActive,$perfilActive);
    echo $bar;
}


?>
