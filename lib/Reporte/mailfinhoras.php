<?php 

function getMail($header)
{
	date_default_timezone_set ( 'America/Argentina/Buenos_Aires' );
	$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	$mes=$meses[date("n") - 1];

	$fecha=date('d/m/Y');
	
	$plantilla='
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Resumen horas FindControl</title>
            <style type="text/css">
            body {margin: 0; padding: 0; min-width: 100%!important;}
            .content {width: 100%; max-width: 600px;}  
            @media only screen and (min-device-width: 601px) {
            .content {width: 600px !important;}
            }
            .header {padding: 30px;text-align: center;}
            .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
            .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
            .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
            .col425 {width: 425px!important;}
            .innerpadding {padding: 30px 30px 30px 30px;}
            .borderbottom {border-bottom: 1px solid #f2eeed;}
            .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
            .bodycopy {font-size: 16px; line-height: 22px;}
            .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
            .button a {color: #ffffff; text-decoration: none;}
            @media only screen and (min-device-width: 601px) {
            .content {width: 600px !important;}
            .col425 {width: 425px!important;}
            .col380 {width: 380px!important;}
            }
            img {height: auto;}
            .footer {padding: 20px 30px 15px 30px;}
            .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
            .footercopy a {color: #ffffff; text-decoration: underline;}
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important; display: block!important;}
            }
            </style>
        </head>
        <body yahoo bgcolor="#fffff">
            <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <![endif]-->
            <table width="100%" bgcolor="#fffff" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <!--[if (gte mso 9)|(IE)]>
                        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <![endif]-->
                        <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="header" bgcolor="#F2F2F2">
                                    <img src="https://findcontrol.info/wp-content/uploads/2020/04/Findcontrol.png" width="200" height="100" border="0" alt="" / >  
                                </td>
                            </tr>
                            <tr>
                                <td class="innerpadding borderbottom">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="h2">
                                                Finalizaron las horas contratadas.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bodycopy">
                                                Verificar las horas consumidas en el mes.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="innerpadding borderbottom">
                                  
                                  <table class="col380" align="center" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">  
                                    <tr>
                                      <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td class="bodycopy" align="center">';
                      foreach($header as $header)
                      {
                        $plantilla.='
                          <h2 class="pro">'.$header["EMPRESA"].'</h2> <br>
                          Extracción horas<br>
                          Fecha: '.$fecha.'<br>
                          Horas contratadas: '.$header["HORASCONTRATADAS"].'<br>
                          Horas consumidas: '.$header["TOTALHORAS"].'<br>
                          
                        ';
                      }
                      $plantilla.='</td>
                                      </tr>
                                      <tr>
                                        <td style="padding: 20px 0 0 0;">
                                          <table class="buttonwrapper" bgcolor="#00a1e0" align="center" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td class="button" height="45">
                                                <a href="#">Ingresar a GetControl</a>
                                              </td>
                                            </tr>
                                          </table>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                    <td class="innerpadding borderbottom">
                                        
                                    </td>
                                </tr>
                              </table>
                              <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                  </tr>
                              </table>
                              <![endif]-->
                            </td>
                          </tr>
                          <tr>
                            <td class="footer" bgcolor="#F2F2F2">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="center" class="footercopy">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                    <td align="center" style="padding: 20px 0 0 0; font-size: 12px; line-height: 22px;color: #153643; font-family: sans-serif;" >
                                    Ante cualquier duda o consulta escribir a <a href="mailto:administracion@findcontrol.info">administracion@findcontrol.info</a><br>
                                    ¡Muchas gracias!<br><br>
                                    
                                    <table border="0" cellspacing="0" cellpadding="0" >
                                        <tr>
                                            <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                                                <a href="https://www.linkedin.com/company/64251551/">
                                                    <img src="https://img.icons8.com/color/48/000000/linkedin-2--v1.png" width="37" height="37" alt="LinkedIn" border="0"  />
                                                </a>
                                            </td>
                                            <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                                                <a href="https://www.findcontrol.info/GetControl">
                                                    <img src="https://findcontrol.info/wp-content/uploads/2020/08/Get-Control_Logo_lock.jpg" width="37" height="37" alt="GetControl" border="0" style="-webkit-border-radius: 130px; -moz-border-radius: 130px; border-radius: 130px;"/>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                     <!--[if (gte mso 9)|(IE)]>
                            </td>
                        </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
        </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </body>
</html>';
	
	return $plantilla;
}

?>