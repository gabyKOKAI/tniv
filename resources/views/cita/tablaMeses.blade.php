@if(count($meses)>0)
<div class="row">
    <?php
        $anoAnt = 1900;
        $mesAnt = 0;
    ?>
    @foreach($meses as $mes)
        <?php
            $anoAct = $mes->ano;
            $mesAct = $mes->mes;
            setlocale(LC_TIME, 'es_ES');
            $fecha = DateTime::createFromFormat('!m', $mes->mes);
            $mes1 = strftime("%B", $fecha->getTimestamp());
        ?>
        @if($anoAnt != $anoAct)

            @if($mesAnt < 12 and $anoAnt != 1900)
                @foreach(range($mesAnt+1,12,1) as $mesVacio)
                    <div class="col-sm-2 mes_no_disponible" align="center">
                        <?php
                            setlocale(LC_TIME, 'es_ES');
                            $fechaVacia = DateTime::createFromFormat('!m', $mesVacio);
                            $mesVacio1 = strftime("%B", $fechaVacia->getTimestamp());
                        ?>
                        {{$mesVacio1}}
                    </div>
                @endforeach
            @endif
            <div class="col-sm-12">
                <br>
            </div>
            <div class="col-sm-12 azul border align-self-center">
                {{$mes->ano}}
            </div>
            <?php
                $mesAnt = 0;
            ?>
         @endif

         @if($mesAnt+1 < $mesAct)
            @foreach(range($mesAnt+1,$mesAct-1,1) as $mesVacio)
                 <div class="col-sm-2 mes_no_disponible" align="center">
                        <?php
                            setlocale(LC_TIME, 'es_ES');
                            $fechaVacia = DateTime::createFromFormat('!m', $mesVacio);
                            $mesVacio1 = strftime("%B", $fechaVacia->getTimestamp());
                        ?>
                        {{$mesVacio1}}
                    </div>
            @endforeach
         @endif


            @if($mes->id == $mesSelect->id)
                <div class="col-sm-2 mes_activo" align="center">
                    {{$mes1}}
                </div>
            @else
                <a href="{{ URL::to('agendaCita/' . $mes->id)}}">
                <div class="col-sm-2 mes_disponible" align="center">
                    {{$mes1}}
                </div>
                </a>
            @endif


        <?php
            $anoAnt = $anoAct;
            $mesAnt = $mesAct;
        ?>
        @if($anoAnt != $anoAct)
        @endif
    @endforeach
    @if($mesAnt < 12 and $anoAnt != 1900)
        @foreach(range($mesAnt+1,12,1) as $mesVacio)
             <div class="col-sm-2 mes_no_disponible" align="center">
                        <?php
                            setlocale(LC_TIME, 'es_ES');
                            $fechaVacia = DateTime::createFromFormat('!m', $mesVacio);
                            $mesVacio1 = strftime("%B", $fechaVacia->getTimestamp());
                        ?>
                        {{$mesVacio1}}
                    </div>
        @endforeach
    @endif
</div>
@else
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
                <h4 class="center">
                    No hay horarios disponibles en este momento. Favor de ingresar más tarde.
                </h4>
            </div>
        </div>
    </div>
@endif
