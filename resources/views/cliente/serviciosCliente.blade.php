@if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
   <?php
    $disabled = "";
    $ocultar = "";
    ?>
@else
    <?php
    $disabled = "disabled";
    $ocultar = "ocultar";
    ?>
@endif
    <?php
        $numServ = 0
    ?>
    <form method='POST' action='/servicio/guardar'>
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="servicioId" value="-1">
        <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
        <div class="row {{$ocultar}}">
            <div class=" col-xs-0 col-sm-3 col-md-4 col-lg-4">
            </div>
            <div class=" col-xs-11 col-sm-4 col-md-3 col-lg-3">
                <label>Fecha  Inicio</label>
                <input name="fechaInicio" type="date" class="form-control"  autofocus required>
            </div>
            <div class=" col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <br>
                <button type="submit" value="Submit" class='glyphicon glyphicon-plus btn btn-cerrar {{$ocultar}}' {{$disabled}}> </button>
            </div>
        </div>
    </form>
    <hr>
    @foreach($cliente->getServicios($cliente->id) as $servicio)
    <?php
        $numServ = $numServ + 1
    ?>
    <form method='POST' action='/servicio/guardar'>
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="servicioId" value="{{$servicio->id}}">
        <div class="row estatusServicio_{{$servicio->estatus}}">
            <div class="form-group{{ $errors->has('$servicio->id') ? ' has-error' : '' }} col-xs-12 col-sm-12 col-md-1 col-lg-1">
                <label class="control-label letraMenu">{{ $numServ }}</label>
            </div>
            <div class="form-group{{ $errors->has('estatus') ? ' has-error' : '' }} col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label class="control-label">Estatus</label>

                @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                    <select name="estatusServ"  class="form-control">
                        @foreach($estatusServForDropdown as $estatus)
                            <option value="{{ $estatus }}" {{ $estatus == $servicio->estatus ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                        @endforeach
                    </select>

                    @if ($errors->has('estatusServ'))
                        <span class="help-block">
                            <strong>{{ $errors->first('estatusServ') }}</strong>
                        </span>
                    @endif
                @else
                    <input id="estatus" type="text" class="form-control" name="estatus" value="{{ $servicio->estatus }}" disabled>
                @endif
            </div>
            <div class="form-group{{ $errors->has('$servicio->fechaInicio') ? ' has-error' : '' }} col-xs-12 col-sm-4 col-md-3 col-lg-2">
                <label class="control-label">Fecha  Inicio</label>
                <input name="fechaInicio" type="date" class="form-control" value="{{$servicio->fechaInicio}}"  autofocus {{$disabled}}>
            </div>

            <div class="form-group{{ $errors->has('$servicio->fechaFin') ? ' has-error' : '' }} col-xs-12 col-sm-4 col-md-3 col-lg-2">
                <label class="control-label">Fecha  Fin</label>
                <input name="fechaFin" type="date" class="form-control" value="{{$servicio->fechaFin}}"  autofocus {{$disabled}}>
            </div>
            <div class="form-group{{ $errors->has('$servicio->fechaPago') ? ' has-error' : '' }} col-xs-12 col-sm-4 col-md-3 col-lg-2">
                <label class="control-label">Fecha  Pago</label>
                <input name="fechaPago" type="date" class="form-control" value="{{$servicio->fechaPago}}"  autofocus {{$disabled}}>
            </div>
            <div class="form-group{{ $errors->has('medidas') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-2 col-lg-1">
                <label class="control-label">Medidas: </label>
                {{ count($servicio->medidas) }}
            </div>
            <div class="form-group hidden-xs hidden-sm hidden-md col-lg-2">
                <button type="submit" value="Submit" class='glyphicon glyphicon-refresh btn btn-actualizaServ {{$ocultar}}' {{$disabled}}> </button>
            </div>


        </div>
        <div class="row estatusServicio_{{$servicio->estatus}}">
            <div class="col-xs-0 col-sm-0 col-md-1 col-lg-1">
            </div>
            <div class="form-group{{ $errors->has('numCitas') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-2 col-lg-1">
            <label class="control-label"># Citas</label>
            <input name="numCitas" type="number" class="form-control" value="{{ $servicio->numCitas }}" min="0" max="300" autofocus {{$disabled}}>
            @if ($errors->has('numCitas'))
                <span class="help-block">
                    <strong>{{ $errors->first('numCitas') }}</strong>
                </span>
            @endif
            </div>
            <div class="form-group{{ $errors->has('numCitasAgendadas') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-2 col-lg-1">
            <label class="control-label">Agendadas</label>
            <input name="numCitasAgendadas" type="number" class="form-control" value="{{ $servicio->numCitasAgendadas }}" min="0" max="300" autofocus {{$disabled}}>
            @if ($errors->has('numCitasAgendadas'))
                <span class="help-block">
                    <strong>{{ $errors->first('numCitasAgendadas') }}</strong>
                </span>
            @endif
            </div>
            <div class="form-group{{ $errors->has('numCitasTomadas') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-2 col-lg-1">
            <label class="control-label">Tomadas</label>
            <input name="numCitasTomadas" type="number" class="form-control" value="{{ $servicio->numCitasTomadas }}" min="0" max="300" autofocus {{$disabled}}>
            @if ($errors->has('numCitasTomadas'))
                <span class="help-block">
                    <strong>{{ $errors->first('numCitasTomadas') }}</strong>
                </span>
            @endif
            </div>
            <div class="form-group{{ $errors->has('numCitasPerdidas') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-2 col-lg-1">
            <label class="control-label">Perdidas</label>
            <input name="numCitasPerdidas" type="number" class="form-control" value="{{ $servicio->numCitasPerdidas }}" min="0" max="300" autofocus {{$disabled}}>
            @if ($errors->has('numCitasPerdidas'))
                <span class="help-block">
                    <strong>{{ $errors->first('numCitasPerdidas') }}</strong>
                </span>
            @endif
            </div>
            <div class="form-group{{ $errors->has('valoracion') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-3 col-lg-1">
                <label class="control-label">¿Valoracion?</label>
                <input name="valoracion" type="checkbox" class="form-control" {{ $servicio->valoracion ? 'checked="checked"' : '' }} {{$disabled}}>
                @if ($errors->has('valoracion'))
                    <span class="help-block">
                        <strong>{{ $errors->first('valoracion') }}</strong>
                    </span>
                @endif
            </div>
            <div class="hidden-xs hidden-sm col-md-1 hidden-lg">
            </div>
            <div class="form-group{{ $errors->has('postParto') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-1 col-lg-1">
                <label class="control-label">¿Posparto?</label>
                <input name="postParto" type="checkbox" class="form-control" {{ $servicio->postParto ? 'checked="checked"' : '' }} {{$disabled}}>
                @if ($errors->has('postParto'))
                    <span class="help-block">
                        <strong>{{ $errors->first('postParto') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('alimentacion') ? ' has-error' : '' }} col-xs-4 col-sm-3 col-md-2 col-lg-1">
                <label class="control-label">¿Alimentación?</label>
                <input name="alimentacion" type="checkbox" class="form-control" {{ $servicio->alimentacion ? 'checked="checked"' : '' }} {{$disabled}}>
                @if ($errors->has('alimentacion'))
                    <span class="help-block">
                        <strong>{{ $errors->first('alimentacion') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-xs-12 col-sm-12 col-md-12 hidden-lg">
                <button type="submit" value="Submit" class='glyphicon glyphicon-refresh btn btn-actualizaServ {{$ocultar}}' {{$disabled}}> </button>
            </div>
        </div>
        </form>

@endforeach
