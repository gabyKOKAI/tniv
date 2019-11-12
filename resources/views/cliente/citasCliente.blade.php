@endphp
    $proxCitas = session('proxCitas');
    $sucSes = session('sucursalSession');
    $numCitas = session('numCitas');
    $numCitasTomPerAg = session('numCitasTomPerAg');
    $numCitasPosibles = session('numCitasPosibles');
    $valoracion = session('valoracion');
@endphp
@if($numCitasPosibles>0)
    <div class="hidden-xs col-sm-12 center">
    </div>
    <div class="col-xs-12 col-sm-3 center">
        Agendadas: <span class="badge">{{$numCitas}}</span>
    </div>
    <div class="col-xs-12 col-sm-2 center">
        @if($valoracion == 1)
            <span class="badge">Valoracion</span>
        @endif
    </div>
    <div class="col-xs-12 col-sm-7 center">
        Agendadas-Tomadas-Perdidas/Posibles: <span class="badge">{{$numCitasTomPerAg}} / {{$numCitasPosibles}}</span> <!-- de <span class="badge">{{$numCitasPosibles}}</span-->
    </div>
@endif
@if(count($proxCitas)>0)
<div class="col-xs-12" style="overflow-x:auto;">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="center">Día </th>
                <th class="hidden-xs center">Hora </th>
                <th class="hidden-xs center">Sucursal </th>
                <th class="center">Estatus </th>
                <th class="hidden-xs center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proxCitas as $cita)
                <?php
                    setlocale(LC_TIME, 'es_ES');
                    $fecha = DateTime::createFromFormat('!m', $cita->hora->dia->mes->mes);
                    $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                ?>
                <tr>
                    <td>
                        <span class="hidden-xs center">
                        {{$cita->hora->dia->diaSemana}},
                        {{$cita->hora->dia->numDia}} de {{$mes2}} del {{$cita->hora->dia->mes->ano}}
                        </span>
                        <span class="hidden-sm hidden-md hidden-lg hidden-xl center">

                        {{$cita->hora->dia->numDia}}/{{$cita->hora->dia->mes->mes}}/{{substr($cita->hora->dia->mes->ano,2,2)}}
                        ({{substr($cita->hora->dia->diaSemana,0,2)}})
                        <br> {{$cita->hora->hora}}
                        <br> {{$cita->hora->dia->mes->sucursal->nombre}}
                        </span>
                    </td>
                    <td class="hidden-xs  center">{{$cita->hora->hora}}</td>
                    <td class="hidden-xs center">{{$cita->hora->dia->mes->sucursal->nombre}}</td>
                    <td>{{$cita->estatus}}
                        <br>
                        <span class="hidden-sm hidden-md hidden-lg hidden-xl center">
                            @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                               @include('cita.iconosAdminCitas')
                            @endif
                        </span>
                    </td>
                    <td class="hidden-xs center">
                        @if(in_array(Auth::user()->rol, ['Cliente']))
                            @if(in_array($cita->estatus, ['Agendada','VAgendada']))
                                @if($cita->diferenciaDias >= $sucSes->horasCancelar )
                                    <a href="/cancelaCita/{{$cita->id}}">Cancelar cita</a>
                                @else
                                    <!--a href="/pierdeCita/{{$cita->id}}">Perder cita</a-->
                                @endif
                            @endif
                        @elseif(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                           @include('cita.iconosAdminCitas')
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
