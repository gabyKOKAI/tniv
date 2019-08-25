@if($mesSelect->id <> -1 and $mesSelect->estatus == "Abierto")
    <div class="row">
        <div class="col-sm-12" align="center">
            <br>
        </div>
        <div class="col-sm-12 azul border align-self-center">
            Dias Disponibles para el mes de {{$mesSelectedNombre}} del {{$mesSelect->ano}}:
        </div>
    </div>
    <div class="row">
        <span class="hidden-xs">
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
        </span>
        @foreach($diasMes as $dia)
            @if($dia->numDia == 1)
                <?php $espacioDiv = 0 ?>
                @if($dia->diaSemana == "lunes")
                    <?php $espacioDiv = 1 ?>
                @endif
                @if($dia->diaSemana == "martes")
                    <?php $espacioDiv = 3 ?>
                @endif
                @if($dia->diaSemana == "miércoles")
                    <?php $espacioDiv = 5 ?>
                @endif
                @if($dia->diaSemana == "jueves")
                    <?php $espacioDiv = 7 ?>
                @endif
                @if($dia->diaSemana == "viernes")
                    <?php $espacioDiv = 9 ?>
                @endif
                @if($dia->diaSemana == "sábado")
                    <?php $espacioDiv = 11 ?>
                @endif
                @if($dia->diaSemana == "domingo")
                    <?php $espacioDiv = 0 ?>
                @endif
                <div class="col-sm-{{$espacioDiv}}" align="center">
                    <br>
                </div>
            @endif

            @if($diaSelect->id == $dia->id)
                <?php $diaEstatusDiseño = "dia_activo" ?>
            @else
                @if($dia->estatus == 1)
                    <?php $diaEstatusDiseño = "dia_Abierto" ?>
                    <a href="{{ URL::to('agendaCita/'.$mesSelect->id.'/'.$dia->id)}}">
                @else
                    <?php $diaEstatusDiseño = "dia_Cerrado" ?>
                @endif
            @endif
            @if($dia->estatus == 0)
                <span class="hidden-xs">
            @endif
            @if($dia->diaSemana == "sábado" or $dia->diaSemana == "domingo")
                <div class="col-sm-1 {{$diaEstatusDiseño}}" align="center">
            @else
                <div class="col-sm-2 {{$diaEstatusDiseño}}" align="center">
            @endif
                <span class="hidden-lg hidden-md hidden-sm">
                    {{$dia->diaSemana}},
                </span>
                {{$dia->numDia}}
                 <span class="hidden-lg hidden-md hidden-sm">
                    <?php
                        setlocale(LC_TIME, 'es_ES');
                        $fecha = DateTime::createFromFormat('!m', $mesSelect->mes);
                        $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                    ?>
                    de {{$mes2}} del {{$mesSelect->ano}}
                </span>
                 <span class="hidden-xs">
                    <br>
                </span>
            </div>
            @if($dia->estatus == 0)
                </span>
            @endif
            @if($dia->estatus == 1)
                </a>
            @endif
        @endforeach
    </div>
@endif
