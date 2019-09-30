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
                                    @if($mes->estatus=="Abierto")
                                        <div class="col-sm-12 form-group required control-label SkyBlue" align="center">
                                            El mes esta {{$mes->estatus}}
                                        </div>
                                    @elseif($mes->estatus=="Inactivo")
                                        <div class="col-sm-12 form-group required control-label grisC" align="center">
                                            El mes esta {{$mes->estatus}}
                                        </div>
                                    @elseif($mes->estatus=="Cerrado")
                                        <div class="col-sm-12 form-group required control-label red" align="center">
                                            El mes esta {{$mes->estatus}}
                                        </div>
                                    @endif


                                    <form method='POST' action='/abrirCerrarDia/Dia'>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="dia" value="{{$dia->id}}">
                                        <input type="hidden" name="mes" value="{{$mes->id}}">
                                            @if($mes->estatus=="Abierto" or $mes->estatus=="Inactivo")
                                            @if($dia->estatus == 1)
                                                <div class="col-sm-12 form-group required control-label SkyBlue" align="center">
                                                    El día esta abierto <input type='submit' value='Cerrar Día' class='btn btn-cerrar '>
                                                </div>
                                            @else
                                                <div class="col-sm-12 form-group required control-label red" align="center">
                                                    El día esta cerrado <input type='submit' value='Abrir Día' class='btn btn-abrir'>
                                                </div>
                                            @endif
                                        @else
                                            @if($dia->estatus == 1)
                                                <div class="col-sm-12 form-group required control-label SkyBlue" align="center">
                                                    El día esta abierto <input type='submit' value='Cerrar Día' class='btn btn-cerrar ' disabled>
                                                </div>
                                            @else
                                                <div class="col-sm-12 form-group required control-label red" align="center">
                                                    El día esta cerrado <input type='submit' value='Abrir Día' class='btn btn-abrir' disabled>
                                                </div>
                                            @endif
                                        @endif
                                    </form>
                                <div class="col-sm-12 form-group required control-label" align="center">
                                    <div class="input-group">
                                        <?php
                                            setlocale(LC_TIME, 'es_ES');
                                            $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                            $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                                        ?>
                                        <a href="{{ URL::to('diaVecino/a/'.$dia->id)}}" class="glyphicon glyphicon-chevron-left"></a>
                                        {{$dia->numDia}} de  {{$mes2}} <a href="{{ URL::to('mes/'.$mes->id)}}" class="glyphicon glyphicon-calendar"></a> del {{$mes->ano}}
                                        <!--, {{$sucursal->nombre}}-->
                                        <a href="{{ URL::to('diaVecino/d/'.$dia->id)}}" class="glyphicon glyphicon-chevron-right"></a>


                                    </div>
                                </div>

                            </div>
                            @if($dia->id <> -1)
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
                                            @if($mes->estatus=="Abierto" or $mes->estatus=="Inactivo")
                                                @if($hora->estatus == 1)
                                                        <!-- @ if(count($hora->citasActivas)==0) -->
                                                            <input type='submit' value='Cerrar' class='btn btn-cerrarH '>
                                                        <!-- @ else
                                                            <input type='submit' value='Cerrar' class='btn btn-cerrarH ' disabled>
                                                        @ endif-->
                                                @else
                                                    @if($hora->pasada == 0)
                                                        <input type='submit' value='Abrir' class='btn btn-abrirH'>
                                                    @else
                                                        <input type='submit' value='Abrir' class='btn btn-abrirH' disabled>
                                                    @endif
                                                @endif
                                            @else
                                                @if($hora->estatus == 1)
                                                        <input type='submit' value='Cerrar' class='btn btn-cerrarH' disabled>
                                                @else
                                                        <input type='submit' value='Abrir' class='btn btn-abrirH' disabled>
                                                @endif
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-sm-8" align="left">
                                        <!--@ if($hora->estatus == 1)-->
                                            @foreach ($hora->citas as $cita)

                                                    <!--input type='text' name='cita' id='cita' value='{{$cita->nomCliente}}'  class='' disabled-->
                                                    <div class="col-sm-3 estatusCita_{{$cita->estatus}}" align="left" id="iconoCita">
                                                        @if($cita->estatus == 'Agendada' or $cita->estatus == 'Valoracion')
                                                            @if($cita->pasada == 0 or in_array(Auth::user()->rol, ['Master','Admin']))
                                                                <a href="{{ URL::to('/cancelaCita/'.$cita->id)}}" class="glyphicon glyphicon-remove-sign aIconosCitas"></a>
                                                            @endif
                                                            <a href="{{ URL::to('/tomoCita/'.$cita->id)}}" class="glyphicon glyphicon-ok-sign aIconosCitas"></a>
                                                            <a href="{{ URL::to('/perdioCita/'.$cita->id)}}" class="glyphicon glyphicon-minus-sign aIconosCitas"></a>
                                                        @endif
                                                        @if(in_array($cita->estatus, ['Cancelada']) and $hora->citasActivas<$hora->numCitasMax and ($cita->pasada == 0 or in_array(Auth::user()->rol, ['Master','Admin'])))
                                                            <a href="{{ URL::to('/reagendaCita/'.$cita->id)}}" class="glyphicon glyphicon-repeat aIconosCitas"></a>
                                                        @endif
                                                        @if(in_array($cita->estatus, ['Tomada','VTomada','Perdida']) and in_array(Auth::user()->rol, ['Master','Admin']))
                                                            <a href="{{ URL::to('/reagendaCita/'.$cita->id)}}" class="glyphicon glyphicon-repeat aIconosCitas"></a>
                                                        @endif
                                                        @if($cita->estatus == 'Valoracion' or $cita->estatus == 'VTomada')
                                                            <span class="glyphicon glyphicon glyphicon-list-alt"></span>
                                                        @endif



                                                        {{$cita->nomCliente}}

                                                    </div>


                                            @endforeach
                                        <!--@ else
                                            <br>
                                        @ endif-->
                                    </div>
                                    <div class="col-sm-1" align="center">
                                    <form method='POST' action='/agendarCitaACliente'>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="hora" value="{{$hora->id}}">
                                            <input type="hidden" name="estatus" value="Activo">
                                            @if($mes->estatus=="Abierto" or $mes->estatus=="Inactivo")
                                                @if($hora->estatus == 1 and $hora->citasActivas<$hora->numCitasMax)
                                                    <input type='submit' value='Agendar' class='btn btn-agendar '>
                                                @else
                                                    @if($hora->estatus == 1)
                                                        <input type='submit' value='Cupo Completo' class='btn btn-agendar ' disabled>
                                                    @else
                                                        <input type='submit' value='Agendar' class='btn btn-agendar '>
                                                    @endif
                                                @endif
                                            @elseif($mes->estatus=="Cerrado")
                                                @if($hora->estatus == 1 and $hora->citasActivas<$hora->numCitasMax)
                                                    <input type='submit' value='Agendar' class='btn btn-agendar 'disabled>
                                                @else
                                                    @if($hora->estatus == 1)
                                                        <input type='submit' value='Cupo Completo' class='btn btn-agendar ' disabled>
                                                    @else
                                                        <input type='submit' value='Cerrado' class='btn btn-agendar ' disabled>
                                                    @endif
                                                @endif
                                            @endif
                                        </form>
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
