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
                                @if(count($sucursalesForDropdown)>1)
                                <div class="col-sm-3 form-group required control-label" align="center">
                                    <label for='sucursal'>Sucursal</label>

                                    @if($sucursaleSelected>-1)
                                        <a href="{{ URL::to('sucursal/'.$sucursaleSelected)}}" class="glyphicon glyphicon-edit"></a>
                                    @endif
                                    @if($mes->id == -1)
                                        <select name="sucursal_id"  class="form-control" required>
                                    @else
                                        <input type="hidden" name="sucursal_id" value="{{$sucursaleSelected}}">
                                        <select name="sucursal_id"  class="form-control" disabled>
                                    @endif
                                        @foreach($sucursalesForDropdown as $sucursale1)
                                            <option value="{{ $sucursale1->id }}" {{ $sucursale1->id == $sucursaleSelected ? 'selected="selected"' : '' }}> {{ $sucursale1->nombre }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-sm-2 form-group control-label" align="center">
                                    <label for='ano'>Año</label>
                                    <div class="input-group">
                                        @if($mes->id == -1)
                                            <input type='number' name='ano' id='ano' value='{{$mes->ano}}'  class='form-control' required>
                                        @else
                                            <input type="hidden" name="ano" value="{{$mes->ano}}">
                                            <input type='number' name='ano' id='ganancia_MME' value='{{$mes->ano}}'  class='form-control' disabled>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-2 form-group control-label" align="center">
                                    <label for='mes'>Mes</label>
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
                                            <input type='submit' value='Guarda Mes' class='btn btn-primary btn-small'>
                                        @endif
                                </div>
                            </div>
               </form>
                            @if($mes->id <> -1)
                                <div class="row">

                                <div class="col-sm-1 border" align="center">
                                Do
                                </div>
                                <div class="col-sm-2 border" align="center">
                                Lu
                                </div>
                                <div class="col-sm-2 border" align="center">
                                Ma
                                </div>
                                <div class="col-sm-2 border" align="center">
                                Mi
                                </div>
                                <div class="col-sm-2 border" align="center">
                                Ju
                                </div>
                                <div class="col-sm-2 border" align="center">
                                Vi
                                </div>
                                <div class="col-sm-1 border" align="center">
                                Sa
                                </div>
                                @foreach($diasMes as $dia)
                                    @if($dia->numDia == 1)
                                        @if($dia->diaSemana == "lunes")
                                            <?php $espacioDiv = 1 ?>
                                        @endif
                                        @if($dia->diaSemana == "martes")
                                            <?php $espacioDiv = 3 ?>
                                        @endif
                                        @if($dia->diaSemana == "miercoles")
                                            <?php $espacioDiv = 5 ?>
                                        @endif
                                        @if($dia->diaSemana == "jueves")
                                            <?php $espacioDiv = 7 ?>
                                        @endif
                                        @if($dia->diaSemana == "viernes")
                                            <?php $espacioDiv = 9 ?>
                                        @endif
                                        @if($dia->diaSemana == "sabado")
                                            <?php $espacioDiv = 11 ?>
                                        @endif
                                        <div class="col-sm-{{$espacioDiv}}" align="center">
                                            <br>
                                        </div>
                                    @endif



                                    @if($dia->diaSemana == "sabado" or $dia->diaSemana == "domingo")
                                        <div class="col-sm-1 border" align="center">
                                    @else
                                        <div class="col-sm-2 border" align="center">
                                    @endif
                                        {{$dia->numDia}}<br>
                                        <form method='POST' action='/abrirCerrarDia'>
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
                                @endforeach
                                </div>
                            @endif

                        </div>


			</div>
		</div>
    </div>

@endsection
