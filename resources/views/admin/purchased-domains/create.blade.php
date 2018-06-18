@extends('layouts.dashboard')
@push('head')
<link rel="stylesheet" href="{{ asset('css/plugins/selectize.bootstrap3.css') }}">
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Formulario para Compra de Dominio</h1>
        <p>Registrar Compra de dominios</p>
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
            <a href="{{ route('admin.dominios-comprados.store') }}" class="btn btn-primary">
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

      <form method="POST" id="formCustomer" action="{{ route('admin.clientes.store') }}">
        {{ csrf_field() }}
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="first_name">Nombre(s):</label>
            <input class="form-control" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
          </div>
          <div class="form-group col-md-7">
            <label for="last_name">Apellidos:</label>
            <input class="form-control" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
          </div>
        </div>
        <div class="form-group">
          <label for="company_name">Empresa (opcional):</label>
          <input class="form-control" type="text" id="company_name" name="company_name" value="{{ old('company_name') }}">
        </div>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="phone">Teléfono o Celular:</label>
            <input class="form-control" type="phone" id="phone" name="phone" value="{{ old('phone') }}" pattern="[0-9-]{5,15}">
          </div>
          <div class="form-group col-md-7">
            <label for="email">Correo electrónico:</label>
            <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
          </div>
        </div>
      </form>
    @endcomponent
    <!-- SECOND SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Registrar Compra de dominio</h3>
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
          <form method="POST" id="formPurchasedDomain" action="{{ route('admin.dominios-comprados.store') }}">
            {{ csrf_field() }}
            <div class="tile-body">
              <div class="form-group">
                <label for="customer_id">
                  Nombre del Cliente o Empresa:
                </label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                  <option value="">Seleccione un cliente o empresa..</option>
                  @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>  
                  @endforeach
                </select>
              </div> 
              <div class="form-group">
                <label for="domain_provider_id">
                   Nombre del Proveedor de Dominio:
                </label>
                <select class="form-control" id="domain_provider_id" name="domain_provider_id" required>
                  <option value="">Seleccione un proveedor de dominio..</option>
                  @foreach($domainProviders as $domainProvider)
                    <option value="{{ $domainProvider->id }}">
                      {{ $domainProvider->company_name }}
                    </option>  
                  @endforeach
                </select>
              </div> 
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="start_date">Fecha de compra:</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="finish_date">Fecha de vencimiento:</label>
                  <input type="date" class="form-control" id="finish_date" name="finish_date" value="{{ old('finish_date') }}">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="see_domain_name">Nombre de dominio:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">http://</span>
                    </div>
                    <input type="text" class="form-control" id="see_domain_name" name="see_domain_name" value="{{ old('see_domain_name') }}" required>
                    <input type="hidden" id="domain_name" name="domain_name">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="total_price_in_dollars">Precio total en dólares</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" id="total_price_in_dollars" name="total_price_in_dollars" value="{{ old('total_price_in_dollars') }}" required pattern="\d*">
                    <div class="input-group-append">
                      <span class="input-group-text">.00</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="domain_description">
                  Agregar una descripción sobre el dominio (DNS, soporte, etc):
                </label>
                <textarea class="form-control" id="domain_description" name="domain_description" rows="3">{{ old('domain_description') }}</textarea>
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
<!-- Selectize plugin-->
  <script src="{{ asset('js/plugins/selectize.min.js') }}"></script>
  <script type="text/javascript">
  $(document).ready(function() {

      //Activate Plugin selectize
      $("#customer_id").selectize();
      $("#domain_provider_id").selectize({

        "render": {
          option_create: function (data, escape) {
            return '<div class="create">Agregar <strong>'+ escape(data.input) +'</strong>&hellip;</div>';
          }
        },
        "create": function(input, successCallBack) {
          $.ajax({
            beforSend:function(){

            },
            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            url: "{{ route('admin.proveedores-de-dominios.store') }}",
            type: "POST",
            dataType: "json",
            data: { company_name: input},
            error: function() {

            },
            success: function(response) {
              if(response.success === true) {
                successCallBack({ value: response.id, text: response.company_name });
              }
            },
            complete: function() {
              
            }
          });
        }

      });
    
      $("#formPurchasedDomain").submit(function(event) {
        document.getElementById('domain_name').value = 'http://' + document.getElementById('see_domain_name').value;
        return;
      });
  });
  </script>
@endpush