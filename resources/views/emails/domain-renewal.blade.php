<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
  <head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app-email.css') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Recordatorio para renovar dominio - Grupo JYP S.A.C</title>
    <!-- <style> -->
  </head>
  <body>
    <span class="preheader"></span>
    <table class="body">
      <tr>
        <td class="center" align="center" valign="top">
          <center data-parsed="">
            <table align="center" class="wrapper header float-center">
              <tr><td class="wrapper-inner">
              <table align="center" class="container">
                <tbody><tr><td>
                <table class="row collapse">
                  <tbody><tr><th class="small-6 large-6 columns first">
                    <table><tr><th>
                      <img src="http://jypsac.com/images/logo.jpg" height="65px">
                    </th></tr></table></th>
                  <th class="small-6 large-6 columns last"><table><tr><th>
                    <p class="text-right">GRUPO JYP S.A.C</p>
                  </th></tr></table></th>
                </tr></tbody></table>
              </td></tr></tbody></table>
            </td></tr>
            </table>
            <table align="center" class="container float-center">
            <tbody>
              <tr><td>
                <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody>
                </table> 
                <table class="row">
                  <tbody>
                  <tr><th class="small-12 large-12 columns first last">
                  <table>
                    <tr><th>
         
                    <h1>Recordatorio para renovar dominio</h1>
                    <p class="lead">Estimado Julio Flores Vicuña (Grupo JYP S.A.C).</p>
                    <p>Se le recuerda que el dominio "<span style="font-weight: 600;">{{$purchasedDomain->domain_name}}</span>" vence el día <span style="font-weight: 600; color: red;">{{$purchasedDomain->finish_date->format('d-m-Y')}}</span>, favor de renovar el dominio antes de la fecha indicada para evitar futuros inconvenientes.</p>
                    <table class="callout">
                      <tr><th class="callout-inner primary">
                      <p>Nota: Pasado los 40 días de la fecha de expiración, los servicios asociados al dominio dejarán de funcionar, hasta que el dominio sea renovado nuevamente.</p>
                      </th><th class="expander"></th></tr>
                    </table>
                    </th><th class="expander"></th></tr>
                  </table>
                  </th></tr>
                  </tbody>
                </table>
              </td></tr>
            </tbody>
            </table>
            
          </center>
        </td>
      </tr>
    </table>
    <!-- prevent Gmail on iOS font size manipulation -->
   <div style="display:none; white-space:nowrap; font:15px courier; line-height:0;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div>
  </body>
</html>

