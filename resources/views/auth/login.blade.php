<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Vali Admin</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Vali</h1>
      </div>
      <div class="login-box">
        <form class="login-form" method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}
          <h3 class="login-head">
            <i class="fa fa-lg fa-fw fa-user"></i>INICIAR SESIÓN
          </h3>
          <div class="form-group">
            <label class="control-label" for="email">USUARIO</label>
            <input type="email" id="email" name="email" placeholder="Su correo electrónico" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>
              @if ( $errors->has('email') )
                <div class="invalid-feedback ml-1">
                  * {{$errors->first('email')}}
                </div>
              @endif
          </div>
          <div class="form-group">
            <label class="control-label" for="password">CONTRASEÑA</label>
            <input type="password" id="password" name="password" placeholder="Su contraseña" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
              @if ( $errors->has('password') )
                <div class="invalid-feedback ml-1">
                  * {{$errors->first('password')}}
                </div>
              @endif
          </div>
          <div class="form-group mb-2">
            <div class="animated-checkbox">
              <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="label-text">Recuérdame</span>
              </label>
            </div>
          </div>
          <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary btn-block">
              <i class="fa fa-sign-in fa-lg fa-fw"></i>ACCEDER
            </button>
            <p class="semibold-text text-right mb-0 mt-3">
              <a href="{{ route('password.request') }}">¿Se te olvido la contraseña?</a>
            </p>
          </div>
        </form>
      </div>
    </section>
  </body>
  <!-- Essential javascripts for application to work-->
  <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
</html>
<script type="text/javascript">
  // Login Page Flipbox control
  $('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
  });
</script>