<?php
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('d/m/Y', time());
    $mesFecha = date('m', time());
    $mesFecha = DateTime::createFromFormat('!m', $mesFecha);
    setlocale(LC_TIME, 'es');
    $mesFecha1 = strftime("%B", $mesFecha->getTimestamp());
    $anoFecha = date('Y', time());

    $sucsSes = session('sucursalesSession');
    $sucSes = session('sucursalSession');

    $numCitas = session('numCitas');
    $numCitasTomPerAg = session('numCitasTomPerAg');
    $numCitasPosibles = session('numCitasPosibles');
?>
<div class="navbar navbar-default menuVint" role="navigation" id="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<!--a class="navbar-brand hidden-sm hidden-md hidden-lg hidden-xl" href="#"-->
				<!--img class="imgLogo" src="{{URL::asset('/images/vint.jpg')}}"  title="Vint"/-->
            <!--/a-->
            <span class="navbar-brand hidden-sm hidden-md hidden-lg hidden-xl">
                @if(Session::has('sucursalSession'))
                    <h6>{{$sucSes->nombre}}</h6>
                @endif
            </span>

            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                 <span class="navbar-toggle glyphicon glyphicon-log-out grayLG">
                 </span>
            </a>
            <a href="/" >
                <span class="navbar-toggle glyphicon glyphicon-home grayLG">
                 </span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            @if(!Session::has('abrirMenu'))
                <a href="/menuMovil">
                    <span class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </a>

            @endif

        </div>
    </div>

    <div class="hidden-xs hidden-sm hidden-md hidden-lg hidden-xl collapse navbar-collapse">
        <span class="">
            <ul class="nav navbar-nav ">
                @if(Session::has('sucursalSession'))
                    @if(in_array(Auth::user()->rol, ['Cliente']))
                        <li class="dropdown">
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
                           Administración <span class="caret"/>
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                           Citas <span class="caret"/>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/citasHoy">Hoy</a>
                            </li>
                            <li>
                                <a href="/citasMes">Mes</a>
                            </li>
                            <li>
                                <a href="/citasCliente">Cliente</a>
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
                                    <!--{{$sucSes->nombre}} tiene {{$sucSes->horasCancelar}} hr para cancelar-->
                                    Sucursales<span class="caret"/>
                                </a>

                                <ul class="dropdown-menu">
                                    @foreach($sucsSes as $suc)
                                        <li>
                                            <a href="/sucursalSelected/{{$suc->id}}">
                                                @if($sucSes == $suc)
                                                    <strong>
                                                         {{$suc->nombre}}
                                                    </strong>
                                                @else
                                                    {{$suc->nombre}}
                                                @endif
                                                </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @if(Session::has('sucursalSession'))
                                    <!--a>{{$sucSes->nombre}}</a-->
                                    <!--a>{{$sucSes->nombre}} tiene {{$sucSes->horasCancelar}} hr para cancelar</a-->
                                @endif
                            @endif
                        </li>
                    @endif

                    <li class="dropdown">
                        <a href="/clienteUser/{{Auth::user()->id}}"> <span class="glyphicon glyphicon-user"></span>{{Auth::user()->name }}</a>
                    </li>
                    <li class="dropdown">
                        <a href="/">
                        <span class="glyphicon glyphicon-home"></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <span class="glyphicon glyphicon-log-out"></span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endguest
            </ul>
        </span>
    </div>
</div>

@if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
    <div class="col-sm-12 hidden-xs center">
        Agenda: <a class="btn btn-pagInicio" href="/diaActual">Hoy ({{$fecha}})</a>
        <a class="btn btn-pagInicio" href="/mesActual">{{$mesFecha1}}</a>
        <a class="btn btn-pagInicio" href="/anoActual">{{$anoFecha}}</a>
        <a class="btn btn-pagInicio" href="/meses">Meses<br></a>
    </div>
@endif
