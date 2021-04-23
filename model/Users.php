<?php
session_start();
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
include "../controller/SqlUser.php";


if(isset($_POST['type']))
{
    if($_POST['type']=="GetUsers")
    {
        $userActive=$_SESSION['usuario'];

        $user=new Users();
        $res=$user->GetUsers($userActive);
        echo $res;
    }
}

else
{
    if (!isset($_SESSION['usuario']))
    {
        
        $res=array("res"=>"no");
        echo json_encode($res);
    }
    else
    {
        $userActive=$_SESSION['usuario'];

        $user=new Users();
        $res=$user->GetUserById($userActive);
        echo $res;
    }
}
?>
