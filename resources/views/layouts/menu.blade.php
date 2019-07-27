<div class="col-sm-12 align-self-center">
   <div class="navbar navbar-default center" role="navigation" id="navigation">
        <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse center">
            <ul class="nav navbar-nav center">
                <!--li class="dropdown" id="menu">
                    <a href="/sucursales">Sucursales</a>
                </li-->
                <li class="dropdown" id="menu">
                    <a href="/clientes">Clientes</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            Agenda<span class="caret"></span>
                    </a>
                     <ul class="dropdown-menu">
                            <li><a href="/meses">Meses</a></li>
                            <li><a href="/mesActual/-1">MesActual</a></li>
                     </ul>
                </li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            Administración<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="/usuarios">Usuarios</a></li>
                            <li><a href="/registraUsuario">Registrar Usuario</a></li>
                            <li><a href="/sucursales">Sucursales</a></li>
                        </ul>
                    </li>
          </ul>
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Salir
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</div>
