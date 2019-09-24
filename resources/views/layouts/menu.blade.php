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
        <?php $sucsSes = session('sucursalesSession'); ?>
        <div class="collapse navbar-collapse center">
            <ul class="nav navbar-nav center">
                <?php $sucSes = session('sucursalSession'); ?>
                @if(Session::has('sucursalSession'))

                    @if(in_array(Auth::user()->rol, ['Cliente']))
                    <li class="dropdown">
                        <?php $numCitas = session('numCitas'); ?>
                        <?php $numCitasTomPerAg = session('numCitasTomPerAg'); ?>
                        <?php $numCitasPosibles = session('numCitasPosibles'); ?>
                        @if($numCitas < 5 and $numCitasTomPerAg<$numCitasPosibles)
                             <li class="dropdown" id="menu">

                                <a href="/agendaCita">Solicitar Cita</a>
                                <!--form method='POST' action='/agendaCita'>
                                {{ csrf_field() }}
                                <input type='submit' value='Solicitar Cita' class='btn btn-cerrar '>
                                </form-->
                            </li>
                        @endif
                        @if($numCitas > 0)
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                Citas   <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                    <li>Agendadas:{{$numCitas}}</li>
                                    <li>Tomadas:{{$numCitasTomPerAg - $numCitas}} de {{$numCitasPosibles}}</li>
                            @foreach($proxCitas as $cita)
                                    @if($cita->diferenciaDias >= $sucSes->horasCancelar)
                                        <li><a href="/cancelaCita/{{$cita->id}}">Cancelar cita del {{$cita->fecha}} </a></li>
                                    @else
                                        <li><a href="/pierdeCita/{{$cita->id}}">Perder cita del {{$cita->fecha}}</a></li>
                                    @endif
                            @endforeach
                            </ul>
                            </li>
                        @endif
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

                @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        Administración {{$sucSes->nombre}}<span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        @if(in_array(Auth::user()->rol, ['Master','Admin']))
                            <li><a href="/usuarios">Usuarios</a></li>
                            <li><a href="/usuario/-1">Registrar Usuario</a></li>
                            <li><a href="/sucursales">Sucursales</a></li>
                        @endif
                        <li><a href="/clientes">Clientes</a></li>
                        <li><a href="/cliente/-1">Registrar Cliente</a></li>

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

                        <li class="dropdown" id="menu">
                            @if(count($sucsSes)>1)
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                        {{$sucSes->nombre}} tiene {{$sucSes->horasCancelar}} hr para cancelar<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                @foreach($sucsSes as $suc)
                                     <li><a href="/sucursalSelected/{{$suc->id}}">{{$suc->nombre}}</a></li>
                                @endforeach
                                </ul>
                            @else
                                @if(Session::has('sucursalSession'))
                                    <a>{{$sucSes->nombre}} tiene {{$sucSes->horasCancelar}} hr para cancelar</a>
                                @endif
                        </li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            Bienvenid@ {{ Auth::user()->name }} <span class="caret"></span>
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
                            <li><a href="/clienteUser/{{Auth::user()->id}}">Perfil</a></li>

                        </ul>
                    </li>

                @endif
                @endguest
            </ul>
        </div>
    </div>
</div>
