@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Formulario para Plan Hosting Anual</h1>
        <p>Registrar Plan Hosting Anual</p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Forms</li>
        <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
      </ul>
    </div>   
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <div class="tile-body">
            <a href="{{ url('dashboard/planes-hosting') }}" class="btn btn-primary">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
          </div>
        </div>
      </div>
    </div>  
    <!-- FORM -->
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Registrar Plan Hosting</h3>
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
          <form method="POST">
            {{ csrf_field() }}
            <div class="tile-body">
              <div class="form-group">
                <label class="control-label" for="title">Título:</label>
                <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}" required autofocus>
              </div>
              <div class="form-group">
                <label for="description">
                  Agregar una descripción (cantidad de correos, base de datos, etc):
                </label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
              </div>
              <div class="form-group">
                <label for="total_price">Precio total:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">S/</span>
                  </div>
                  <input type="number" class="form-control" id="total_price" name="total_price" value="{{ old('total_price') }}" required>
                  <div class="input-group-append">
                    <span class="input-group-text">nuevos soles</span>
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
    </div><!-- /.row -->
  </main>
@endsection