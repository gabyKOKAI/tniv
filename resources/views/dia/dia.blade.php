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
                            <a href="{{ URL::to('mes/'.$mes->id)}}" class="glyphicon glyphicon-calendar"></a>
                                <div class="col-sm-12 form-group required control-label" align="center">
                                    <div class="input-group">
                                        <?php
                                            setlocale(LC_TIME, 'es_ES');
                                            $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                            $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                                        ?>

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
                                        {{$dia->numDia}} de  {{$mes2}} del {{$mes->ano}}, {{$sucursal->nombre}}
                                    </div>
                                </div>

                            </div>
                            @if($dia->id <> -1)
                                <div class="row">
                                    @foreach($horasDia as $hora)

                                    @endforeach
                                </div>
                            @endif

                        </div>


			</div>
			@endif
		</div>
    </div>

@endsection
