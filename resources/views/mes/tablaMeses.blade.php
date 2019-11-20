@if(count($meses)>0)
    <a href="{{ URL::to('mes/-1/')}}" class="btn btn-crear-mes">Crear Mes de otro año</a>
    @php
        $anoAnt = 1900;
        $mesAnt = 0;
    @endphp
    @foreach($meses as $mes)
        @php
            $anoAct = $mes->ano;
            $mesAct = $mes->mes;
            setlocale(LC_TIME, 'es_ES');
            $fecha = DateTime::createFromFormat('!m', $mes->mes);
            $mes1 = strftime("%B", $fecha->getTimestamp());
        @endphp
        @if($anoAnt != $anoAct)
            @if($mesAnt < 12 and $anoAnt != 1900)
                @foreach(range($mesAnt+1,12,1) as $mesVacio)
                    <div class="col-xs-4 mes_Nuevo" align="center">
                        <form method='POST' action='/mes/guardar/-1'>
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="ano" value="{{$mes->ano}}">
                            <input type="hidden" name="mes" value="{{$mesVacio}}">
                            <input type="hidden" name="estatus" value="Inactivo">
                            @php
                                setlocale(LC_TIME, 'es_ES');
                                $fechaVacia = DateTime::createFromFormat('!m', $mesVacio);
                                $mesVacio1 = strftime("%B", $fechaVacia->getTimestamp());
                            @endphp
                            <input type='submit' value='Crear {{$mesVacio1}}' class='btn btn-crear-mes'>
                        </form>
                    </div>
                @endforeach
            @endif
            <div class="col-xs-12">
                <br>
            </div>
            <div class="col-xs-12 SeaGreen border align-self-center">
                {{$mes->ano}}
            </div>
            @php
                $mesAnt = 0;
            @endphp
         @endif

         @if($mesAnt+1 < $mesAct)
            @foreach(range($mesAnt+1,$mesAct-1,1) as $mesVacio)
                <div class="col-xs-4 mes_Nuevo" align="center">
                    <form method='POST' action='/mes/guardar/-1'>
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="ano" value="{{$anoAct}}">
                        <input type="hidden" name="mes" value="{{$mesVacio}}">
                        <input type="hidden" name="estatus" value="Inactivo">
                        <?php
                            setlocale(LC_TIME, 'es_ES');
                            $fechaVacia = DateTime::createFromFormat('!m', $mesVacio);
                            $mesVacio1 = strftime("%B", $fechaVacia->getTimestamp());
                        ?>
                        <input type='submit' value='Crear {{$mesVacio1}}' class='btn btn-crear-mes'>
                    </form>
                </div>
            @endforeach
         @endif

        <div class="col-xs-4 mes_{{$mes->estatus}}" align="center">
            <form method='POST' action='{{ URL::to('mes/' . $mes->id) }}'>
                {{ csrf_field() }}
                <input type='submit' value='{{$mes1}}' class="btn btn-mes">
            </form>
        </div>

        @php
            $anoAnt = $anoAct;
            $mesAnt = $mesAct;
        @endphp
        @if($anoAnt != $anoAct)
        @endif
    @endforeach
    @if($mesAnt < 12 and $anoAnt != 1900)
        @foreach(range($mesAnt+1,12,1) as $mesVacio)
            <div class="col-xs-4 mes_Nuevo" align="center">
                <form method='POST' action='/mes/guardar/-1'>
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="ano" value="{{$mes->ano}}">
                    <input type="hidden" name="mes" value="{{$mesVacio}}">
                    <input type="hidden" name="estatus" value="Inactivo">
                    @php
                        setlocale(LC_TIME, 'es_ES');
                        $fechaVacia = DateTime::createFromFormat('!m', $mesVacio);
                        $mesVacio1 = strftime("%B", $fechaVacia->getTimestamp());
                    @endphp
                    <input type='submit' value='Crear {{$mesVacio1}}' class='btn btn-crear-mes'>
                </form>
            </div>
        @endforeach
    @endif

@else
    <div class="container">
        <div class="row">
            <div class="col-xs-12 align-center">
                <h4 class="center">
                    Sin Meses <a href="{{ URL::to('mes/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                </h4>
            </div>
        </div>
    </div>
@endif
