@extends('layouts.dashboard')
@section('content')  
    <main class="app-content">
      <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Usuarios</h1>
          <p>Lista de todos los usuarios</p>
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
              <button class="btn btn-primary" data-toggle="modal" data-target="#modalUserCreate">
                <i class="fa fa-plus f-16"></i> Crear nuevo usuario
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal User Create -->
      @component('components.modal', [ 
        'modalId' => 'modalUserCreate', 
        'modalTitle' => 'Crear nuevo usuario',
        'btnCloseClass' => 'btn btn-secondary', 
        'btnCloseTitle' => 'Cerrar', 
        'btnSaveClass' => 'btn btn-primary', 
        'btnSaveTitle' => 'Crear y enviar correo electrónico',
        'FormId' => 'formUserCreate'
      ])

      <form method="POST" id="formUserCreate" action="{{ route('admin.usuarios.store') }}">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="first_name">Nombre(s):</label>
          <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="last_name">Apellidos:</label>
          <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="email">Correo electrónico:</label>
          <input type="text" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="role">Seleccionar un rol</label>
          <select name="role" id="role" class="custom-select" required>
            <option value="admin">Administrador</option>
            <option value="employee">Trabajador</option>
            <option value="customer">Cliente</option>
          </select>
        </div>
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="active" value="1">
            <label class="custom-control-label" for="active">Activar usuario</label>
          </div>
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
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">Empresa o Nombre completo</th>
                      <th scope="col">Rol</th>
                      <th scope="col">Correo electrónico</th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                @foreach($users as $user)
                    <tr>
                      <td>{{ $user->full_name }}</td>
                      <td>{{ $user->role }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modalEdit-{{$user->id}}">
                          Actualizar
                        </button>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#modalDelete-{{$user->id}}">
                          Eliminar
                        </button>
                      </td>
                    </tr>
                    <!-- Modal Edit -->
                      @component('components.modal', [ 
                        'modalId' => 'modalEdit-'. $user->id, 
                        'modalTitle' => 'Editar datos del usuario',
                        'btnCloseClass' => 'btn btn-secondary', 
                        'btnCloseTitle' => 'Cerrar', 
                        'btnSaveClass' => 'btn btn-primary', 
                        'btnSaveTitle' => 'Guardar cambios',
                        'FormId' => 'formEdit-'. $user->id,
                      ])

                      <form method="POST" id="formEdit-{{$user->id}}" action="{{ route('admin.usuarios.update', $user->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                          <label>Nombre(s):</label>
                          <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" required>
                        </div>

                        <div class="form-group">
                          <label>Apellidos:</label>
                          <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}" required>
                        </div>

                        <div class="form-group">
                          <label>Correo electrónico:</label>
                          <input type="text" name="email" class="form-control" value="{{$user->email}}" required>
                        </div>
                        
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="active-{{$user->id}}" {{($user->active)?'checked':''}} value="1">
                            <label class="custom-control-label" for="active-{{$user->id}}">
                              Usuario activado
                            </label>
                          </div>
                        </div>
                      </form>
                      @endcomponent
                    <!-- Modal Delete -->
                      @component('components.modal', [ 
                        'modalId' => 'modalDelete-'.$user->id, 
                        'modalTitle' => 'Eliminar',
                        'btnCloseClass' => 'btn btn-danger w-25', 
                        'btnCloseTitle' => 'No', 
                        'btnSaveClass' => 'btn btn-success w-25', 
                        'btnSaveTitle' => 'Sí',
                        'FormId' => 'formDelete-'.$user->id,
                      ])

                      <h5>¿Seguro que quiere eliminar a "{{$user->full_name}}"?</h5>
                      <form class="d-none" method="POST" id="formDelete-{{$user->id}}" action="{{ route('admin.usuarios.destroy', $user->id) }}">    
                        {{ csrf_field() }}   
                        {{ method_field('DELETE') }}    
                      </form>
                      @endcomponent
                @endforeach
                  </tbody>
                </table>
              </div><!--/.table-responsive -->
            </div>
          </div>
        </div>
      </div>
    </main>
@endsection