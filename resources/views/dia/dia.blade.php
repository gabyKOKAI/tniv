@extends('layouts.master')

@push('head')
    <!--link href="/css/dia.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    <?php setlocale(LC_TIME, 'es_ES'); ?>
    <div class="container">
        <div class="row">
            @if($dia->id == -1)
                No tienes acceso a esta información! Favor de contactar al administrador.
            @else
            <div class="col-xs-12 align-center">
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="container center">
                            <div class="row">

                                <div class="col-xs-6 letraNormal mes_{{$mes->estatus}} " align="center">
                                   Mes {{$mes->estatus}}<a href="{{ URL::to('mes/'.$mes->id)}}" class="btn btn-mesDia glyphicon glyphicon-calendar"></a>
                                </div>
                                <div class="col-xs-6 dia_estatus letraNormal dia_{{$dia->estatus}}" align="center">
                                    <form method='POST' action='/abrirCerrarDia/Dia'>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="dia" value="{{$dia->id}}">
                                        <input type="hidden" name="mes" value="{{$mes->id}}">

                                        @if($mes->estatus=="Abierto" or $mes->estatus=="Inactivo")
                                                @if($dia->estatus == 1)
                                                    Día Abierto<button type="submit" value="Submit" class='glyphicon glyphicon-remove-sign btn btn-cerrar'> </button>
                                                    <!--input type='submit' value='Cerrar Día' class='btn btn-cerrar '-->
                                                @else
                                                    Día Cerrado<button type="submit" value="Submit" class='glyphicon glyphicon-ok-circle btn btn-abrir'> </button>
                                                    <!--input type='submit' value='' class='glyphicon glyphicon-ok-circle btn btn-abrir'-->
                                                @endif
                                        @else
                                            @if($dia->estatus == 1)
                                                    Día Abierto<button type="submit" value="Submit" class='glyphicon glyphicon-remove-sign btn btn-cerrar' disabled> </button>
                                                    <!--input type='submit' value='Cerrar Día' class='btn btn-cerrar ' disabled-->
                                            @else
                                                    Día Cerrado
                                                    <button type="submit" value="Submit" class='glyphicon glyphicon-ok-circle btn btn-abrir' disabled> </button>
                                                    <input type='submit' value='Abrir Día' class='btn btn-abrir' disabled>
                                            @endif
                                        @endif
                                    </form>
                                </div>
                                <div class="col-xs-12 form-group required control-label" align="center">
                                    <div class="input-group letraNormal">
                                        <?php
                                            setlocale(LC_TIME, 'es_ES');
                                            $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                            $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                                        ?>
                                        <a href="{{ URL::to('diaVecino/a/'.$dia->id)}}" class="glyphicon glyphicon-chevron-left"></a>
                                        {{$dia->numDia}} de  {{$mes2}} del {{$mes->ano}}
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

                                    <div class="col-xs-12 col-sm-2 letraNormal" align="center">
                                        {{\Carbon\Carbon::createFromFormat('H:i:s',$hora->hora)->format('g:i a')}}
                                    </div>
                                    <div class="col-xs-2 col-sm-2" align="center">

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
                                    <div class="col-xs-8 col-sm-6" align="left">
                                        <!--@ if($hora->estatus == 1)-->
                                            @foreach ($hora->citas as $cita)

                                                    <!--input type='text' name='cita' id='cita' value='{{$cita->nomCliente}}'  class='' disabled-->
                                                    <div class="col-xs-12 col-sm-12 estatusCita_{{$cita->estatus}}" align="left" id="iconoCita">
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
                                    <div class="col-xs-1 col-sm-1" align="center">
                                    <form method='POST' action='/agendarCitaACliente'>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="hora" value="{{$hora->id}}">
                                            <input type="hidden" name="estatus" value="Activo">
                                            @if($mes->estatus=="Abierto" or $mes->estatus=="Inactivo")
                                                @if($hora->estatus == 1 and $hora->citasActivas<$hora->numCitasMax)
                                                    <input type='submit' value='Agendar' class='btn btn-agendar '>
                                                @else
                                                    @if($hora->citasActivas<$hora->numCitasMax)
                                                        <input type='submit' value='Agendar' class='btn btn-agendar '>
                                                    @else
                                                        <!--input type='submit' value='Cupo Completo' class='btn btn-agendar ' disabled-->
                                                        <input type='submit' value='Completo*' class='btn btn-agendar '>
                                                    @endif
                                                @endif
                                            @elseif($mes->estatus=="Cerrado")
                                                @if($hora->estatus == 1 and $hora->citasActivas<$hora->numCitasMax)
                                                    <input type='submit' value='Agendar' class='btn btn-agendar 'disabled>
                                                @else
                                                    @if($hora->citasActivas<$hora->numCitasMax)
                                                        <input type='submit' value='Cerrado' class='btn btn-agendar ' disabled>
                                                    @else
                                                        <input type='submit' value='Completo' class='btn btn-agendar ' disabled>
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
