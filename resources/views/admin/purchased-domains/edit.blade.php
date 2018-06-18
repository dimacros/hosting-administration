@extends('layouts.dashboard')
@push('head')
<link rel="stylesheet" href="{{ asset('css/plugins/selectize.bootstrap3.css') }}">
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Actualizar datos de Compra de Dominio</h1>
        <p>Actualizar Compra de dominio</p>
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
            <a href="{{ route('admin.dominios-comprados.show', $purchasedDomain->id) }}" class="btn btn-primary">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
          </div>
        </div>
      </div>
    </section>  
    <!-- SECOND SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Actualizar Compra de dominio</h3>
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
          <form method="POST" action="{{ route('admin.dominios-comprados.update', $purchasedDomain->id) }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="tile-body">
              <div class="form-group">
                <label for="domain_provider_id">
                   Nombre del Proveedor de Dominio:
                </label>
                <select class="form-control" id="domain_provider_id" name="domain_provider_id" required>
                  <option value="{{ $purchasedDomain->domainProvider->id }}">{{ $purchasedDomain->domainProvider->company_name }}</option>
                  @foreach($domainProviders as $domainProvider)
                    <option value="{{ $domainProvider->id }}">
                      {{ $domainProvider->company_name }}
                    </option>  
                  @endforeach
                </select>
              </div> 
              <div class="form-group">
                <label for="customer_id">
                  Nombre del Cliente o la Empresa:
                </label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                  <option value="{{ $purchasedDomain->customer->id }}">{{ $purchasedDomain->customer->full_name }}</option>
                  @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>  
                  @endforeach
                </select>
              </div> 
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="start_date">Fecha de compra:</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $purchasedDomain->start_date }}" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="finish_date">Fecha de vencimiento:</label>
                  <input type="date" class="form-control" id="finish_date" name="finish_date" value="{{ $purchasedDomain->finish_date }}" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="domain_name">Nombre de dominio:</label>
                  <input type="text" class="form-control" id="domain_name" name="domain_name" value="{{ $purchasedDomain->domain_name }}" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="total_price_in_dollars">Precio total en dólares</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="number" class="form-control" id="total_price_in_dollars" name="total_price_in_dollars" value="{{ $purchasedDomain->total_price_in_dollars }}" required pattern="\d*">
                    <div class="input-group-append">
                      <span class="input-group-text">dólares</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="description">
                  Agregar una descripción sobre el dominio (DNS, soporte, etc):
                </label>
                <textarea class="form-control" id="description" name="domain_description" rows="5">{{ $purchasedDomain->description }}
                </textarea>   
              </div>
            </div><!-- /.tile-body -->
            <div class="tile-footer">
              <button class="btn btn-primary btn-lg" type="submit">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Guardar Cambios
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
      $('#domain_provider_id').selectize();
      $('#customer_id').selectize();

  });
  </script>
@endpush