<?php


session_start();

include "../lib/vendor/autoload.php";
include "../lib/Reporte/index.php";
include "../controller/SqlGeneratePDF.php";
include "../controller/SqlContracts.php";

$css= file_get_contents('../lib/Reporte/style.css');

date_default_timezone_set ( 'America/Argentina/Buenos_Aires' );

$mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][date("n") - 2];
$fecha=date('d/m/Y');


$proyecto=$_GET["proyecto"];
$cliente=$_GET["cliente"];
$mespasado=$_GET["mes"];

//traigo contrato del cliente
$InfoClient= new Contracts();
$InfoClient=$InfoClient->GetContractsById($cliente);

$contrato=$InfoClient[0]["OC"];
$ncontrato=$InfoClient[0]["NCONTRATO"];


//traigo header del proyecto
$header=new PDF();
$header=$header->GetHeader($cliente,$proyecto,$contrato,$ncontrato,$mespasado);


//traigo items de los proyectos segun contrato
$items=new PDF();
$items=$items->GetItems($cliente,$proyecto,$contrato,$ncontrato,$mespasado);


//traigo totales 
$sum=new PDF();
$sum=$sum->GetSum($cliente,$proyecto,$contrato,$ncontrato,$mespasado);


$mpdf = new \Mpdf\Mpdf([]);

if ($proyecto=="")
{
    if($contrato=="PLAN" || $contrato=="FIJO")
    {
        $nameReport="Extracto_Horas_".str_replace(' ','-',$header[0]["EMPRESA"]).".pdf";
        $plantilla = getExtractPlanPDF($header,$items,$sum);
    }
    else
    {
        
        $nameReport="Extracto_Horas_".str_replace(' ','-',$header[0]["EMPRESA"])."_".$mes.".pdf";

        $plantilla = getExtractHoursPDF($header,$items,$sum);
    }
}
else 
{
    $nameReport="Project_".$header[0]["NPROYECTO"]."_".str_replace(' ','-',$header[0]["EMPRESA"]).".pdf";

    $plantilla = getProjectPDF($header,$items,$sum);
    
}

$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='UTF-8';
$html = mb_convert_encoding($plantilla, 'UTF-8', 'UTF-8');
$mpdf->writeHTML($css,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->writeHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output($nameReport,"D");



?>