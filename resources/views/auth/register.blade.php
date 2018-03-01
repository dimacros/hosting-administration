@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Formulario para Registrar Usuario</h1>
        <p>Registrar Usuario</p>
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
            <a href="{{ url('dashboard/user') }}" class="btn btn-primary">
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
          <h3 class="tile-title">Registrar Usuario</h3>
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
          <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="tile-body">
              <div class="form-group">
                <label for="full_name">Nombre Completo:</label>
                <input class="form-control" type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required autofocus>
              </div>
              <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="password">Contraseña:</label>
                  <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="password_confirmation">Confirmar Contraseña:</label>
                  <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
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




