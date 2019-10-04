@extends('layouts.master')

@section('title')
    VINT Bienvenido
@endsection

@section('content')
    <?php $proxCitas = session('proxCitas'); ?>
    <?php $sucSes = session('sucursalSession'); ?>
    <h1 class="bienvenido">¡Bienvenido al Sistema Vint!</h1>

    @if(Auth::user())
        @if(in_array(Auth::user()->rol, ['Cliente']))
            <?php $numCitas = session('numCitas'); ?>
            <?php $numCitasTomPerAg = session('numCitasTomPerAg'); ?>
            <?php $numCitasPosibles = session('numCitasPosibles'); ?>
            <div class="col-sm-3 center">
            </div>
            <div class="col-xs-12 col-sm-3 center">
                    Agendadas: <span class="badge">{{$numCitas}}</span>
            </div>
            <div class="col-xs-12 col-sm-3 center">
                    Tomadas: <span class="badge">{{$numCitasTomPerAg - $numCitas}}</span> de <span class="badge">{{$numCitasPosibles}}</span>
            </div>
            <div class="col-sm-3 center">
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
                        <th class="center">Acciones</th>
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
                            <td>{{$cita->estatus}}</td>
                            <td>
                                @if(in_array($cita->estatus, ['Agendada','VAgendada']))
                                    @if($cita->diferenciaDias >= $sucSes->horasCancelar )
                                        <a href="/cancelaCita/{{$cita->id}}">Cancelar cita</a>
                                    @else
                                        <!--a href="/pierdeCita/{{$cita->id}}">Perder cita</a-->
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if(in_array(Auth::user()->rol, ['ClienteNuevo','Inactivo']))
        <h4>Su usuario no está activo, solicité en sucursal que lo activen.</h4>
        @endif
    @endif
@endsection
