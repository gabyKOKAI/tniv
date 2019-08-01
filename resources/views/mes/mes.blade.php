@extends('layouts.master')

@push('head')
    <link href="/css/mes.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    <?php setlocale(LC_TIME, 'es_ES'); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
               @if($mes->id != -1)
                    <form method='POST' action='/mes/guardar/{{$mes->id}}'>
               @else
                    <form method='POST' action='/mes/guardar/-1'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="container center">
                            <div class="row">

                                <div class="col-sm-2 form-group control-label" align="center">
                                    <a href="{{ URL::to('meses/'.$mes->ano)}}" class="glyphicon glyphicon-calendar"></a>
                                    <label for='ano'>Año</label>
                                    <div class="input-group">
                                        @if($mes->id == -1)
                                            <input type='number' name='ano' id='ano' value='{{$mes->ano}}'  class='form-control' required>
                                        @else
                                            <input type="hidden" name="ano" value="{{$mes->ano}}">
                                            <input type='number' name='ano' id='ano' value='{{$mes->ano}}'  class='form-control' disabled>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-2 form-group control-label" align="center">
                                    <label for='mes'>Mes </label>
                                        @if($mes->id == -1)
                                            <select name="mes"  class="form-control" required>
                                        @else
                                            <input type="hidden" name="mes" value="{{$mes->mes}}">
                                            <select name="mes"  class="form-control" disabled>
                                        @endif

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

                                <div class="col-sm-2" align="center">
                                    <label for='estatus'>Estatus</label>
                                    <select name="estatus"  class="form-control" required>
                                    @foreach($estatusForDropdown as $estatus)
                                    <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                                    @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2 align-self-center">
                                    <br>
                                        @if($mes->id == -1)
                                            <input type='submit' value='Crear Mes' class='btn btn-primary btn-small'>
                                        @else
                                            <input type='submit' value='Actualiza' class='btn btn-primary btn-small'>
                                        @endif
                                </div>
                            </div>
               </form>

                        <!--/div-->
               @include('mes.diasCalendarioMes')


			</div>
		</div>
    </div>

@endsection
