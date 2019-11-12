@if($mes->id <> -1)
    <div class="row">
        <div class="col-xs-12 align-self-center btn btn-mesDia">
            <a href="{{ URL::to('mesVecino/a/'.$mes->id)}}" class="glyphicon glyphicon-chevron-left"></a>
            {{$mes->ano}}
            <a href="{{ URL::to('mesVecino/d/'.$mes->id)}}" class="glyphicon glyphicon-chevron-right"></a>
            <a href="{{ URL::to('mes/-1/')}}" class="glyphicon glyphicon-plus-sign"></a>
        </div>
        <div class="col-xs-1 fondoCalendario borderCalendario" align="center">
        Do
        </div>
        <div class="col-xs-2 fondoCalendario borderCalendario" align="center">
        Lu
        </div>
        <div class="col-xs-2 fondoCalendario borderCalendario" align="center">
        Ma
        </div>
        <div class="col-xs-2 fondoCalendario borderCalendario" align="center">
        Mi
        </div>
        <div class="col-xs-2 fondoCalendario borderCalendario" align="center">
        Ju
        </div>
        <div class="col-xs-2 fondoCalendario borderCalendario" align="center">
        Vi
        </div>
        <div class="col-xs-1 fondoCalendario borderCalendario" align="center">
        Sa
        </div>
        @foreach($diasMes as $dia)
            @php
                $espacioDiv = 0;
                if($dia->numDia == 1){
                    if($dia->diaSemana == "lunes"){
                        $espacioDiv = 1;
                    }
                    if($dia->diaSemana == "martes"){
                        $espacioDiv = 3;
                    }
                    if($dia->diaSemana == "miércoles"){
                        $espacioDiv = 5;
                    }
                    if($dia->diaSemana == "jueves"){
                        $espacioDiv = 7;
                    }
                    if($dia->diaSemana == "viernes"){
                        $espacioDiv = 9;
                    }
                    if($dia->diaSemana == "sábado"){
                        $espacioDiv = 11;
                    }
                    if($dia->diaSemana == "domingo"){
                        $espacioDiv = 0;
                    }
                }
            @endphp
            @if($dia->numDia == 1)
                <div class="col-xs-{{$espacioDiv}}" align="center">
                    <br>
                </div>
            @endif

            @if($dia->diaSemana == "sábado" or $dia->diaSemana == "domingo")
                @if($dia->estatus == 1)
                    <div class="col-xs-1 borderCalendario fondoCalendarioCerrar" align="center">
                @else
                    <div class="col-xs-1 borderCalendario fondoCalendarioAbrir" align="center">
                @endif
            @else
                @if($dia->estatus == 1)
                    <div class="col-xs-2 borderCalendario fondoCalendarioCerrar" align="center">
                @else
                    <div class="col-xs-2 borderCalendario fondoCalendarioAbrir" align="center">
                @endif
            @endif
            <form method='POST' action='/abrirCerrarDia/Mes'>
                <a class="btn btn-dia " href="{{ URL::to('dia/'.$dia->id)}}">{{$dia->numDia}}</a>
                <br>
                <span class="">
                    {{ csrf_field() }}
                    <input type="hidden" name="dia" value="{{$dia->id}}">
                    <input type="hidden" name="mes" value="{{$mes->id}}">
                    @if(($mes->estatus == "Abierto" or $mes->estatus == "Inactivo"))
                        @if($dia->estatus == 1)
                            <!--i class="	"></i-->
                            <!--input type='submit' value='Cerrar' class='btn btn-cerrar '-->
                            <button type="submit" value="Submit" class='glyphicon glyphicon-remove-sign btn btn-cerrar'> </button>
                        @else
                            <!--input type='submit' value='Abrir' class='btn btn-abrir'-->
                            <button type="submit" value="Submit" class='glyphicon glyphicon-ok-circle btn btn-abrir'> </button>
                        @endif
                    @elseif( ($mes->estatus == "Cerrado"))
                        @if($dia->estatus == 1)
                            <!--input type='submit' value='Cerrar' class='btn btn-cerrar ' disabled-->
                            <button type="submit" value="Submit" class='glyphicon glyphicon-remove-sign btn btn-cerrar' disabled> </button>
                        @else
                            <!--input type='submit' value='Abrir' class='btn btn-abrir' disabled-->
                            <button type="submit" value="Submit" class='glyphicon glyphicon-ok-circle btn btn-abrir' disabled> </button>
                        @endif
                    @endif
                </span>
            </form>
            </div>
        @endforeach
    </div>
@endif
