@extends('layouts.master')

@push('head')
    <link href="/css/dia.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    <?php setlocale(LC_TIME, 'es_ES'); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-2 form-group required control-label" align="center">
                                    <div class="input-group">
                                            {{$sucursal->nombre}}
                                    </div>
                                </div>

                                <div class="col-sm-2 form-group control-label" align="center">
                                    <!--label for='fecha'>Fecha</label-->
                                    <?php
                                        setlocale(LC_TIME, 'es_ES');
                                        $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                        $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                                    ?>
                                    <div class="input-group">
                                        {{$dia->numDia}} de <a href="{{ URL::to('mes/'.$mes->id)}}"> {{$mes2}} del {{$mes->ano}}</a>
                                        </div>
                                </div>

                                <div class="col-sm-2" align="center">
                                    <!--label for='estatus'>Estatus</label-->
                                    <!--select name="estatus"  class="form-control" required>
                                    @foreach($estatusForDropdown as $estatus)
                                    <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                                    @endforeach
                                    </select-->
                                    <form method='POST' action='/abrirCerrarDia/Dia'>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="dia" value="{{$dia->id}}">
                                        <input type="hidden" name="mes" value="{{$mes->id}}">
                                        @if($dia->estatus == 1)
                                                <input type='submit' value='Cerrar' class='btn btn-cerrar '>
                                        @else
                                                <input type='submit' value='Abrir' class='btn btn-abrir'>
                                        @endif
                                    </form>
                                </div>

                            </div>
                            @if($dia->id <> -1)
                                <div class="row">

                                @foreach($horasDia as $hora)
                                    @if($dia->numDia == 1)

                                    @endif

                                @endforeach
                                </div>
                            @endif

                        </div>


			</div>
		</div>
    </div>

@endsection
