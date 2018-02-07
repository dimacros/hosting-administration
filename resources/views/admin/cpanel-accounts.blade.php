@extends('layouts.dashboard')
@section('content')  
    <main class="app-content">
      <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Cuentas de Cpanel </h1>
          <p>Lista de todos los proveedores de dominios.</p>
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
              <a href="{{ url('dashboard/proveedores-de-dominios/crear') }}" class="btn btn-primary">Agregar Cuenta de Cpanel </a>
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
                    <th>Nombre del Dominio</th>
                    <th>Usuario Cpanel </th>
                    <th>Contraseña Cpanel </th>
                    <th>IP Pública </th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
              @foreach($cpanelAccounts as $cpanelAccount)
                  <tr>
                    <td>{{ $cpanelAccount->domain_name }}</td>
                    <td>{{ $cpanelAccount->user }}</td>
                    <td>{{ $cpanelAccount->password }}</td>
                    <td>{{ $cpanelAccount->public_ip }}</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalEdit-{{$cpanelAccount->id}}">
                        Actualizar
                      </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#modalDelete-{{$cpanelAccount->id}}">
                        Eliminar
                      </button>
                    </td>
                  </tr>
                  <!-- Modal Edit -->
                    @component('components.modal', [ 
                      'modalId' => 'modalEdit-'. $cpanelAccount->id, 
                      'modalTitle' => 'Editar datos del Cliente',
                      'btnCloseClass' => 'btn btn-secondary', 
                      'btnCloseTitle' => 'Cerrar', 
                      'btnSaveClass' => 'btn btn-primary', 
                      'btnSaveTitle' => 'Guardar cambios',
                      'FormId' => 'formEdit-'. $cpanelAccount->id,
                    ])

                    <form class="d-none" method="POST" id="formEdit-{{$cpanelAccount->id}}" action="{{ route('admin.proveedores-de-dominios.actualizar', $cpanelAccount->id) }}" >
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label>Nombre del dominio:</label>
                        <input type="text" name="domain_name" class="form-control" value="{{$cpanelAccount->domain_name}}" required>
                      </div>

                      <div class="form-group">
                        <label>Usuario de Cpanel:</label>
                        <input type="text" name="user" class="form-control" value="{{$cpanelAccount->user}}">
                      </div>

                      <div class="form-group">
                        <label>Constraseña de Cpanel:</label>
                        <input type="text" name="password" class="form-control" value="{{$cpanelAccount->password}}">
                      </div>
          
                      <div class="form-group">
                        <label>IP Pública:</label>
                        <input type="text" name="public_ip" class="form-control" value="{{$cpanelAccount->public_ip}}">
                      </div>
                    </form>
                    @endcomponent
                  <!-- Modal Delete -->
                    @component('components.modal', [ 
                      'modalId' => 'modalDelete-'.$cpanelAccount->id, 
                      'modalTitle' => 'Eliminar',
                      'btnCloseClass' => 'btn btn-danger w-25', 
                      'btnCloseTitle' => 'No', 
                      'btnSaveClass' => 'btn btn-success w-25', 
                      'btnSaveTitle' => 'Sí',
                      'FormId' => 'formDelete-'.$cpanelAccount->id,
                    ])

                    <h5>¿Seguro que quiere eliminar a "{{$cpanelAccount->domain_name}}"?</h5>
                    <form class="d-none" method="POST" id="formDelete-{{$cpanelAccount->id}}" action="{{ route('admin.proveedores-de-dominios.actualizar', $cpanelAccount->id) }}">
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