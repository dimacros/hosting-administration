@extends('layouts.dashboard')
@section('content')  
    <main class="app-content">
      <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Data Table</h1>
          <p>Table to display analytical data effectively</p>
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
              <a href="{{ url('dashboard/clientes/crear') }}" class="btn btn-primary">Agregar cliente</a>
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
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>Nombre Completo</th>
                    <th>Teléfono</th>
                    <th>Correo electrónico</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
              @foreach($customers as $customer)
                  <tr>
                    <td>{{ $customer->getFullname() }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalEdit-{{$customer->id}}">
                        Actualizar
                      </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#modalDelete-{{$customer->id}}">
                        Eliminar
                      </button>
                    </td>
                  </tr>
                  <!-- Modal Edit -->
                    @component('components.modal', [ 
                      'modalId' => 'modalEdit-'. $customer->id, 
                      'modalTitle' => 'Editar datos del Cliente',
                      'btnCloseClass' => 'btn btn-secondary', 
                      'btnCloseTitle' => 'Cerrar', 
                      'btnSaveClass' => 'btn btn-primary', 
                      'btnSaveTitle' => 'Guardar cambios',
                      'FormId' => 'formEdit-'. $customer->id,
                    ])

                    <form class="d-none" method="POST" id="formEdit-{{$customer->id}}" action="{{ route('admin.clientes.actualizar', $customer->id) }}" >
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label>Nombre(s):</label>
                        <input type="text" name="first_name" class="form-control" value="{{$customer->first_name}}" required>
                      </div>

                      <div class="form-group">
                        <label>Apellidos:</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" value="{{$customer->last_name}}" required>
                      </div>

                      <div class="form-group">
                        <label>Teléfono:</label>
                        <input type="text" name="phone" class="form-control" value="{{$customer->phone}}" required pattern="[0-9-]{5,15}">
                      </div>

                      <div class="form-group">
                        <label for="last_name">Correo electrónico:</label>
                        <input type="text" name="email" class="form-control" value="{{$customer->email}}" required>
                      </div>

                    </form>
                    @endcomponent
                  <!-- Modal Delete -->
                    @component('components.modal', [ 
                      'modalId' => 'modalDelete-'.$customer->id, 
                      'modalTitle' => 'Eliminar',
                      'btnCloseClass' => 'btn btn-danger w-25', 
                      'btnCloseTitle' => 'No', 
                      'btnSaveClass' => 'btn btn-success w-25', 
                      'btnSaveTitle' => 'Sí',
                      'FormId' => 'formDelete-'.$customer->id,
                    ])

                    <h5>¿Seguro que quiere eliminar a "{{$customer->getFullname()}}"?</h5>
                    <form class="d-none" method="POST" id="formDelete-{{$customer->id}}" action="{{ route('admin.clientes.actualizar', $customer->id) }}">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}       
                    </form>
                    @endcomponent
              @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
@endsection
@push('script')
  <!-- Data table plugin-->
  <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#sampleTable').DataTable();
  });
  </script>
@endpush