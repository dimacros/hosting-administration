@extends('layouts.dashboard')
@push('head')
<link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.css') }}">
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i>Actualizar datos de Contrato Hosting</h1>
        <p>Actualizar Contrato Hosting</p>
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
            <a href="{{ route('admin.contratos-hosting.show', $hostingContract->id) }}" class="btn btn-primary">
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
          <h3 class="tile-title">Editar Contrato Hosting</h3>
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
          <form method="POST" action="{{ route('admin.contratos-hosting.update', $hostingContract->id) }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{Auth::id()}}">
            <input type="hidden" name="hosting_plan_contracted_id" value="{{ $hostingContract->hostingPlanContracted->id }}">
            <div class="tile-body">
              <div class="form-group">
                <label for="customer_id">Nombre del Cliente o Empresa:</label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                  <option value="{{ $hostingContract->customer->id }}">
                    {{ $hostingContract->customer->full_name }}
                  </option>
                  @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>  
                  @endforeach
                </select>
              </div> 
              <div class="form-row">
                <div class="form-group col-md-7">
                  <label for="hosting_plan_title">Título del Plan Hosting Contratado:</label>
                  <input type="text" class="form-control" id="hosting_planContracted_title" name="hosting_plan_contracted_title" value="{{ $hostingContract->hostingPlanContracted->title }}" required>
                </div>
                <div class="form-group col-md-5">
                  <label for="total_price">Precio total en soles</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">S/</span>
                    </div>
                    <input type="number" class="form-control" id="total_price" name="total_price" value="{{ $hostingContract->total_price }}" required pattern="\d*">
                    <div class="input-group-append">
                      <span class="input-group-text">soles</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="hosting_plan_description">Descripción del Plan Hosting Contratado:</label>
                <textarea class="form-control" id="hosting_plan_description" name="hosting_plan_contracted_description" rows="5" required>{{ $hostingContract->hostingPlanContracted->description }}</textarea>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="start_date">Fecha de inicio:</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $hostingContract->start_date->toDateString() }}" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="finish_date">Fecha de vencimiento:</label>
                  <input type="date" class="form-control" id="finish_date" name="finish_date" value="{{ $hostingContract->finish_date->toDateString() }}" required>
                </div>
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
<!-- Select plugin-->
  <script src="{{ asset('js/plugins/selectize.min.js') }}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#customer_id').selectize();
  });
  </script>
@endpush