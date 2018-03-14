@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Tickets {{$title}} </h1>
          <p>Lista de todos los tickets {{$title}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <a class="btn btn-primary" href="#">Nada</a>
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
                    <th scope="col"> Iniciado Por </th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="text-center">
                @foreach($tickets as $ticket)
                  <tr>
                    <td><strong>#{{ $ticket->id }}</strong></td>
                    <td>
                      <strong>{{ $ticket->helpTopic->title }}|</strong> {{ $ticket->subject }}
                    </td>
                    <td>{{ $ticket->user->full_name }}</td>
                    <td><a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-success w-100">Ver</a></td>
                    <td>
                      <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#deleteTicket-{{$ticket->id}}">
                        Eliminar
                      </button>
                    </td>
                  </tr> 
                  <!-- Modal Delete -->
                    @component('components.modal', [ 
                      'modalId' => 'deleteTicket-'.$ticket->id, 
                      'modalTitle' => 'Eliminar',
                      'btnCloseClass' => 'btn btn-danger w-25', 
                      'btnCloseTitle' => 'No', 
                      'btnSaveClass' => 'btn btn-success w-25', 
                      'btnSaveTitle' => 'Sí',
                      'FormId' => 'formToDeleteTicket-'.$ticket->id,
                    ])

                    <h5>¿Seguro que quiere eliminar el Ticket #{{ $ticket->id }}?</h5>
                    <form id="formToDeleteTicket-{{$ticket->id}}" class="d-none" method="POST" action="{{ route('admin.tickets.destroy', $ticket->id) }}">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}       
                    </form>
                    @endcomponent
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
