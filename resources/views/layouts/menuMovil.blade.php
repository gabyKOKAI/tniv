@if(Session::has('abrirMenu'))
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

    Session::forget('abrirMenu');
?>
<span class="hidden-sm hidden-md hidden-lg hidden-xl">
    <!--div class="navbar-collapse" role="navigation" id="navigation"-->
        <div id="mySidenav" class="sidenav">
            @if(in_array(Auth::user()->rol, ['Cliente']))
                <a class="letraMenu" href="/"><span class="glyphicon glyphicon-list-alt"> </span> Citas</a>
                @if($numCitas < 6 and $numCitasTomPerAg<$numCitasPosibles)

                    <a class="letraMenu" href="/agendaCita"><span class="glyphicon glyphicon-edit"> </span> Solicitar Cita</a>
                @endif
            @endif
            @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                <a class="letraMenu" href="/meses">Meses</a>
                <a class="letraMenu" href="/anoActual">Este Año ({{$anoFecha}})</a>
                <a class="letraMenu" href="/mesActual">Este Mes ({{$mesFecha1}})</a>
                <a class="letraMenu" href="/diaActual">Hoy ({{$fecha}})</a>
                <hr class="">
                @if(in_array(Auth::user()->rol, ['Master']))
                        <a class="letraMenu" href="/usuarios">Usuarios</a>
                        <a class="letraMenu" href="/usuario/-1">Registrar Usuario</a>
                @endif
                @if(in_array(Auth::user()->rol, ['Master','Admin']))
                        <a class="letraMenu" href="/sucursales">Sucursales</a>
                @endif
                <a class="letraMenu" href="/clientes">Clientes</a>
                @if(in_array(Auth::user()->rol, ['Master']))
                    <a class="letraMenu" href="/cliente/-1">Registrar Cliente</a>
                @endif
            @endif
            @if(Session::has('sucursalesSession'))
                @if(count($sucsSes)>1)
                    <hr class="">
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
            <hr class="">
            <a class="letraMenu" href="/clienteUser/{{Auth::user()->id}}"> <span class="glyphicon glyphicon-user"> </span> {{Auth::user()->name }}</a>
            <br>
            <br>
            <br>
        </div>
    <!--/div-->
</span>
@endif
