@extends('layouts.dashboard')
@section('content')  
    <main class="app-content">
      <div class="app-title">
        <div>
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
              <a href="" class="btn btn-primary">Agregar cliente</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
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
                  <tr>
                    <td>Tiger Nixon asdas asd aasd sad </td>
                    <td>System Architect</td>
                    <td>asdsadsadas@asdasd.com</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalEdit-id">
                        Actualizar
                      </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#modalDelete-id">
                        Eliminar
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  <!-- Modal Edit -->
    @component('components.modal', [ 
      'modalId' => 'modalEdit-'.'id', 
      'modalTitle' => 'Editar datos del Cliente',
      'btnCloseClass' => 'btn btn-secondary', 
      'btnCloseTitle' => 'Cerrar', 
      'btnSaveClass' => 'btn btn-primary', 
      'btnSaveTitle' => 'Guardar cambios',
      'FormId' => 'formEdit-'.'id',
    ])

    <form class="d-none" method="POST" action="" id="formEdit-id">
      {{ method_field('PUT') }}
      {{ csrf_field() }}
      <div class="form-group">
        <label for="first_name-id">Nombre(s):</label>
        <input type="text" name="first_name" class="form-control" id="first_name-id" value="" required>
      </div>

      <div class="form-group">
        <label for="last_name-id">Apellidos:</label>
        <input type="text" name="last_name" class="form-control" id="last_name-id" value="" required>
      </div>

    </form>
    @endcomponent
  <!-- Modal Delete -->
    @component('components.modal', [ 
      'modalId' => 'modalDelete-'.'id', 
      'modalTitle' => 'Eliminar',
      'btnCloseClass' => 'btn btn-danger w-25', 
      'btnCloseTitle' => 'No', 
      'btnSaveClass' => 'btn btn-success w-25', 
      'btnSaveTitle' => 'Sí',
      'FormId' => 'formDelete-'.'id',
    ])

    <p>¿Seguro que quiere eliminar a nombre de cliente?</p>
    <form class="d-none" method="POST" action="" id="formDelete-id">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}       
    </form>
    @endcomponent
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