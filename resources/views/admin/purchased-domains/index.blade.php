@extends('layouts.dashboard')
@push('head')
<style>
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
          <h1><i class="fa fa-th-list"></i> Dominios Comprados</h1>
          <p>Lista de todos los dominios comprados</p>
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
              <a href="{{ url('dashboard/dominios-comprados/crear') }}" class="btn btn-primary">Comprar un dominio</a>
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
                    <th scope="col">Nombre del Cliente o Empresa</th>
                    <th scope="col">Nombre de Dominio</th>
                    <th scope="col">Días para Caducar</th>
                    <th scope="col">Precio de Compra</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($purchasedDomains as $purchasedDomain)
                <?php  
                  if ($purchasedDomain->expiration_date_for_humans > 14) {
                    $color = 'success';
                    $badge_text = 'Activo';
                  }
                  elseif ($purchasedDomain->expiration_date_for_humans >= 0 ) {
                    $color = 'warning';
                    $badge_text = 'Próximo a vencer';
                  }
                  else {
                    $color = 'danger';
                    $badge_text = 'Expirado';                    
                  }
                ?>
                  <tr>
                    <td>N° {{ $purchasedDomain->id }}</td>
                    <td>{{ $purchasedDomain->customer->full_name }}</td>
                    <td>
                      {{ $purchasedDomain->acquiredDomain->domain_name }}
                      <span class="ml-1 badge badge-pill badge-{{$color}}">
                        {{ $badge_text }}
                      </span>
                    </td>
                    <td>
                      <span class="fw-600 text-{{$color}}">{{ $purchasedDomain->expiration_date_for_humans }} Días</span>
                    </td>
                    <td>$ {{ $purchasedDomain->total_price_in_dollars }}</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modal-{{ $purchasedDomain->id }}">Renovar</button>
                    </td>
                    <td>
                      <a href="{{ route('admin.dominios-comprados.show', $purchasedDomain->id) }}" class="btn btn-success w-100">Ver</a>        
                    </td>
                  </tr>
                  <!-- Modal -->
                  <div class="modal fade" id="modal-{{ $purchasedDomain->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $purchasedDomain->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalLabel-{{ $purchasedDomain->id }}">
                            Renovar Dominio
                          </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body my-3">
                          <form method="POST" id="purchasedDomain-{{ $purchasedDomain->id }}" action="{{ route(
                            'admin.dominios-comprados.renovar', $purchasedDomain->id
                            )}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="acquired_domain_id" value="{{ $purchasedDomain->acquired_domain_id }}">
                            <input type="hidden" name="domain_provider_id" value="{{ $purchasedDomain->domain_provider_id }}">
                            <input type="hidden" name="customer_id" value="{{ $purchasedDomain->customer_id }}">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                            <div class="form-group">
                              <label>Proveedor de dominio:</label>
                              <input type="text" class="form-control" value="{{ $purchasedDomain->domainProvider->company_name }}" readonly>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-5">
                                <label>Fecha de inicio:</label>
                                <input type="date" class="form-control" name="start_date" value="{{ $purchasedDomain->start_date_to_renovate }}" readonly>
                              </div>    
                              <div class="form-group col-md-7">
                                <label>Fecha de vencimiento:</label>
                                <input type="date" class="form-control" name="finish_date" required>
                              </div>                  
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-5">
                                <label>
                                  Precio total en dólares
                                </label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                  </div>
                                  <input type="text" class="form-control" name="total_price_in_dollars" required pattern="\d*">
                                  <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                  </div>
                                </div>
                              </div>                      
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button form="purchasedDomain-{{ $purchasedDomain->id }}" type="submit" class="btn btn-primary">Guardar cambios</button>
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
