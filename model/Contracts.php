<?php

session_start();

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods'); 
header('Content-Type: application/json');
header("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");

include "../controller/SqlContracts.php";

$config=new Contracts();
$res=$config->GetContracts();
echo $res;

?>