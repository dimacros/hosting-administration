@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Mis Tickets </h1>
          <p>Lista de todos mis tickets.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile bg-dark py-2">
            <div class="tile-body text-right">
              <a href="{{route('customer.tickets.create')}}" class="btn btn-primary">
                <i class="fa fa-plus f-16"></i> Crear un Ticket
              </a>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              @if (session('status'))
              <div class="alert alert-success" role="alert">
                <strong>{{ session('status') }}</strong>
              </div>
              <hr>
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
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="thead-dark text-center">
                  <tr>
                    <th scope="col">Ticket N°</th>
                    <th scope="col">Asunto del Ticket</th>
                    <th scope="col"> Última actualización </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="text-center">
                @foreach($tickets as $ticket)
                  <tr>
                    <td><strong>#{{ $ticket->id }}</strong></td>
                    <td class="f-16">
                      <strong>{{ $ticket->helpTopic->title }}|</strong> 
                      {{ $ticket->subject }} {!! $ticket->badge !!}
                    </td>
                    <td>Hace {{ $ticket->updated_at }}</td>
                    <td>
                      <a href="{{ route('auth.tickets.show', $ticket->id) }}" class="btn btn-success w-100">
                        Ver
                      </a>
                    </td>
                  </tr> 
                @endforeach
                </tbody>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.tile-body -->
        </div><!-- /.tile -->
      </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
  </main>
@endsection
