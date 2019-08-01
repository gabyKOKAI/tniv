@if($mes->id <> -1)
    <div class="row">
        <div class="col-sm-12 align-self-center">
            <a href="{{ URL::to('mesVecino/a/'.$mes->id)}}" class="glyphicon glyphicon-chevron-left"></a>
            <a href="{{ URL::to('mesVecino/d/'.$mes->id)}}" class="glyphicon glyphicon-chevron-right"></a>
            <a href="{{ URL::to('mes/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
       </div>
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



            @if($dia->diaSemana == "sábado" or $dia->diaSemana == "domingo")
                <div class="col-sm-1 border" align="center">
            @else
                <div class="col-sm-2 border" align="center">
            @endif
                <a href="{{ URL::to('dia/'.$dia->id)}}">{{$dia->numDia}}</a>
                <br>
                <form method='POST' action='/abrirCerrarDia/Mes'>
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
