@extends('layouts.dashboard')

@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        <p>A free and modular admin template</p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
          <div class="info">
            <h4>Usuarios sin activar</h4>
            <p><strong>{{ $users->count() }}</strong></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-exclamation-circle fa-3x"></i>
          <div class="info">
            <h4>Contratos por expirar</h4>
            <p>
              <strong>{{ $hostingContracts->count() }}</strong>
              <a href="{{ route('admin.contratos-hosting.to-expire') }}" class="ml-1">
                Ir ahora <i class="fa fa-angle-double-right" aria-hidden="true"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-ticket fa-3x"></i>
          <div class="info">
            <h4>Tickets sin contestar</h4>
            <p><strong>{{ $tickets->count() }}</strong></p>
          </div>
        </div>
      </div>
    </div><!--/.row-->
    <div class="row">
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Usuarios sin activar</h3>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              <strong>{{ session('status') }}</strong>
            </div>
          @endif
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre completo</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->full_name }}</td>
              <td>
                <form action="{{ route('admin.usuarios.activate', $user->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}                 
                  <button type="submit" class="btn btn-success w-100">Activar</button>
                </form>
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Tickets sin contestar</h3>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Asunto del ticket</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($tickets as $ticket)
            <tr>
              <td><strong>{{ $ticket->helpTopic->title }}|</strong> {{ $ticket->subject }}</td>
              <td><a href="{{ route('auth.tickets.show', $ticket->id) }}" class="btn btn-success w-100">Responder</a></td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>        
    </div><!--/.row-->
  </main>
@endsection