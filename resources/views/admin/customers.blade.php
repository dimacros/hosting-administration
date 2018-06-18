@extends('layouts.dashboard', ['defaultModelTable' => true])
@section('content')  
    <main class="app-content">
      <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Clientes</h1>
          <p>Lista de todos los clientes</p>
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
              <a href="{{ url('dashboard/clientes/crear') }}" class="btn btn-primary">
                <i class="fa fa-plus f-16"></i> Agregar cliente
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
              <table class="table table-hover table-bordered" id="defaultModelTable">
                <thead class="thead-dark">
                  <tr>
                    <th>Empresa o Nombre completo</th>
                    <th>Teléfono</th>
                    <th>Correo electrónico</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
              @foreach($customers as $customer)
                  <tr>
                    <td>{{ $customer->full_name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                      <button type="button" class="btn btn-primary w-100 btnEdit" data-toggle="modal" data-target="#modalEdit-{{$customer->id}}">
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

                    <form method="POST" id="formEdit-{{$customer->id}}" action="{{ route('admin.clientes.update', $customer->id) }}" >
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Nombre(s):</label>
                          <input type="text" name="first_name" class="form-control" value="{{$customer->first_name}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Apellidos:</label>
                          <input type="text" name="last_name" class="form-control" value="{{$customer->last_name}}" required>
                        </div>
                      </div><!--/.form-row-->

                      <div class="form-group">
                        <label>Nombre de Empresa (opcional):</label>
                        <input type="text" name="company_name" class="form-control" value="{{$customer->company_name}}">
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Correo electrónico:</label>
                          <input type="text" name="email" class="form-control" value="{{$customer->email}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Teléfono:</label>
                          <input type="text" name="phone" class="form-control" value="{{$customer->phone}}" required>
                        </div>
                      </div><!--/.form-row-->
                      <div class="bg-light border-top px-2 py-3">
                        @if(is_null($customer->user_id)) 
                        <h5>Asocie el cliente con un usuario activo</h5>
                        <div class="form-group">
                          <select class="custom-select users" name="user_id" style="width: 90%;">
                            <option value="">Busque al usuario por su nombre...</option>
                            @foreach($users as $user)
                              <option value="{{ $user->id }}">{{ $customer->user->full_name }}</option>  
                            @endforeach
                          </select>
                        </div>
                        @else 
                        <h5>Usuario asociado: 
                          <span style="background-color: chartreuse; font-weight: 600; padding: 6px;">
                            {{$customer->user->full_name}}
                          </span>
                        </h5>
                        @endif
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

                    <h5>¿Seguro que quiere eliminar a "{{$customer->full_name}}"?</h5>
                    <form class="d-none" method="POST" id="formDelete-{{$customer->id}}" action="{{ route('admin.clientes.destroy', $customer->id) }}">    
                      {{ csrf_field() }}   
                      {{ method_field('DELETE') }}    
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
<!-- Select plugin-->
<script src="{{ asset('js/plugins/selectize.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function($) {

  $('.users').change(function(){
    var user_id = this.value;
    var select = $(this);
    $.ajax({
      url: "{{ url('dashboard/usuarios') }}/" + user_id,
      type: "GET",
      dataType: "json",
      beforSend:function(){
        
      },
      success: function(data) {
       console.log(data);
      },
      complete: function() {
              
      }
    });   
  })
});
</script>
@endpush