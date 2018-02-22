@extends('layouts.dashboard')
@push('head')
<style>
  .btn {
    font-size: 1rem;
  }

  .btn-cpanel {
    background-color: #ff7600;
    color: #fff;
    border-color: #ff7600;
    font-style: italic;
  }

  .text-cpanel {
    color: #ff7600;
    font-size: 1.5rem;
    font-style: italic;
  }

  .fw-600 {
    font-weight: 600;
  }

  .text-success {
    color: #076c1e!important;
  }

  .text-warning {
    color: #c09001!important;
  }
</style>
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Contratos Hosting </h1>
          <p>Lista de todos los contratos hosting</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <a href="{{ url('dashboard/contratos-hosting/crear') }}" class="btn btn-primary">Nuevo contrato Hosting</a>
            </div>
          </div>
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
                    <th></th>
                    <th></th>
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
                    <td>N° {{ str_pad($hostingContract->id, 5, "0", STR_PAD_LEFT) }}</td>
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
                      {{ $hostingContract->total_price }} nuevos soles
                    </td>
                    <td>
                      <button type="button" class="btn btn-cpanel w-100"  data-toggle="modal" data-target="#cpanel-{{ $hostingContract->id }}">cPanel</button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-success w-100"  data-toggle="modal" data-target="#modal-{{ $hostingContract->id }}">VER</button>
                    </td>
                  </tr> 
                  <!-- Modal -->
                  <div class="modal fade" id="cpanel-{{ $hostingContract->id }}" tabindex="-1" role="dialog" aria-labelledby="cpanelLabel-{{ $hostingContract->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-light">
                          <h4 class="modal-title" id="cpanellLabel-{{ $hostingContract->id }}">
                            Cuenta de <span class="text-cpanel">cPanel</span>
                          </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body bg-light">
                        <form method="POST" id="formEdit-{{$hostingContract->cpanelAccount->id}}" action="{{ route('admin.cuentas-cpanel.actualizar', $hostingContract->cpanelAccount->id) }}">
                          {{ method_field('PUT') }}
                          {{ csrf_field() }}
                          <div class="form-group">
                            <label>Dominio:</label>
                            <input type="text" class="form-control" name="domain_name" value="{{$hostingContract->cpanelAccount->domain_name}}" required>
                          </div>
                          <div class="form-group">
                            <label>Usuario:</label>
                            <input type="text" class="form-control" name="user" value="{{$hostingContract->cpanelAccount->user}}" required>
                          </div>
                          <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="text" class="form-control" name="password" value="{{$hostingContract->cpanelAccount->password}}">
                          </div>
                          <div class="form-group">
                            <label>IP Pública:</label>
                            <input type="text" class="form-control" name="public_ip" value="{{$hostingContract->cpanelAccount->public_ip}}">
                          </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button form="formEdit-{{$hostingContract->cpanelAccount->id}}" type="submit" class="btn btn-primary" >
                            Guardar cambios
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>  
                @endforeach
                </tbody>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.tile-body -->
        </div><!-- /.tile -->
      </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
  </main>

@endsection
@push('script')

@endpush