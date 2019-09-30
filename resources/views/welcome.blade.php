@extends('layouts.master')

@section('title')
    VINT Bienvenido
@endsection

@section('content')
    <?php $proxCitas = session('proxCitas'); ?>
    <?php $sucSes = session('sucursalSession'); ?>
    <h1 class="bienvenido">¡Bienvenido al Sistema Vint!</h1>

    @if(Auth::user())
        @if(count($proxCitas)>0)
            <table class="table table-hover table-striped .table-striped table-responsive">
                <thead>
                    <tr>
                        <th class="center">Día </th>
                        <th class="center">Hora </th>
                        <th class="center">Sucursal </th>
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
                            <td>{{$cita->hora->dia->diaSemana}},{{$cita->hora->dia->numDia}} de {{$mes2}} del {{$cita->hora->dia->mes->ano}}</td>
                            <td>{{$cita->hora->hora}}</td>
                            <td>{{$cita->hora->dia->mes->sucursal->nombre}}</td>
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
        @endif
        @if(in_array(Auth::user()->rol, ['ClienteNuevo','Inactivo']))
        <h4>Su usuario no está activo, solicité en sucursal que lo activen.</h4>
        @endif
    @endif
@endsection
