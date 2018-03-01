@extends('layouts.dashboard')
@section('content')  
    <main class="app-content">
      <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Planes Hosting </h1>
          <p>Lista de todos los planes hosting</p>
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
              <a href="{{ url('dashboard/planes-hosting/crear') }}" class="btn btn-primary">Agregar Plan Hosting</a>
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
                    <th>Precio Anual </th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
              @foreach($hostingPlans as $hostingPlan)
                  <tr>
                    <td>{{ $hostingPlan->title }}</td>
                    <td>{{ $hostingPlan->total_price_per_year }} Nuevos Soles</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalEdit-{{$hostingPlan->id}}">
                        Actualizar
                      </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#modalDelete-{{$hostingPlan->id}}">
                        Eliminar
                      </button>
                    </td>
                  </tr>
                  <!-- Modal Edit -->
                    @component('components.modal', [ 
                      'modalId' => 'modalEdit-'. $hostingPlan->id, 
                      'modalTitle' => 'Editar datos del Cliente',
                      'btnCloseClass' => 'btn btn-secondary', 
                      'btnCloseTitle' => 'Cerrar', 
                      'btnSaveClass' => 'btn btn-primary', 
                      'btnSaveTitle' => 'Guardar cambios',
                      'FormId' => 'formEdit-'. $hostingPlan->id,
                    ])

                    <form method="POST" id="formEdit-{{$hostingPlan->id}}" action="{{ route('admin.planes-hosting.update', $hostingPlan->id) }}" >
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label" for="title">Título:</label>
                        <input class="form-control" type="text" id="title" name="title" value="{{ $hostingPlan->title }}" required>
                      </div>
                      <div class="form-group">
                        <label for="description">
                          Agregar una descripción (cantidad de correos, base de datos, etc):
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $hostingPlan->description }}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="total_price">Precio total:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">S/</span>
                          </div>
                          <input type="number" class="form-control" id="total_price" name="total_price" value="{{ $hostingPlan->total_price_per_year }}" required>
                          <div class="input-group-append">
                            <span class="input-group-text">nuevos soles</span>
                          </div>
                        </div>
                      </div>
                    </form>
                    @endcomponent
                  <!-- Modal Delete -->
                    @component('components.modal', [ 
                      'modalId' => 'modalDelete-'.$hostingPlan->id, 
                      'modalTitle' => 'Eliminar',
                      'btnCloseClass' => 'btn btn-danger w-25', 
                      'btnCloseTitle' => 'No', 
                      'btnSaveClass' => 'btn btn-success w-25', 
                      'btnSaveTitle' => 'Sí',
                      'FormId' => 'formDelete-'.$hostingPlan->id,
                    ])

                    <h5>¿Seguro que quiere eliminar a "{{$hostingPlan->title}}"?</h5>
                    <form class="d-none" method="POST" id="formDelete-{{$hostingPlan->id}}" action="{{ route('admin.planes-hosting.destroy', $hostingPlan->id) }}">
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