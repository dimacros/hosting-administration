@extends('layouts.dashboard')
@section('content')  
    <main class="app-content">
      <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Proveedores de dominios </h1>
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
              <a href="{{ url('dashboard/proveedores-de-dominios/crear') }}" class="btn btn-primary">Agregar Proveedor de Dominio</a>
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
                    <th>Nombre de la Empresa</th>
                    <th>Descripción</th>
                    <th>Correo electrónico</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
              @foreach($domainProviders as $domainProvider)
                  <tr>
                    <td>{{ $domainProvider->company_name }}</td>
                    <td>{{ $domainProvider->description }}</td>
                    <td>{{ $domainProvider->email }}</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalEdit-{{$domainProvider->id}}">
                        Actualizar
                      </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#modalDelete-{{$domainProvider->id}}">
                        Eliminar
                      </button>
                    </td>
                  </tr>
                  <!-- Modal Edit -->
                    @component('components.modal', [ 
                      'modalId' => 'modalEdit-'. $domainProvider->id, 
                      'modalTitle' => 'Editar datos del Cliente',
                      'btnCloseClass' => 'btn btn-secondary', 
                      'btnCloseTitle' => 'Cerrar', 
                      'btnSaveClass' => 'btn btn-primary', 
                      'btnSaveTitle' => 'Guardar cambios',
                      'FormId' => 'formEdit-'. $domainProvider->id,
                    ])

                    <form method="POST" id="formEdit-{{$domainProvider->id}}" action="{{ route('admin.proveedores-de-dominios.actualizar', $domainProvider->id) }}" >
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label>Nombre de la empresa:</label>
                        <input type="text" name="company_name" class="form-control" value="{{$domainProvider->company_name}}" required>
                      </div>

                      <div class="form-group">
                        <label>Desripción de la empresa:</label>
                        <input type="text" name="description" class="form-control" value="{{$domainProvider->description}}">
                      </div>

                      <div class="form-group">
                        <label>Correo electrónico:</label>
                        <input type="text" name="email" class="form-control" value="{{$domainProvider->email}}">
                      </div>

                    </form>
                    @endcomponent
                  <!-- Modal Delete -->
                    @component('components.modal', [ 
                      'modalId' => 'modalDelete-'.$domainProvider->id, 
                      'modalTitle' => 'Eliminar',
                      'btnCloseClass' => 'btn btn-danger w-25', 
                      'btnCloseTitle' => 'No', 
                      'btnSaveClass' => 'btn btn-success w-25', 
                      'btnSaveTitle' => 'Sí',
                      'FormId' => 'formDelete-'.$domainProvider->id,
                    ])

                    <h5>¿Seguro que quiere eliminar a "{{$domainProvider->company_name}}"?</h5>
                    <form class="d-none" method="POST" id="formDelete-{{$domainProvider->id}}" action="{{ route('admin.proveedores-de-dominios.actualizar', $domainProvider->id) }}">
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