<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Vali Admin</title>
  <!-- ADD MORE TAGS -->
    @stack('head')

  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{ url('/dashboard/user') }}">Vali</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>
        <!--Notification Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-bell-o fa-lg"></i></a>
          <ul class="app-notification dropdown-menu dropdown-menu-right">
            <li class="app-notification__title">You have 4 new notifications.</li>
            <div class="app-notification__content">
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Lisa sent you a mail</p>
                    <p class="app-notification__meta">2 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Mail server not working</p>
                    <p class="app-notification__meta">5 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Transaction complete</p>
                    <p class="app-notification__meta">2 days ago</p>
                  </div></a></li>
              <div class="app-notification__content">
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Lisa sent you a mail</p>
                      <p class="app-notification__meta">2 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Mail server not working</p>
                      <p class="app-notification__meta">5 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Transaction complete</p>
                      <p class="app-notification__meta">2 days ago</p>
                    </div></a></li>
              </div>
            </div>
            <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
          </ul>
        </li>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
              <a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i> 
                Cambiar de<br>Contraseña
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="fa fa-user fa-lg"></i> Mi Perfil </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out fa-lg"></i> Cerrar sesión
              </a>
              <form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="https://cdn1.iconfinder.com/data/icons/avatar-3/512/Manager-128.png" width="56px" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{Auth::user()->full_name}}</p>
          <p class="app-sidebar__user-designation">Trabajador JYP S.A.C</p>
        </div>
      </div>
      @if(Auth::user()->role === 'admin')
      <ul id="role-admin" class="app-menu">
        <li>
          <a class="app-menu__item" href="{{ url('/dashboard/admin') }}">
            <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Dashboard</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="{{ url('dashboard/clientes') }}">
            <i class="app-menu__icon fa fa-address-book"></i>
            <span class="app-menu__label">Clientes</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="{{ url('dashboard/proveedores-de-dominios') }}">
            <i class="app-menu__icon fa fa-users"></i>
            <span class="app-menu__label">Proveedores de dominio</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="{{ url('dashboard/dominios-comprados') }}">
            <i class="app-menu__icon fa fa-credit-card"></i>
            <span class="app-menu__label">Dominios comprados</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="{{ url('/dashboard/planes-hosting') }}">
            <i class="app-menu__icon fa fa-laptop"></i>
            <span class="app-menu__label">Planes Hosting</span>
          </a>
        </li>
        <li>
          <a class="app-menu__item" href="{{ url('/dashboard/contratos-hosting') }}">
            <i class="app-menu__icon fa fa-money"></i>
            <span class="app-menu__label">Clientes Hosting</span>
          </a>
        </li>
        <li>

        </li>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-ticket"></i>
            <span class="app-menu__label">Tickets</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <li>
              <a class="treeview-item" href="{{ url('dashboard/temas-de-ayuda') }}">
                <i class="icon fa fa-info-circle"></i> Temas de Ayuda
              </a>
              <a class="treeview-item" href="{{ url('dashboard/tickets/open') }}">
                <i class="icon fa fa-circle-o"></i> Tickets abierto
              </a>
            </li>
            <li>
              <a class="treeview-item" href="{{ url('dashboard/tickets/closed') }}">
                <i class="icon fa fa-check-circle"></i> Tickets cerrado
              </a>
            </li>
            
          </ul>
        </li>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-cogs"></i>
            <span class="app-menu__label">Configuraciones</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <li>
              <a class="treeview-item" href="{{ route('register') }}">
                <i class="icon fa fa-circle-o"></i> Agregar usuario
              </a>
            </li>
            <li>
              <a class="treeview-item" href="{{ url('dashboard/planes-hosting/user') }}">
                <i class="icon fa fa-circle-o"></i> Lista de Usuarios
              </a>
            </li>
          </ul>
        </li><!-- /.treeview -->
      </ul>
      @elseif(Auth::user()->role === 'customer')
      <ul id="role-customer" class="app-menu">
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-ticket"></i>
            <span class="app-menu__label">Tickets</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <li>
              <a class="treeview-item" href="{{ url('dashboard/ticket-center/nuevo-ticket') }}">
                <i class="icon fa fa-info-circle"></i> Crear un Ticket
              </a>
              <a class="treeview-item" href="{{ url('dashboard/ticket-center/mis-tickets') }}">
                <i class="icon fa fa-circle-o"></i> Mis Tickets
              </a>
            </li>     
          </ul>
        </li> 
      </ul>
      @endif
    </aside>
<!-- <main class="app-content">  -->
    @yield('content')
<!-- </main> -->
  <!-- Essential javascripts for application to work-->
  <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
  <!-- Manipulate the menu with javascript -->
  <script>
  var currentPageWithJavascript = window.location.href;
  var currentPage = '{{ url()->current() }}';
  var menuId = '#role-' + '{{ Auth::user()->role }}';
  $(document).ready(function(){

    $(menuId).find('a[href$="'+currentPage+'"]').addClass('active').attr('id','currentPage');

    if ( $('#currentPage').hasClass('treeview-item') ) {
      $('#currentPage').parents('li.treeview').addClass('is-expanded');
    }

  });
  
  </script>
  <!-- Page specific javascripts-->
  @stack('script')
</body>
</html>