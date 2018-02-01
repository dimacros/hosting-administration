@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Formulario para Proveedor de Dominio</h1>
        <p>Registrar Proveedor de Dominio</p>
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
            <a href="{{ url('dashboard/proveedores-de-dominios') }}" class="btn btn-primary">
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
          <h3 class="tile-title">Registrar Proveedor de Dominio</h3>
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
                <label class="control-label" for="company_name">Nombre de la empresa:</label>
                <input class="form-control" type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required autofocus>
              </div>
              <div class="form-group">
                <label class="control-label" for="description">Descripción de la empresa:</label>
                <input class="form-control" type="text" id="description" name="description" value="{{ old('description') }}">
              </div>
              <div class="form-group">
                <label class="control-label" for="email">Correo electrónico:</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}">
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