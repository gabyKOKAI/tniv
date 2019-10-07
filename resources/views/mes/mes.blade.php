@extends('layouts.master')

@push('head')
    <link href="/css/mes.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    <?php setlocale(LC_TIME, 'es_ES'); ?>
    <div class="container">
        <div class="row">
            @if($mes->id <> -1)
                <div class="col-sm-12 form-group required control-label mes_{{$mes->estatus}}" align="center">
                    Mes {{$mes->estatus}}
                </div>
            @endif
            <div class="col-sm-12 align-center">
                <div class="container center">
                    @if($mes->id != -1)
                        <form method='POST' action='/mes/guardar/{{$mes->id}}'>
                    @else
                        <form method='POST' action='/mes/guardar/-1'>
                    @endif

                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row letraNormal">
                            <div class="col-xs-4 form-group control-label" align="center">
                                @if($mes->id == -1)
                                    <div class="input-group">
                                        <label for='ano'>
                                        <a href="{{ URL::to('meses/'.$mes->ano)}}" class="glyphicon glyphicon-calendar"></a> Año</label>
                                        <input type='number' name='ano' id='ano' value='{{$mes->ano}}'  class='form-control' required>
                                    </div>
                                @else
                                    <a href="{{ URL::to('meses/'.$mes->ano)}}" class="glyphicon glyphicon-calendar"></a>
                                    <input type="hidden" name="ano" value="{{$mes->ano}}">
                                    <input type="hidden" name="mes" value="{{$mes->mes}}">
                                    <!--input type='number' name='ano' id='ano' value='{{$mes->ano}}'  class='form-control' disabled-->
                                    <?php
                                        setlocale(LC_TIME, 'es_ES');
                                        $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                        $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                                    ?>
                                    <br>
                                    {{$mes2}} {{$mes->ano}}
                                @endif
                            </div>

                            @if($mes->id == -1)
                                <div class="col-xs-4 form-group control-label" align="center">
                                    <label for='mes'>Mes </label>
                                    <select name="mes"  class="form-control" required>
                                        @foreach (range(1, 12, 1) as $mes1)
                                            <?php
                                                setlocale(LC_TIME, 'es_ES');
                                                $fecha = DateTime::createFromFormat('!m', $mes1);
                                                $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                                            ?>
                                            <option value="{{ $mes1 }}" {{ $mes1 == $mes->mes ? 'selected="selected"' : '' }}>{{ $mes2 }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-xs-4" align="center">
                                <label for='estatus'>Estatus</label>
                                <select name="estatus"  class="form-control" required>
                                    @foreach($estatusForDropdown as $estatus)
                                        <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }} class="letraNormal"> {{ $estatus }} </option>
                                    @endforeach
                                </select>
                            </div>

                            @if($mes->id == -1)
                                <div class="col-xs-12 align-self-center">
                                    <input type='submit' value='Crear Mes' class='btn btn-primary btn-small letraNormal'>
                                </div>
                            @else
                                <div class="col-xs-2 align-self-center">
                                    <br>
                                    <input type='submit' value='Actualiza' class='btn btn-primary btn-small letraNormal'>
                                </div>
                            @endif
                        </div>
                    </form>
                    @include('mes.diasCalendarioMes')
                </div>
			</div>
		</div>
    </div>
@endsection
