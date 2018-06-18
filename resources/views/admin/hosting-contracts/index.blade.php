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
              <a href="{{ url('dashboard/contratos-hosting/crear') }}" class="btn btn-primary">
                <i class="fa fa-plus f-16"></i> Nuevo Contrato Hosting
              </a>
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
                  if ($hostingContract->days_to_expire > 14) {
                    $class = 'success';
                    $status = 'activo';
                    $expiration = $hostingContract->days_to_expire.' Días';
                  }
                  elseif ($hostingContract->days_to_expire > 1) {
                    $class = 'warning';
                    $status = 'Próximo a vencer';
                    $expiration = $hostingContract->days_to_expire.' Días';
                  }
                  elseif($hostingContract->days_to_expire === 1) {
                    $class = 'warning';
                    $status = 'Próximo a vencer';
                    $expiration = $hostingContract->days_to_expire.' Día';      
                  }
                  else {
                    $class = 'danger';
                    $status = 'expirado';
                    $expiration = 'Expirado';       
                  }
                ?>
                  <tr>
                    <td>N° {{ str_pad($hostingContract->id, 5, "0", STR_PAD_LEFT) }}</td>
                    <td>{{ $hostingContract->customer->full_name }}</td>
                    <td>
                      {{ $hostingContract->hostingPlanContracted->title }}
                      <span class="badge badge-pill badge-{{$class}}">{{ $status }}</span>
                    </td>
                    <td>
                      <span class="fw-600 text-{{$class}}">{{ $expiration }}</span>
                    </td>
                    <td>
                      {{ $hostingContract->total_price }} soles
                    </td>
                    <td>
                      <button type="button" class="btn btn-primary w-100"  data-toggle="modal" data-target="#hostingContract-{{ $hostingContract->id }}">Renovar</button>
                    </td>
                    <td>
                      <a href="{{ route('admin.contratos-hosting.show', $hostingContract->id) }}" class="btn btn-success w-100">Ver</a>
                    </td>
                  </tr> 
                  <!-- Modal for Renovate hostingContract -->
                  <div class="modal fade" id="hostingContract-{{ $hostingContract->id }}" tabindex="-1" role="dialog" aria-labelledby="hostingContractLabel-{{ $hostingContract->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="hostingContractlLabel-{{ $hostingContract->id }}">
                            Renovar Plan Hosting para el cliente
                          </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="POST" id="hostingContractForm-{{$hostingContract->id}}"  action="{{ route('admin.contratos-hosting.deactivate', $hostingContract->id) }}">
                          {{ method_field('PUT') }}
                          {{ csrf_field() }}
                          <input type="hidden" name="customer_id" value="{{$hostingContract->customer_id}}">
                          <div class="form-group">
                            <label for="hosting_plan_id">Plan Hosting:</label>
                            <select class="custom-select" id="hosting_plan_id" name="hosting_plan_id" required>
                              <option value="" selected disabled>
                                Seleccione un plan hosting..
                              </option>
                            @foreach($hostingPlans as $hostingPlan)
                              <option value="{{$hostingPlan->id}}">
                                {{$hostingPlan->title}}
                              </option>  
                            @endforeach
                            </select>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-5">
                              <label>Fecha de inicio:</label>
                              <input type="date" class="form-control" name="start_date" value="{{ $hostingContract->newStartDate() }}" readonly>
                            </div>    
                            <div class="form-group col-md-7">
                              <label for="contract_period">Duración del contrato:</label>
                              <select class="custom-select" id="contract_period" name="contract_period" required>
                                <option value="" selected disabled>Seleccione una opción..</option>
                                <option value="1">1 año</option>
                                <option value="2">2 años</option>
                                <option value="3">3 años</option>
                              </select>
                            </div>                  
                          </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button form="hostingContractForm-{{$hostingContract->id}}" type="submit" class="btn btn-primary" >
                            Guardar cambios
                          </button>
                        </div>
                      </div>
                    </div>
                  </div><!-- /.modal -->
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