@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Temas de Ayuda para el Cliente </h1>
          <p>Lista de todos los temas de ayuda</p>
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
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createHelpTopic">
                <i class="fa fa-plus f-16"></i> Nuevo Tema de Ayuda
              </button>
            </div>
          </div>
        </div>
    </div>
    <!-- Modal Create -->
    @component('components.modal', [ 
      'modalId' => 'createHelpTopic', 
      'modalTitle' => 'Crear un Tema de Ayuda',
      'btnCloseClass' => 'btn btn-secondary', 
      'btnCloseTitle' => 'Cerrar', 
      'btnSaveClass' => 'btn btn-primary', 
      'btnSaveTitle' => 'Registrar',
      'FormId' => 'formToCreateHelpTopic',
    ])

    <form id="formToCreateHelpTopic" method="POST" action="{{ route('admin.temas-de-ayuda.store') }}" >
      {{ csrf_field() }}
      <div class="form-group">
        <label>Título para el tema de ayuda:</label>
        <input type="text" name="title" class="form-control" value="{{ old('title')}}" required>
      </div>
    </form>
    @endcomponent
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
                    <th scope="col">#</th>
                    <th scope="col">Tema de Ayuda</th>
                    <th scope="col"> Tickets creados con el Tema </th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="text-center">
                @foreach($helpTopics as $helpTopic)
                  <tr>
                    <td>{{ $helpTopic->id }}</td>
                    <td>{{ $helpTopic->title }}</td>
                    <td>{{ $helpTopic->tickets_count }}</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#editHelpTopic-{{$helpTopic->id}}">
                        Actualizar
                      </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#deleteHelpTopic-{{$helpTopic->id}}">
                        Eliminar
                      </button>
                    </td>
                  </tr> 
                  <!-- Modal Edit -->
                    @component('components.modal', [ 
                      'modalId' => 'editHelpTopic-'. $helpTopic->id, 
                      'modalTitle' => 'Editar datos del Cliente',
                      'btnCloseClass' => 'btn btn-secondary', 
                      'btnCloseTitle' => 'Cerrar', 
                      'btnSaveClass' => 'btn btn-primary', 
                      'btnSaveTitle' => 'Guardar cambios',
                      'FormId' => 'formToEditHelpTopic-'. $helpTopic->id,
                    ])

                    <form id="formToEditHelpTopic-{{$helpTopic->id}}" method="POST" action="{{ route('admin.temas-de-ayuda.update', $helpTopic->id) }}" >
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label>Título para el tema de ayuda:</label>
                        <input type="text" name="title" class="form-control" value="{{$helpTopic->title}}" required>
                      </div>
                    </form>
                    @endcomponent
                  <!-- Modal Delete -->
                    @component('components.modal', [ 
                      'modalId' => 'deleteHelpTopic-'.$helpTopic->id, 
                      'modalTitle' => 'Eliminar',
                      'btnCloseClass' => 'btn btn-danger w-25', 
                      'btnCloseTitle' => 'No', 
                      'btnSaveClass' => 'btn btn-success w-25', 
                      'btnSaveTitle' => 'Sí',
                      'FormId' => 'formToDeleteHelpTopic-'.$helpTopic->id,
                    ])

                    <h5>¿Seguro que quiere eliminar este tema de ayuda?</h5>
                    <form id="formToDeleteHelpTopic-{{$helpTopic->id}}" class="d-none" method="POST" action="{{ route('admin.temas-de-ayuda.destroy', $helpTopic->id) }}">
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
