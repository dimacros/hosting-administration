@extends('layouts.dashboard')
@push('head')
<style>
  .btn-cpanel {
    background-color: #ff7600;
    color: #fff;
    border-color: #ff7600;
    font-style: italic;
  }

  .text-success {
    color: #076c1e!important;
  }

  .text-warning {
    color: #c09001!important;
  }

  .text-cpanel {
    color: #ff7600;
    font-size: 1.5rem;
    font-style: italic;
  }

</style>
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Clientes Hosting </h1>
          <p>Lista de todos los clientes hosting</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile bg-dark py-2">
            <div class="tile-body text-right">
              <button type="button" class="btn btn-cpanel mr-2" data-toggle="modal" data-target="#modalCpanelAccount" style="width: 80px;">cPanel</button>
              <a href="#" class="btn btn-primary">
                <i class="fa fa-money f-16"></i> Comprar Hosting
              </a>
            </div>
          </div>
        </div>
    </div>
    <!-- Modal cPanel -->
    <div class="modal fade" id="modalCpanelAccount" tabindex="-1" role="dialog" aria-labelledby="cpaneAccountlLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-light">
                <h4 class="modal-title" id="cpanelAccountlLabel">
                  Cuenta de <span class="text-cpanel">cPanel</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body bg-light">
                <div class="form-group">
                  <label>Dominio:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">http://</span>
                    </div>
                    <input type="text" class="form-control" name="domain_name" value="{{$hostingContracts->first()->cpanelAccount->domain_name}}" readonly>
                    <div class="input-group-prepend">
                      <a href="http://asd.com:2083" target="_blank" class="btn btn-outline-primary">Ir al cPanel</a>
                    </div>
                  </div> 
                </div>
                <div class="form-group">
                  <label>Usuario:</label>
                  <input type="text" class="form-control" name="user" value="{{$hostingContracts->first()->cpanelAccount->user}}" readonly>
                </div>
                <div class="form-group">
                  <label>Contraseña:</label>
                  <input type="text" class="form-control" name="password" value="{{$hostingContracts->first()->cpanelAccount->password}}" readonly>
                </div>
                <div class="form-group">
                  <label>IP Pública:</label>
                  <input type="text" class="form-control" name="public_ip" value="{{$hostingContracts->first()->cpanelAccount->public_ip}}" readonly>
                </div>
                <hr>
                <button type="button" class="btn btn-primary float-right" data-dismiss="modal">OK</button>
              </div><!-- /.modal-body -->
            </div><!-- /.modal-content -->
          </div>
        </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              @if (session('status'))
              <div class="alert alert-success" role="alert">
                <strong>{{ session('status') }}</strong>
              </div>
              <hr>
              @endif
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cliente o Empresa</th>
                    <th scope="col">Plan Contratado</th>
                    <th scope="col">Expira en </th>
                    <th scope="col">Precio total</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($hostingContracts as $hostingContract)
                <?php  
                  if ($hostingContract->expiration_date_for_humans > 14) {
                    $color = 'success';
                    $badge_text = 'Activo';
                  }
                  elseif ($hostingContract->expiration_date_for_humans >= 0 ) {
                    $color = 'warning';
                    $badge_text = 'Próximo a vencer';
                  }
                  else {
                    $color = 'danger';
                    $badge_text = 'Expirado';                    
                  }
                ?>
                  <tr>
                    <td>N° {{ $hostingContract->id }}</td>
                    <td>{{ $hostingContract->customer->full_name }}</td>
                    <td>
                      {{ $hostingContract->hostingPlanContracted->title }}
                      <span class="ml-1 badge badge-pill badge-{{$color}}">
                        {{ $badge_text }}
                      </span>
                    </td>
                    <td>
                      <span class="fw-600 text-{{$color}}">{{ $hostingContract->expiration_date_for_humans }} Días</span>
                    </td>
                    <td>
                      {{ $hostingContract->total_price }} soles
                    </td>
                  </tr> 
                @endforeach
                </tbody>
              </table>
            </div><!-- /.table-responsive -->
            <nav class="py-3" id="pagination">
              {{ $hostingContracts->links('vendor.pagination.bootstrap-4') }}
            </nav>
          </div><!-- /.tile-body -->
        </div><!-- /.tile -->
      </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
  </main>
@endsection
@push('script')
  <script type="text/javascript">
  $(document).ready(function() {
    $('#pagination').find('ul').addClass('justify-content-center');
  });
  </script>
@endpush