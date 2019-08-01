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
                @if(Session::has('sucursalSession'))
                    <?php $sucSes = session('sucursalSession'); ?>

                    @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                        <li class="dropdown" id="menu">
                            <a href="/clientes">Clientes</a>
                        </li>
                    @endif

                    @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                Agenda<span class="caret"></span>
                        </a>
                         <ul class="dropdown-menu">
                                 <?php
                                    date_default_timezone_set('America/Mexico_City');
                                    $fecha = date('d/m/Y', time());
                                    $mesFecha = date('m', time());
                                    $mesFecha = DateTime::createFromFormat('!m', $mesFecha);
                                    setlocale(LC_TIME, 'es');
                                    $mesFecha1 = strftime("%B", $mesFecha->getTimestamp());
                                    $anoFecha = date('Y', time());
                                ?>

                                <li><a href="/meses">Meses</a></li>
                                <li><a href="/anoActual">Este Año ({{$anoFecha}})</a></li>
                                <li><a href="/mesActual">Este Mes ({{$mesFecha1}})</a></li>
                                <li><a href="/diaActual">Hoy ({{$fecha}})</a></li>

                         </ul>
                    </li>
                    @endif

                @endif

                @if(in_array(Auth::user()->rol, ['Master','Admin']))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        Administración<span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="/usuarios">Usuarios</a></li>
                        <li><a href="/usuario/-1">Registrar Usuario</a></li>
                        <li><a href="/sucursales">Sucursales</a></li>
                    </ul>
                </li>
                @endif
                @if(in_array(Auth::user()->rol, ['Master','AdminSucursal']))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        Administración Sucursal<span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="/usuarios">Usuarios</a></li>
                        <li><a href="/usuario/-1">Registrar Usuario</a></li>
                        <li><a href="/sucursales">Sucursales</a></li>
                    </ul>
                </li>
                @endif
          </ul>
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    @if(Session::has('sucursalesSession'))
                        @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                        <li class="dropdown" id="menu">
                            <?php $sucsSes = session('sucursalesSession'); ?>
                            @if(count($sucsSes)>1)
                                <?php $sucSes = session('sucursalSession'); ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                        {{$sucSes->nombre}} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                @foreach($sucsSes as $suc)
                                     <li><a href="/sucursalSelected/{{$suc->id}}">{{$suc->nombre}}</a></li>
                                @endforeach
                                </ul>
                            @else
                                @if(Session::has('sucursalSession'))
                                    <?php $sucSes = session('sucursalSession'); ?>
                                    <a>{{$sucSes->nombre}}</a>
                                @endif
                            @endif
                        </li>
                    @endif
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

                @endif
                @endguest
            </ul>
        </div>
    </div>
</div>
