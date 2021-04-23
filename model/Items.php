<?php
session_start();

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");

include "../controller/SqlItems.php";

if(empty($_GET["cliente"]))
{
    $cliente=$_SESSION['cliente'];
    $id=$_SESSION['id'];
    $perfilActive=$_SESSION['perfil']; 

    $config=new Items();
    $res=$config->GetItems($id,$cliente,$perfilActive);
    echo $res;
    
}
else
{
    $_SESSION['cliente']=$_GET['cliente'];
    $_SESSION['id']=$_GET['id']; 
    header('Location: ../Items.html');
}






?>