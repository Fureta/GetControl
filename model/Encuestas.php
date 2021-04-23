<?php
session_start();

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");

include "../controller/SqlEncuestas.php";

if(empty($_GET['id']))
{
    $cliente=$_SESSION['cliente'];
    $id=$_SESSION['id'];
    
    $config=new Encuestas();
    $res=$config->GetEncuestas($id,$cliente);
    echo $res;
}
else
{
    $_SESSION['cliente']=$_GET['cliente'];
    $_SESSION['id']=$_GET['id']; 
    header('Location: ../Encuestas.html');
}


?>