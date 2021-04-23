<?php


include "../lib/vendor/autoload.php";
include "../lib/Reporte/mailfinplan.php";
include "../controller/SqlMail.php";
include "../controller/SqlContracts.php";
include "../controller/SqlClients.php";

$css= file_get_contents('../lib/Reporte/style.css');

date_default_timezone_set ( 'America/Argentina/Buenos_Aires' );

$mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][date("n")-1];
$fecha=date('d/m/Y');

//traigo clientes
$perfil=1;
$clientes=0;
$mespasado=date("n");

$Clients= new Clients();
$Clients=$Clients->GetClientsMailsEndPlan();

$array = json_decode( $Clients );
foreach($array as $DATOS) {
    //traigo header del proyecto
    
    $header=new MAIL();
    $header=$header->GetHeaderEndPlan($DATOS->NCLIENTE);

    $plantilla = getMail($header);
    echo $plantilla;
    
    
/*
$to = ;
$subject = "Fin de horas ".$mes." - FindControl";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: administracion@findcontrol.info" . "\r\n" . "CC: fureta@findcontrol.info" ;

mail($to, $subject, $plantilla, $headers);
*/
}
?>