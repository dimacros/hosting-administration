@extends('layouts.dashboard')
@push('head')
<style>
  .text-success {
    color: #076c1e!important;
  }

  .text-warning {
    color: #c09001!important;
  }

  .badge-pill {
    margin-left: 0.25rem;
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
          <div class="tile bg-dark py-2">
            <div class="tile-body text-right">
              <a href="{{ url('dashboard/dominios-comprados/crear') }}" class="btn btn-primary"><i class="fa fa-plus f-16"></i> Comprar un Nuevo Dominio</a>
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
                  if ($purchasedDomain->days_to_expire > 14) {
                    $class = 'success';
                    $status = 'activo';
                    $expiration = $purchasedDomain->days_to_expire.' Días';
                  }
                  elseif ($purchasedDomain->days_to_expire > 1) {
                    $class = 'warning';
                    $status = 'Próximo a vencer';
                    $expiration = $purchasedDomain->days_to_expire.' Días';
                  }
                  elseif($purchasedDomain->days_to_expire === 1) {
                    $class = 'warning';
                    $status = 'Próximo a vencer';
                    $expiration = $purchasedDomain->days_to_expire.' Día';      
                  }
                  else {
                    $class = 'danger';
                    $status = 'expirado';
                    $expiration = 'Expirado';       
                  }
                ?>
                  <tr>
                    <td>N° {{ str_pad($purchasedDomain->id, 5, "0", STR_PAD_LEFT) }}</td>
                    <td>{{ $purchasedDomain->customer->full_name }}</td>
                    <td>
                      @if( $purchasedDomain->status === 'suspended' )
                        <del>{{ $purchasedDomain->domain_name }}</del>
                      @else 
                        {{ $purchasedDomain->domain_name }}
                      @endif
                      <span class="badge badge-pill badge-{{$class}}">{{ $status }}</span>
                    </td>
                    <td>
                      <span class="fw-600 text-{{$class}}">{{ $expiration }}</span>
                    </td>
                    <td>
                      @if( $purchasedDomain->status === 'suspended' )
                        <del>$ {{ $purchasedDomain->total_price_in_dollars }}</del>
                      @else 
                        $ {{ $purchasedDomain->total_price_in_dollars }}
                      @endif
                    </td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modal-{{ $purchasedDomain->id }}">Renovar</button>
                    </td>
                    <td>
                      <a href="{{ route('admin.dominios-comprados.show', $purchasedDomain->id) }}" class="btn btn-success w-100">Ver</a>        
                    </td>
                  </tr>
                  <!-- MODAL PARA RENOVAR CONTRATO -->
                  @component('components.modal', [ 
                      'modalId' => 'modal-'. $purchasedDomain->id, 
                      'modalTitle' => 'Renovar Dominio',
                      'btnCloseClass' => 'btn btn-secondary', 
                      'btnCloseTitle' => 'Cerrar', 
                      'btnSaveClass' => 'btn btn-primary', 
                      'btnSaveTitle' => 'Guardar cambios',
                      'FormId' => 'form-'. $purchasedDomain->id
                    ])

                    <form method="POST" id="form-{{ $purchasedDomain->id }}" action="{{ route('admin.dominios-comprados.renovate') }}">
                      {{ csrf_field() }}
                      <input type="hidden" name="customer_id" value="{{ $purchasedDomain->customer->id }}">
                      <input type="hidden" name="domain_provider_id" value="{{ $purchasedDomain->domainProvider->id }}">
                      <div class="form-group">
                        <label>Proveedor de dominio:</label>
                        <input type="text" class="form-control" value="{{ $purchasedDomain->domainProvider->company_name }}" readonly>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-5">
                          <label>Fecha de inicio:</label>
                          <input type="date" class="form-control" name="start_date" value="{{ $purchasedDomain->newStartDate() }}" readonly>
                        </div>    
                        <div class="form-group col-md-7">
                          <label>Fecha de vencimiento:</label>
                          <input type="date" class="form-control" name="finish_date" required>
                        </div>                  
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-5">
                          <label>Precio total en dólares</label>
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
                  @endcomponent
                @endforeach
                </tbody>
              </table>
            </div><!-- /.table-responsive -->
            <nav class="py-3" id="pagination">
              {{ $purchasedDomains->links('vendor.pagination.bootstrap-4') }}
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