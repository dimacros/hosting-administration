
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Recordatorio para la renovación de hosting - Grupo JYP S.A.C</title>
<link rel="stylesheet" type="text/css" href="https://zurb.com/playground/projects/responsive-email-templates/stylesheets/email.css" />
<style>
	.w-400 {
		width: 400px;
	}
	.w-200 {
		width: 200px;
	}
</style>
</head>
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table class="head-wrap" bgcolor="#999999">
<tr>
	<td></td>
		<td class="header container">
		<div class="content">
			<table bgcolor="#999999">
			<tr>
			<td><img src="https://placehold.it/200x50/" /></td>
			<td align="right"><h6 class="collapse">GRUPO JYP S.A.C</h6></td>
			</tr>
			</table>
		</div>
	</td>
	<td></td>
</tr>
</table>

<table class="body-wrap">
<tr>
	<td></td>
	<td class="container" bgcolor="#FFFFFF">
		<div class="column-wrap">
			<div class="column w-400">
				<table>
				<tr><td>

				<h4>Recordatorio para la renovación de Hosting</h4>
				<h6>Estimado(a) {{ $hostingContract->customer->full_name }}:</h6>
				<p>Se le recuerda que su contrato hosting se vence el día 
				<span style="font-weight: 600; color: red;">{{ $hostingContract->finish_date->format('d-m-Y') }}</span>, favor de renovar o cambiar su plan de hosting antes de la fecha indicada y así evitar futuros inconvenientes.</p>

				<p class="callout">
				Recuerde que pasado los 5 días de vencimiento, el sistema puede suspender sus servicios en forma automática. Sí necesita comunicarse con nosotros, entre desde el siguiente enlace: <a href="http://jypsac.com/contacto.html">Contáctenos &raquo;</a>
				</p>
				<p>Las cuentas bancarias para hacer un depósito o transferencia son:</p>
				<p>
					- Banco BCP (Cuenta Corriente en Nuevos Soles): <br/>
          * Número de Cuenta: 1942041920053 <br/>
        </p>
				<p>También puede revisar los <span style="color: #187c18; font-weight: 600; font-size: 1.1em;">precios</span> actuales de los planes hosting:</p>
				<a class="btn" href="http://jypsac.com/dominio.html" style="background-color: #187c18;">Ver Planes Hosting &raquo;</a>

				</td></tr>
				</table>
			</div><!-- /.column -->
			<div class="column w-200">
				<table>
				<tr><td>

					<ul class="sidebar">
						<li>
							<a><h5>Header Thing &raquo;</h5><p>Sub-head or something</p></a>
						</li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="">Just a Plain Link &raquo;</a></li>
						<li><a class="last">Just a Plain Link &raquo;</a></li>
					</ul>

					<table bgcolor="" class="social" width="100%">
					<tr><td>

						<table bgcolor="" class="" cellpadding="" align="left" width="100%">
						<tr><td>
							<h6 class="">Connect with Us:</h6>
							<p class=""><a href="#" class="soc-btn fb">Facebook</a> <a href="#" class="soc-btn tw">Twitter</a> <a href="#" class="soc-btn gp">Google+</a></p>
							<h6 class="">Contact Info:</h6>
							<p>Phone: <strong>408.341.0600</strong><br />
							Email: <strong><a href="emailto:hseldon@trantor.com">hseldon@trantor.com</a></strong></p>
						</td></tr>
						</table>

					</td></tr>
					</table>

				</td></tr>
				</table>
			</div><!-- /.column -->
			<div class="clear"></div>
		</div><!-- /.column-wrap -->
	</td><!-- /.container -->
	<td></td>
</tr>
</table><!-- /.body-wrap -->
</body>
</html>