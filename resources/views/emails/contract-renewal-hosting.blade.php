<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
  <head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app-email.css') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Recordatorio para renovar hosting - Grupo JYP S.A.C</title>
    <!-- <style> -->
  </head>
  <body>
    <span class="preheader"></span>
    <table class="body">
      <tr>
        <td class="center" align="center" valign="top">
          <center data-parsed="">
            
            <table align="center" class="wrapper header float-center"><tr><td class="wrapper-inner">
              <table align="center" class="container"><tbody><tr><td>
                <table class="row collapse"><tbody><tr>
                  <th class="small-6 large-6 columns first"><table><tr><th>
                    <img src="http://jypsac.com/images/logo.jpg" height="65px">
                  </th></tr></table></th>
                  <th class="small-6 large-6 columns last"><table><tr><th>
                    <p class="text-right">GRUPO JYP S.A.C</p>
                  </th></tr></table></th>
                </tr></tbody></table>
              </td></tr></tbody></table>
            </td></tr></table>
            
            <table align="center" class="container float-center"><tbody><tr><td>
            
              <table class="spacer"><tbody><tr><td height="16px" style="font-size:16px;line-height:16px;">&#xA0;</td></tr></tbody></table> 
            
              <table class="row"><tbody><tr>
                <th class="sidebar small-12 large-4 columns"><table><tr><th>
                  <table class="callout"><tr><th class="callout-inner secondary">
                    <h6>Información de contacto:</h6>
                    <p>Teléfono: <br/> 408-341-0600</p>
                    <p>Correo electrónico: 
                      <a href="mailto:foundation@zurb.com">foundation@zurb.com</a>
                    </p>
                    <h6>Nuestras redes sociales:</h6>
                    <table class="button facebook expand"><tr><td><table><tr><td><center data-parsed=""><a href="#" align="center" class="float-center">Facebook</a></center></td></tr></table></td>
<td class="expander"></td></tr></table>
                    <table class="button twitter expand"><tr><td><table><tr><td><center data-parsed=""><a href="#" align="center" class="float-center">Twitter</a></center></td></tr></table></td>
<td class="expander"></td></tr></table>
                    <table class="button google expand"><tr><td><table><tr><td><center data-parsed=""><a href="#" align="center" class="float-center">Google+</a></center></td></tr></table></td>
<td class="expander"></td></tr></table>
                    
                  </th><th class="expander"></th></tr></table>
                </th></tr></table></th>
                <th class="small-12 large-8 columns last"><table><tr><th>
                  <h2>Recordatorio para la renovación de Hosting</h2>
                  <h6>Estimado(a) {{ $hostingContract->customer->full_name }}:</h6>
                  <p>Se le recuerda que su contrato hosting se vence el día <span style="font-weight: 600; color: red;">{{ $hostingContract->finish_date->format('d-m-Y') }}</span>, favor de renovar o cambiar su plan hosting antes de la fecha indicada y evitar futuros inconvenientes.</p>
                  <p>Los datos para hacer depósito o transferencia bancaria son:</p>
                  <p>
                    - Banco: BCP <br/>
                    - Cuenta Corriente en Nuevos Soles ( S/. ) <br/>
                    - Número de Cuenta: 1942041920053 <br/>
                    </p>
                  <p>Puede revisar los precios de los planes hosting en este enlace: <a href="http://jypsac.com/dominio.html">Ver-Planes-Hosting</a></p>
                  <table class="callout"><tr><th class="callout-inner secondary">
                   Nota: Pasados los 5 días de la fecha de expiración el sistema puede suspender sus servicios en forma automática.
                  </th><th class="expander"></th></tr></table>
            
                  <table class="button expand">
                    <tr><td>
                      <table>
                        <tr><td>
                        <center data-parsed="">
                          <a href="http://jypsac.com/contacto.html" align="center" class="float-center">Contáctenos</a>
                        </center>
                        </td></tr>
                      </table>
                    </td><td class="expander"></td>
                    </tr>
                  </table>
                </th></tr></table></th>
              </tr></tbody></table>
            </td></tr></tbody></table>
            
          </center>
        </td>
      </tr>
    </table>
    <!-- prevent Gmail on iOS font size manipulation -->
   <div style="display:none; white-space:nowrap; font:15px courier; line-height:0;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div>
  </body>
</html>

