@if($mes->id <> -1)
    <div class="row">
        <div class="col-xs-12 align-self-center">
            <a href="{{ URL::to('mesVecino/a/'.$mes->id)}}" class="glyphicon glyphicon-chevron-left"></a>
            {{$mes->ano}} <a href="{{ URL::to('meses/'.$mes->ano)}}" class="glyphicon glyphicon-calendar"></a>
            <a href="{{ URL::to('mesVecino/d/'.$mes->id)}}" class="glyphicon glyphicon-chevron-right"></a>
            <a href="{{ URL::to('mes/-1/')}}" class="glyphicon glyphicon-plus-sign"></a>
        </div>
            <div class="col-xs-1 border hidden-md-down" align="center">
            Do
            </div>
            <div class="col-xs-2 border" align="center">
            Lu
            </div>
            <div class="col-xs-2 border" align="center">
            Ma
            </div>
            <div class="col-xs-2 border" align="center">
            Mi
            </div>
            <div class="col-xs-2 border" align="center">
            Ju
            </div>
            <div class="col-xs-2 border" align="center">
            Vi
            </div>
            <div class="col-xs-1 border" align="center">
            Sa
            </div>
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
                <div class="col-xs-{{$espacioDiv}}" align="center">
                    <br>
                </div>
            @endif


            @if($dia->diaSemana == "sábado" or $dia->diaSemana == "domingo")
                <div class="col-xs-1 border" align="center">
            @else
                <div class="col-xs-2 border" align="center">
            @endif
            <form method='POST' action='/abrirCerrarDia/Mes'>
                <a href="{{ URL::to('dia/'.$dia->id)}}">{{$dia->numDia}}</a>
                <span class="hidden-sm">
                    <br>
                </span>

                    {{ csrf_field() }}
                    <input type="hidden" name="dia" value="{{$dia->id}}">
                    <input type="hidden" name="mes" value="{{$mes->id}}">
                    @if($mes->estatus == "Abierto" or $mes->estatus == "Inactivo")
                        @if($dia->estatus == 1)
                                <i class="	"></i>
                                    <!--input type='submit' value='Cerrar' class='btn btn-cerrar '-->
                                    <button type="submit" value="Submit" class='glyphicon glyphicon-remove-sign btn btn-cerrar'> </button>



                        @else
                                <!--input type='submit' value='Abrir' class='btn btn-abrir'-->
                                <button type="submit" value="Submit" class='glyphicon glyphicon-ok-circle btn btn-abrir'> </button>
                        @endif
                    @elseif($mes->estatus == "Cerrado")
                        @if($dia->estatus == 1)
                                <!--input type='submit' value='Cerrar' class='btn btn-cerrar ' disabled-->
                                <button type="submit" value="Submit" class='glyphicon glyphicon-remove-sign btn btn-cerrar' disabled> </button>
                        @else
                                <!--input type='submit' value='Abrir' class='btn btn-abrir' disabled-->
                                <button type="submit" value="Submit" class='glyphicon glyphicon-ok-circle btn btn-abrir' disabled> </button>
                        @endif
                    @endif
                </form>
            </div>
        @endforeach
    </div>
@endif
