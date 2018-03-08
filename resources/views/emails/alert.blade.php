
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Alerts e.g. approaching your limit</title>
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
              Advertencia: El dominio se vence en {{$purchasedDomain->expiration_date_for_humans}} días. Por favor actualice.
            </td>
          </tr>
          <tr>
            <td class="content-wrap">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    Estimado <strong>Julio Flores (JYP S.A.C):</strong>
                  </td>
                </tr>
                <tr>
                  <td class="content-block">
                    Se le recuerda que el dominio: <strong><a href="{{$purchasedDomain->acquiredDomain->domain_name}}">{{$purchasedDomain->acquiredDomain->domain_name}}</a></strong> que le pertenece a <strong>"{{ $purchasedDomain->customer->full_name }}"</strong> vence el día <span style="font-weight: 600; color: red;">{{$purchasedDomain->finish_date->format('d-m-Y')}}</span>, favor de renovar el dominio antes de la fecha indicada.
                  </td>
                </tr>
                <tr>
                  <td class="content-block">
                    <a href="{{url('dashboard/dominios-comprados')}}" class="btn-primary">Ir al Panel</a>
                  </td>
                </tr>
                <tr>
                  <td class="content-block">
                    <strong>Nota:</strong> Pasado los 40 días de la fecha de expiración, los servicios asociados al dominio dejarán de funcionar, hasta que el dominio sea renovado nuevamente.
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
        </div></div>
    </td>
    <td></td>
  </tr>
</table>

</body>
</html>
