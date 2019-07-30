@extends('layouts.master')

@push('head')
    <link href="/css/dia.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    <?php setlocale(LC_TIME, 'es_ES'); ?>
    <div class="container">
        <div class="row">
            @if($dia->id == -1)
                No tienes acceso a esta información! Favor de contactar al administrador.
            @else
            <div class="col-sm-12 align-center">
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-2 form-group required control-label" align="left">
                                    <form method='POST' action='/abrirCerrarDia/Dia'>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="dia" value="{{$dia->id}}">
                                        <input type="hidden" name="mes" value="{{$mes->id}}">
                                        @if($dia->estatus == 1)
                                                <input type='submit' value='Cerrar Día' class='btn btn-cerrar '>
                                        @else
                                                <input type='submit' value='Abrir Día' class='btn btn-abrir'>
                                        @endif
                                    </form>
                                </div>
                                <div class="col-sm-8 form-group required control-label" align="center">
                                    <div class="input-group">
                                        <?php
                                            setlocale(LC_TIME, 'es_ES');
                                            $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                            $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                                        ?>
                                        <br>
                                        <a href="{{ URL::to('diaVecino/a/'.$dia->id)}}" class="glyphicon glyphicon-chevron-left"></a>
                                        {{$dia->numDia}} de  {{$mes2}} <a href="{{ URL::to('mes/'.$mes->id)}}" class="glyphicon glyphicon-calendar"></a> del {{$mes->ano}}
                                        <!--, {{$sucursal->nombre}}-->
                                        <a href="{{ URL::to('diaVecino/d/'.$dia->id)}}" class="glyphicon glyphicon-chevron-right"></a>


                                    </div>
                                </div>

                            </div>
                            @if($dia->id <> -1 and $dia->estatus == 1)
                                @foreach($horasDia as $hora)

                                @if($hora->estatus == 1)
                                    <div class="row border">
                                @else
                                    <div class="row border grisO">
                                @endif

                                    <div class="col-sm-1" align="center">
                                        {{\Carbon\Carbon::createFromFormat('H:i:s',$hora->hora)->format('g:i a')}}
                                    </div>
                                    <div class="col-sm-1" align="center">

                                        <form method='POST' action='/abrirCerrarHora'>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="hora" value="{{$hora->id}}">
                                            @if($hora->estatus == 1)
                                                    <input type='submit' value='Cerrar' class='btn btn-cerrarH '>
                                            @else
                                                    <input type='submit' value='Abrir' class='btn btn-abrirH'>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-sm-8" align="left">
                                        @if($hora->estatus == 1)
                                            @foreach (range(1, $hora->numCitasMax, 1) as $cita)
                                                <a href="{{ URL::to('cita/'.$hora->id)}}"><input type='text' name='cita' id='cita' value=''  class='' disabled></a>

                                            @endforeach
                                        @else
                                            <br>
                                        @endif

                                    </div>
                                </div>
                                @endforeach

                            @endif

                        </div>


			</div>
			@endif
		</div>
    </div>

@endsection
