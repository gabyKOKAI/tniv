
<div class="navbar navbar-default menuVint" role="navigation" id="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<!--a class="navbar-brand hidden-sm hidden-md hidden-lg hidden-xl" href="#"-->
				<!--img class="imgLogo" src="{{URL::asset('/images/vint.jpg')}}"  title="Vint"/-->
            <!--/a-->
            <span class="navbar-brand">
                @if(Session::has('sucursalSession'))
                    <?php $sucSes = session('sucursalSession'); ?>
                    <h6>{{$sucSes->nombre}}</h6>
                @endif
            </span>
            <!--button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" onclick="openNav()"-->
            <a href="/menuMovil">
            <span class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </span>
            </a>
        </div>
    </div>

    <?php $sucsSes = session('sucursalesSession'); ?>
    <div class="hidden-xs hidden-sm hidden-md hidden-lg hidden-xl collapse navbar-collapse">
        <span class="">
            <ul class="nav navbar-nav ">
                @if(Session::has('sucursalSession'))
                    <?php $sucSes = session('sucursalSession'); ?>
                    @if(in_array(Auth::user()->rol, ['Cliente']))
                        <li class="dropdown">
                            <?php $numCitas = session('numCitas'); ?>
                            <?php $numCitasTomPerAg = session('numCitasTomPerAg'); ?>
                            <?php $numCitasPosibles = session('numCitasPosibles'); ?>
                            <li class="dropdown">
                                <a href="/">Citas</a>
                            </li>
                            @if($numCitas < 5 and $numCitasTomPerAg<$numCitasPosibles)
                                <li class="dropdown" id="menu">
                                    <a href="/agendaCita">Solicitar Cita</a>
                                </li>
                            @endif
                        </li>
                    @endif

                    @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                               Agenda<span class="caret"/>
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

                                <li>
                                    <a href="/meses">Meses</a>
                                </li>
                                <li>
                                    <a href="/anoActual">Este Año ({{$anoFecha}})</a>
                                </li>
                                <li>
                                    <a href="/mesActual">Este Mes ({{$mesFecha1}})</a>
                                </li>
                                <li>
                                    <a href="/diaActual">Hoy ({{$fecha}})</a>
                                </li>

                            </ul>
                        </li>
                    @endif
                @endif

                @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                           Administración {{$sucSes->nombre}}<span class="caret"/>
                        </a>

                        <ul class="dropdown-menu">
                            @if(in_array(Auth::user()->rol, ['Master','Admin']))
                                <li>
                                    <a href="/usuarios">Usuarios</a>
                                </li>
                                <li>
                                    <a href="/usuario/-1">Registrar Usuario</a>
                                </li>
                                <li>
                                    <a href="/sucursales">Sucursales</a>
                                </li>
                            @endif
                            <li>
                                <a href="/clientes">Clientes</a>
                            </li>
                            <li>
                                <a href="/cliente/-1">Registrar Cliente</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li>
                        <a href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                @else
                    @if(Session::has('sucursalesSession'))
                        <li class="dropdown" id="menu">
                            @if(count($sucsSes)>1)
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{$sucSes->nombre}} tiene {{$sucSes->horasCancelar}} hr para cancelar<span class="caret"/>
                                </a>

                                <ul class="dropdown-menu">
                                    @foreach($sucsSes as $suc)
                                        <li>
                                            <a href="/sucursalSelected/{{$suc->id}}">{{$suc->nombre}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @if(Session::has('sucursalSession'))
                                    <a>{{$sucSes->nombre}} tiene {{$sucSes->horasCancelar}} hr para cancelar</a>
                                @endif
                            @endif
                        </li>
                    @endif

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                           {{ Auth::user()->name }} <span class="caret"/>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="/clienteUser/{{Auth::user()->id}}">Perfil</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <li class="dropdown" id="menu">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                class="glyphicon glyphicon-log-out">
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </li>
                @endguest
            </ul>
        </span>
    </div>
</div>

@if(Session::has('abrirMenu') and session('abrirMenu') == 1)
<span class="hidden-sm hidden-md hidden-lg hidden-xl">
    <!--div class="navbar-collapse" role="navigation" id="navigation"-->
        <div id="mySidenav" class="sidenav">
            @if(in_array(Auth::user()->rol, ['Cliente']))
                <?php $numCitas = session('numCitas'); ?>
                <?php $numCitasTomPerAg = session('numCitasTomPerAg'); ?>
                <?php $numCitasPosibles = session('numCitasPosibles'); ?>
                <a class="letraMenu" href="/">Citas</a>
                @if($numCitas < 6 and $numCitasTomPerAg<$numCitasPosibles)
                    <a class="letraMenu" href="/agendaCita">Solicitar Cita</a>
                @endif
            @endif
            @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                <a class="letraMenu" href="/meses">Meses</a>
                <a class="letraMenu" href="/anoActual">Este Año ({{$anoFecha}})</a>
                <a class="letraMenu" href="/mesActual">Este Mes ({{$mesFecha1}})</a>
                <a class="letraMenu" href="/diaActual">Hoy ({{$fecha}})</a>
                <hr>
                @if(in_array(Auth::user()->rol, ['Master','Admin']))
                        <a class="letraMenu" href="/usuarios">Usuarios</a>
                        <a class="letraMenu" href="/usuario/-1">Registrar Usuario</a>
                        <a class="letraMenu" href="/sucursales">Sucursales</a>
                @endif
                <a class="letraMenu" href="/clientes">Clientes</a>
                <a class="letraMenu" href="/cliente/-1">Registrar Cliente</a>
            @endif
            @if(Session::has('sucursalesSession'))
                @if(count($sucsSes)>1)
                    <hr>
                    @foreach($sucsSes as $suc)
                        @if($sucSes == $suc)
                            <strong>
                        @endif
                                <a class="letraMenu" href="/sucursalSelected/{{$suc->id}}">{{$suc->nombre}}</a>
                        @if($sucSes == $suc)
                            </strong>
                        @endif
                    @endforeach
                @endif
            @endif
            <hr>
            <a class="letraMenu" href="/clienteUser/{{Auth::user()->id}}">Perfil {{ Auth::user()->name }}</a>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                class="glyphicon glyphicon-log-out letraMenu">
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    <!--/div-->
</span>
@endif

@if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
    <?php
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('d/m/Y', time());
        $mesFecha = date('m', time());
        $mesFecha = DateTime::createFromFormat('!m', $mesFecha);
        setlocale(LC_TIME, 'es');
        $mesFecha1 = strftime("%B", $mesFecha->getTimestamp());
        $anoFecha = date('Y', time());
    ?>
    <div class="col-sm-12 hidden-xs center">
        Agenda: <a class="btn btn-pagInicio" href="/diaActual">Hoy ({{$fecha}})</a>
        <a class="btn btn-pagInicio" href="/mesActual">{{$mesFecha1}}</a>
        <a class="btn btn-pagInicio" href="/anoActual">{{$anoFecha}}</a>
        <a class="btn btn-pagInicio" href="/meses">Meses<br></a>
    </div>
@endif
