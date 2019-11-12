 @if($cita->estatus == 'Agendada' or $cita->estatus == 'Valoracion')
    @if($cita->pasada == 0 or in_array(Auth::user()->rol, ['Master','Admin']))
        <a href="{{ URL::to('/cancelaCita/'.$cita->id)}}" class="glyphicon glyphicon-remove-sign aIconosCitas"></a>
    @endif
    <a href="{{ URL::to('/tomoCita/'.$cita->id)}}" class="glyphicon glyphicon-ok-sign aIconosCitas"></a>
    <a href="{{ URL::to('/perdioCita/'.$cita->id)}}" class="glyphicon glyphicon-minus-sign aIconosCitas"></a>
@endif
@if(in_array($cita->estatus, ['Cancelada']) and $hora->citasActivas<$hora->numCitasMax and ($cita->pasada == 0 or in_array(Auth::user()->rol, ['Master','Admin'])))
    <a href="{{ URL::to('/reagendaCita/'.$cita->id)}}" class="glyphicon glyphicon-repeat aIconosCitas"></a>
@endif
@if(in_array($cita->estatus, ['Tomada','VTomada','Perdida']) and in_array(Auth::user()->rol, ['Master','Admin']))
    <a href="{{ URL::to('/reagendaCita/'.$cita->id)}}" class="glyphicon glyphicon-repeat aIconosCitas"></a>
@endif
@if($cita->estatus == 'Valoracion' or $cita->estatus == 'VTomada')
    <span class="glyphicon glyphicon glyphicon-list-alt"></span>
@endif
