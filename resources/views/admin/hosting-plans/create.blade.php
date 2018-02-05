@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Formulario para Cliente</h1>
        <p>Registrar Cliente</p>
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
            <a href="{{ url('dashboard/clientes') }}" class="btn btn-primary">
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
          <h3 class="tile-title">Registrar Cliente</h3>
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
                <label class="control-label" for="first_name">Nombre(s):</label>
                <input class="form-control" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
              </div>
              <div class="form-group">
                <label class="control-label" for="last_name">Apellidos:</label>
                <input class="form-control" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
              </div>
              <div class="form-group">
                <label class="control-label" for="email">Correo electrónico:</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
              </div>
              <div class="form-group">
                <label class="control-label" for="phone">Teléfono o Celular:</label>
                <input class="form-control" type="phone" id="phone" name="phone" value="{{ old('phone') }}" pattern="[0-9-]{5,15}">
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