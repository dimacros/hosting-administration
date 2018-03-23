<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
          @if (session('status'))
            <strong>{{ session('status') }}</strong>
          @endif
           <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="tile-body">
              <div class="form-group">
                <label for="first_name">Nombre(s):</label>
                <input class="form-control" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
              </div>
              <div class="form-group">
                <label for="last_name">Apellidos:</label>
                <input class="form-control" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
              </div>
              <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="password">Contraseña:</label>
                  <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="password_confirmation">Confirmar Contraseña:</label>
                  <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>
              </div>
            </div>
            <button class="btn btn-primary btn-lg" type="submit">Registrar</button>
          </form> 
</body>
</html>



