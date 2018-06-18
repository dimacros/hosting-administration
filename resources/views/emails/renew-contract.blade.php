<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Renovar contrato hosting</title>
<link href="{{ asset('css/email.css') }}" media="all" rel="stylesheet" type="text/css" />
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">

<table class="body-wrap">
  <tr>
    <td></td>
    <td class="container" width="600">
      <div class="content">
        <table class="main" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td class="alert alert-warning">
              Advertencia: El contrato hosting se vence en {{($hostingContract->days_to_expire !== 1)?$hostingContract->days_to_expire.' días':'1 día'}}. Por favor actualice.
            </td>
          </tr>
          <tr>
            <td class="content-wrap">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    Estimado <strong>{{$hostingContract->customer->full_name}}:</strong>
                  </td>
                </tr>
                <tr>
                  <td class="content-block">
                    <p>Se le recuerda que el plan hosting vence el <span style="font-weight: 600; color: red;">{{date("d-m-Y", strtotime($hostingContract->finish_date))}}</span>. Se le pide actualizar el plan y evitar futuros inconvenientes. La cuenta para el depósito o transferencia bancaria es:</p>
                    <ul> 
                      <li>Banco BCP - Cuenta Corriente en Nuevos Soles ( S/. ): </li>
                      <li><strong>Número de Cuenta:</strong> 1942041920053 </li>
                    </ul>
                  </td>
                </tr>
                <!--<tr>
                  <td class="content-block"></td>                  
                </tr>-->
                <tr>
                  <td class="content-block" align="center">
                    <a href="http://jypsac.com/dominio.html" class="btn-primary">Ver todos los planes</a>
                  </td>
                </tr>
                <tr>
                  <td class="content-block">
                    <strong>Nota:</strong> Pasado los 7 días de la fecha de expiración el sistema puede suspender sus servicios en forma automática. Puede contactarse a <a href="mailto:ventas@jypsac.com">ventas@jypsac.com</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div class="footer">
          <table width="100%">
            <tr>
              <td class="aligncenter content-block">
                <a href="http://jypsac.com/">JYP S.A.C.</a> Derechos reservados.
              </td>
            </tr>
          </table>
        </div>
      </div><!--/.content-->
    </td><!--/.container-->
    <td></td>
  </tr>
</table>

</body>
</html>
