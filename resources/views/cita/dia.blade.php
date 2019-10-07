@if($diaSelect->id <> -1 and $diaSelect->estatus == 1 and $mesSelect->estatus == "Abierto")
<div class="row">
    <div class="col-sm-12" align="center">
        <br>

    </div>
    <div class="col-sm-12 tituloTablaCitas border align-self-center">
        Horarios Disponibles para el día {{$diaSelect->numDia}} de {{$mesSelectedNombre}} del {{$mesSelect->ano}}:
    </div>
</div>
<div class="row">
        @if($diaSelect->id <> -1 and $diaSelect->estatus == 1)
            @foreach($horasDia as $hora)
                @if($hora->estatus == 0)
                    <span class="hidden-xs">
                @endif
                @if($hora->estatus == 1)
                    <div class="col-md-2 col-sm-2 col-xs-3 border" align="center">
                @else
                    <!--div class="col-md-1 col-sm-2 col-xs-3 border grisC" align="center"-->
                @endif


                        <form method='POST' action='/agendarCita'>
                            {{ csrf_field() }}
                            <input type="hidden" name="hora" value="{{$hora->id}}">

                            @if($hora->estatus == 1 and count($hora->citas)<$hora->numCitasMax)
                                <button type="submit" value="Submit" class='btn btn-horaDisponible'>{{\Carbon\Carbon::createFromFormat('H:i:s',$hora->hora)->format('g:i a')}} </button>
                            @else
                                @if($hora->estatus == 1)
                                    <input type='submit' value='Completo' class='btn btn-horaNoDisponible ' disabled>
                                @else
                                    <!--input type='submit' value='Cerrado' class='btn btn-horaNoDisponible ' disabled-->
                                @endif
                            @endif
                        </form>
                @if($hora->estatus == 1)
                    </div>
                @endif
                 @if($hora->estatus == 0)
                    </span>
                @endif
            @endforeach
        @endif
    </div>
@endif
