@extends('layouts.dashboard')
@push('head')
<style>
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

</style>
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Ver datos del Contrato Hosting</h1>
        <p>Ver Contrato Hosting</p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Forms</li>
        <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
      </ul>
    </div>   
    <!-- FIRST SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <div class="tile-body text-right">
            <a href="{{url('dashboard/contratos-hosting')}}" class="btn btn-primary float-left">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
            <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#modalSuspended">Suspender</button>
            <button type="button" class="btn btn-cpanel mr-2"  data-toggle="modal" data-target="#modalCpanelAccount" style="width: 80px;">cPanel</button>
            <a href="{{ route('admin.contratos-hosting.edit', $hostingContract->id) }}" class="btn btn-primary">Editar</a>
          </div>
        </div>
      </div>
    </section> 
    <!-- Modal cPanel-->
    <div class="modal fade" id="modalCpanelAccount" tabindex="-1" role="dialog" aria-labelledby="cpaneAccountlLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h4 class="modal-title" id="cpanelAccountlLabel">
              Cuenta de <span class="text-cpanel">cPanel</span>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body bg-light">
          <form method="POST" id="formCpanelAccount" action="{{ route('admin.cuentas-cpanel.actualizar', $hostingContract->cpanelAccount->id) }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
              <label>Dominio:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">http://</span>
                </div>
                <input type="text" class="form-control" name="domain_name" value="{{$hostingContract->cpanelAccount->domain_name}}" required>
                <div class="input-group-prepend">
                  <a href="http://{{$hostingContract->cpanelAccount->domain_name}}:2083" target="_blank" class="btn btn-outline-primary">Ir al cPanel</a>
                </div>
              </div> 
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
          </div><!-- /.modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" form="formCpanelAccount" class="btn btn-primary" >Guardar cambios</button>
          </div>
        </div><!-- /.modal-content -->
      </div>
    </div><!-- /.modal -->
    <!-- Modal Delete -->
    @component('components.modal', [ 
      'modalId' => 'modalSuspended', 
      'modalTitle' => 'Eliminar',
      'btnCloseClass' => 'btn btn-danger w-25', 
      'btnCloseTitle' => 'No', 
      'btnSaveClass' => 'btn btn-success w-25', 
      'btnSaveTitle' => 'Sí',
      'FormId' => 'formSuspended',
    ])

      <h5>¿Seguro que quiere suspender el contrato hosting de "{{$hostingContract->customer->full_name}}"?</h5>
        <form class="d-none" method="POST" id="formSuspended" action="{{ route('admin.contratos-hosting.destroy', $hostingContract->id) }}">
          {{ method_field('DELETE') }}
          {{ csrf_field() }}       
        </form>
    @endcomponent   
    <!-- SECOND SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Datos del Contrato Hosting</h3>
          <hr>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              <strong>{{ session('status') }}</strong>
            </div>
          @endif
          <!-- START TILE -->
          <div class="tile-body">
            <div class="form-group">
              <label>Nombre del Cliente o Empresa:</label>
              <input type="text" class="form-control" value="{{ $hostingContract->customer->full_name }}" readonly>
            </div> 
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Plan Hosting:</label>
                <input type="text" class="form-control" value="{{ $hostingContract->hostingPlanContracted->title }}" readonly>
              </div>
              <div class="form-group col-md-6">
                <label>Precio total en soles</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">S/</span>
                  </div>
                  <input type="text" class="form-control" value="{{ $hostingContract->total_price }}" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">nuevos soles</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Fecha de inicio:</label>
                  <input type="date" class="form-control" value="{{ $hostingContract->start_date->toDateString() }}" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label>Fecha de vencimiento:</label>
                  <input type="date" class="form-control" value="{{ $hostingContract->finish_date->toDateString() }}" readonly>
                </div>
            </div>
          </div><!-- /.tile-body -->
        </div><!-- /.tile -->
      </div><!-- /.col-md-8 offset-md-2 -->
    </section><!-- /.row -->
  </main>
@endsection

