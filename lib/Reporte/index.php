<?php 
function getExtractHoursPDF($header,$items,$sum)
{
	date_default_timezone_set ( 'America/Argentina/Buenos_Aires' );
	$mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][date("n") - 2];
	$fecha=date('d/m/Y');
	
	$plantilla='
  <body>
  </br></br></br></br>
    <header class="clearfix">
		  <div id="logo">
			<img src="../img/findcontrol1.png" width="230" height="40" >
		  </div>
		  <div id="company">';
		foreach($header as $header)
		{
			$plantilla.='
				<h2 class="pro">'.$header["EMPRESA"].'</h2>
				<div>Extracción horas '.$mes.'</div>
				<div>Fecha: '.$fecha.'</div>
				<div><a href="mailto:administracion@findcontrol.info">administracion@findcontrol.info</a></div>
			</div></div>';
		}
    $plantilla.='</header>
    <main>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="unit"><h4>N°</h4></th>
			<th class="unit"><h4>Item</h4></th>
            <th class="unit"><h4>Descripcion</h4></th>
            <th class="unit"><h4>DeadLine</h4></th>
			<th class="unit"><h4>Horas</h4></th>
			
          </tr>
        </thead>
        <tbody>';

		foreach($items as $items)
		{
         $plantilla.='<tr>
            <td class="desc"><a href="login.php">'.$items["NITEM"].'</a></td>
			<td class="desc">'.$items["ITEM"].'</td>
            <td class="desc">'.$items["DESCRIPCION"].'</td>
            <td class="desc">'.$items["FECHA_ENTREGA"].'</td>
			<td class="desc">'.$items["HORAS"].'</td>
			
          </tr>';
		}
	
        $plantilla.='</tbody>
        <tfoot>
          <tr>';
		  foreach($sum as $sum)
		  {
			  $plantilla.='
						  <td class="horas" colspan="4">Total horas</td>
						  <td class="horasright" colspan="1">'.$sum["HORAS"].'</td>';
		  }
	  $plantilla.='
			</tr>
			<tr>';
  $plantilla.='
						  <td class="pago" colspan="5">Total a Pagar $'.$sum["PRECIO"].'</td>';
  $plantilla.='
          </tr>
        </tfoot>
      </table>
	  <br><br>
	      <footer>
	  El deadline será efectivo al momento de la aprobación del proyecto presentado.<br><br>
	  www.findcontrol.info
    </footer>
	</main>';
	
	return $plantilla;
}

function getExtractPlanPDF($header,$items,$sum)
{
	date_default_timezone_set ( 'America/Argentina/Buenos_Aires' );
	$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	$mes=$meses[date("n") - 1];

	$fecha=date('d/m/Y');
	
	$plantilla='
	
  <body>
  </br></br></br></br>
    <header class="clearfix">
		  <div id="logo">
			<img src="../img/findcontrol1.png" width="230" height="40" >
		  </div>
		  <div id="company">';
		foreach($header as $header)
		{
			
			$plantilla.='
				<h2 class="pro">'.$header["EMPRESA"].'</h2>
				<div>Extracción horas </div>
				<div>Fecha: '.$fecha.'</div>
				<div>Horas restantes: '.$header["TOTALHORAS"].'hs.</div>
				<div><a href="mailto:administracion@findcontrol.info">administracion@findcontrol.info</a></div>
			</div></div>';
		}
    $plantilla.='</header>
    <main>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
			<th class="unit"><h4>N°</h4></th>
			<th class="unit"><h4>Mes</h4></th>
			<th class="unit"><h4>Item</h4></th>
            <th class="unit"><h4>Descripcion</h4></th>
            <th class="unit"><h4>DeadLine</h4></th>
			<th class="unit"><h4>Horas</h4></th>
			
          </tr>
        </thead>
        <tbody>';

		foreach($items as $items)
		{
			

         $plantilla.='<tr>
			<td class="desc"><a href="items.php?id='.$items["NPROYECTO"].'&cliente='.$items["NCLIENTE"].'">'.$items["NITEM"].'</a></td>
			<td class="desc">'.$meses[$items["MES"]-1].'</td>
			<td class="desc">'.$items["ITEM"].'</td>
            <td class="desc">'.$items["DESCRIPCION"].'</td>
            <td class="desc">'.$items["FECHA_ENTREGA"].'</td>
			<td class="desc">'.$items["HORAS"].'</td>
			
          </tr>';
		}
	
        $plantilla.='</tbody>
        <tfoot>
          <tr>';
	
		foreach($sum as $sum)
		{
			$plantilla.='
						<td class="horas" colspan="5">Total horas</td>
						<td class="horasright" colspan="1">'.$sum["HORAS"].'</td>';
		}
	$plantilla.='
          </tr>
          <tr>';
$plantilla.='
						<td class="pago" colspan="6">Total a Pagar $'.$sum["PRECIO"].'</td>';
$plantilla.='
          </tr>
        </tfoot>
	  </table>
	 
	  <br><br>
	      <footer>
	  El deadline será efectivo al momento de la aprobación del proyecto presentado.<br><br>
	  www.findcontrol.info
    </footer>
	</main>';
	
	return $plantilla;
}


function getProjectPDF($header,$items,$sum){

	$plantilla='
  <body>
  </br></br></br></br>
    <header class="clearfix">
		  <div id="logo">
			<img src="../img/findcontrol1.png" width="230" height="40" >
		  </div>
		  <div id="company">';
		foreach($header as $header)
		{
			$plantilla.='
				<h2 class="pro">'.$header["EMPRESA"].'</h2>
				<div>Proyecto N° '.$header["NPROYECTO"].': '.$header["DESCRIPCION"].'</div>
				<div>Fecha: '.$header["FECHA"].'</div>
				<div><a href="mailto:administracion@findcontrol.info">administracion@findcontrol.info</a></div>
			</div></div>';
		}
    $plantilla.='</header>
    <main>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="unit"><h4>N°</h4></th>
			<th class="unit"><h4>Item</h4></th>
            <th class="unit"><h4>Descripcion</h4></th>
            <th class="unit"><h4>DeadLine</h4></th>
			<th class="unit"><h4>Horas</h4></th>
			
          </tr>
        </thead>
        <tbody>';

		foreach($items as $items)
		{
         $plantilla.='<tr>
            <td class="desc"><a href="login.php">'.$items["NITEM"].'</a></td>
			<td class="desc">'.$items["ITEM"].'</td>
            <td class="desc">'.$items["DESCRIPCION"].'</td>
            <td class="desc">'.$items["FECHA_ENTREGA"].'</td>
			<td class="desc">'.$items["HORAS"].'</td>
			
          </tr>';
		}
	
        $plantilla.='</tbody>
        <tfoot>
          <tr>';
		  foreach($sum as $sum)
		  {
			  $plantilla.='
						  <td class="horas" colspan="4">Total horas</td>
						  <td class="horasright" colspan="1">'.$sum["HORAS"].'</td>';
		  }
	  $plantilla.='
			</tr>
			<tr>';
  $plantilla.='
						  <td class="pago" colspan="5">Total a Pagar $'.$sum["PRECIO"].'</td>';
  $plantilla.='
          </tr>
        </tfoot>
      </table>
	  <br><br>
	      <footer>
      El deadline será efectivo al momento de la aprobación del proyecto presentado.<br><br>
	  www.findcontrol.info
    </footer>
	</main>';
	
	return $plantilla;
}
?>