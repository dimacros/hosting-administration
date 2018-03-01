@extends('layouts.dashboard')
@push('head')
<link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.css') }}">
<style>
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
        <h1><i class="fa fa-edit"></i> Formulario para Contrato Hosting</h1>
        <p>Registrar Contrato Hosting</p>
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
          <div class="tile-body">
            <a href="{{ url('dashboard/contratos-hosting') }}" class="btn btn-primary">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalCustomer">
              Agregar Cliente
            </button>
          </div>
        </div>
      </div>
    </section>  
    <!-- MODAL PARA AGREGAR CLIENTE -->
      @component('components.modal', [ 
        'modalId' => 'modalCustomer', 
        'modalTitle' => 'Agregar nuevo Cliente',
        'btnCloseClass' => 'btn btn-secondary', 
        'btnCloseTitle' => 'Cerrar', 
        'btnSaveClass' => 'btn btn-primary', 
        'btnSaveTitle' => 'Registrar',
        'FormId' => 'formCustomer',
      ])

      <form method="POST" id="formCustomer" action="{{ url('dashboard/clientes/crear') }}">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="first_name">Nombre(s):</label>
          <input class="form-control" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
        </div>
        <div class="form-group">
          <label for="last_name">Apellidos:</label>
          <input class="form-control" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>
        <div class="form-group">
          <label for="company_name">Empresa (opcional):</label>
          <input class="form-control" type="text" id="company_name" name="company_name" value="{{ old('company_name') }}">
        </div>
        <div class="form-group">
          <label for="email">Correo electrónico:</label>
          <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
          <label for="phone">Teléfono o Celular:</label>
          <input class="form-control" type="phone" id="phone" name="phone" value="{{ old('phone') }}" pattern="[0-9-]{5,15}">
        </div>
      </form>
    @endcomponent
    <!-- SECOND SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Registrar Contrato Hosting</h3>
          <hr>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              <strong>{{ session('status') }}</strong>
            </div>
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
        <!-- START FORM -->
          <form method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{Auth::id()}}">
            <div class="tile-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="customer_id">
                    Nombre del Cliente:
                  </label>
                  <select class="form-control" id="customer_id" name="customer_id" required>
                    <option value="">Seleccione un cliente..</option>
                  @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>  
                  @endforeach
                  </select>
                </div>  
                <div class="form-group col-md-6">
                  <label for="hosting_plan_id">Plan Hosting:</label>
                  <select class="custom-select" id="hosting_plan_id" name="hosting_plan_id" required>
                    <option value="" selected disabled>Seleccione un plan hosting..</option>
                  @foreach($hostingPlans as $hostingPlan)
                    <option value="{{$hostingPlan->id}}">{{$hostingPlan->title}}</option>  
                  @endforeach
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="start_date">Fecha de inicio:</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="contract_period">Duración del contrato:</label>
                  <select class="custom-select" id="contract_period" name="contract_period" required>
                    <option value="" selected disabled>Seleccione una opción..</option>
                    <option value="1">1 año</option>
                    <option value="2">2 años</option>
                    <option value="3">3 años</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <h6>¿Desea crear una cuenta de cPanel?</h6>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="create_account_yes" name="create_account" value="yes" required>
                  <label class="custom-control-label" for="create_account_yes">SÍ</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="create_account_no" name="create_account" value="no" >
                  <label class="custom-control-label" for="create_account_no">NO</label>
                </div>
              </div>
              <div class="bg-light p-4" id="createAccount" style="display: none;">
                <h4>Nueva cuenta de <span class="text-cpanel">cPanel</span></h4>
                <hr>
                <div class="form-group row">
                  <label class="col-sm-2" for="cpanel_domain_name">Dominio:</label>
                  <div class="col-sm-10 input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">http://</span>
                    </div>
                    <input type="text" class="form-control" id="cpanel_domain_name" name="cpanel[domain_name]">
                  </div>  
                </div>
                <div class="form-group row">
                  <label class="col-sm-2" for="">Usuario:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="cpanel[user]">
                  </div>  
                </div>
                <div class="form-group row">
                  <label class="col-sm-2" for="">Contraseña:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="cpanel[password]">
                  </div>  
                </div>
                <div class="form-group row">
                  <label class="col-sm-2" for="">IP Pública:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="cpanel[public_ip]">
                  </div>  
                </div>
              </div>
            </div><!-- /.tile-body -->
            <div class="tile-footer">
              <button class="btn btn-primary btn-lg" type="submit">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar
              </button>
            </div>
          </form>
        </div><!-- /.tile -->
      </div><!-- /.col-md-8 offset-md-2 -->
    </section><!-- /.row -->
  </main>
@endsection
@push('script')
<!-- Select plugin-->
  <script src="{{ asset('js/plugins/selectize.min.js') }}"></script>
  <script type="text/javascript">
  $(document).ready(function() {

    $('#customer_id').selectize();

    /*
    * CUSTOM cPanel Account
    *****************************
    */
      $('input[type="radio"]').click(function() {
         if($(this).attr('id') === 'create_account_yes') {
          $('#createAccount').show("slow");           
         }
         else {
          $('#createAccount').hide(1000);   
         }
     });

  });
  </script>
@endpush