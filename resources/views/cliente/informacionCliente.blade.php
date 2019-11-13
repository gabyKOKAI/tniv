@php
    if($cliente->id != -1){
        $actionForm = "/cliente/guardar/".$cliente->id;
    }else{
        $actionForm = "/cliente/guardar/-1";
    }
@endphp

<form method='POST' action='{{$actionForm}}' >
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group{{ $errors->has('numCliente') ? ' has-error' : '' }} col-xs-12 col-sm-2 col-md-2 col-lg-2">
        <label for="numCliente" class="control-label"># Cliente</label>
        @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
            <input id="numCliente" type="text" class="form-control" name="numCliente" value="{{ $cliente->numCliente }}" placeholder="# Cliente" required autofocus>
        @else
            <input type="hidden" name="numCliente" value="{{ $cliente->numCliente }}">
            <input id="numCliente" type="text" class="form-control" name="numCliente" value="{{ $cliente->numCliente }}" placeholder="# Cliente" disabled>
        @endif
        @if ($errors->has('numCliente'))
            <span class="help-block">
                <strong>{{ $errors->first('numCliente') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }} required control-label col-xs-12 col-sm-6 col-md-4 ">
        <label for="nombre" class="control-label">Nombre</label>
        <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $cliente->nombre }}" required>
        @if ($errors->has('nombre'))
            <span class="help-block">
                <strong>{{ $errors->first('nombre') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('correo') ? ' has-error' : '' }} required control-label col-xs-12 col-sm-6 col-md-4">
        <label for="correo" class="control-label">Correo Electrónico</label>

        @if($cliente->id == -1)
            <input id="correo" type="email" class="form-control" name="correo" value="{{ $cliente->correo }}" required>
        @else
            <input type="hidden" name="correo" value="{{ $cliente->correo }}">
            <input id="correo" type="email" class="form-control" name="correo" value="{{ $cliente->correo }}" disabled>
        @endif

        @if ($errors->has('correo'))
            <span class="help-block">
                <strong>{{ $errors->first('correo') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('estatus') ? ' has-error' : '' }} required control-label col-xs-12 col-sm-4 col-md-3 col-lg-2">
        <label for="estatus" class="control-label">Estatus</label>

        @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
            <select name="estatus"  class="form-control" required>
                @foreach($estatusForDropdown as $estatus)
                <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                @endforeach
            </select>

            @if ($errors->has('estatus'))
                <span class="help-block">
                    <strong>{{ $errors->first('estatus') }}</strong>
                </span>
            @endif
        @else
            <input id="estatus" type="text" class="form-control" name="estatus" value="{{ $cliente->estatus }}" disabled>
        @endif
    </div>

    <div class="form-group{{ $errors->has('telefono1') ? ' has-error' : '' }} required control-label col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <label for="telefono1">Teléfono</label>
        <input id="telefono1" type="text" class="form-control" name="telefono1" value="{{ $cliente->telefono1 }}" placeholder="" required autofocus>
        @if ($errors->has('telefono1'))
                <span class="help-block">
                <strong>{{ $errors->first('telefono1') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('telefono2') ? ' has-error' : '' }} col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <label for="telefono2" class="control-label">Teléfono Aux</label>
        <input id="telefono2" type="text" class="form-control" name="telefono2" value="{{ $cliente->telefono2 }}" placeholder="" autofocus>
        @if ($errors->has('telefono2'))
            <span class="help-block">
                <strong>{{ $errors->first('telefono2') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('fechaNacimiento') ? ' has-error' : '' }} col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <label for="fechaNacimiento" class="control-label">Fecha Nacimiento</label>
        <input id="fechaNacimiento" type="date" class="form-control" name="fechaNacimiento" value="{{ $cliente->fechaNacimiento }}" placeholder="" autofocus>
        @if ($errors->has('fechaNacimiento'))
            <span class="help-block">
                <strong>{{ $errors->first('fechaNacimiento') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('altura') ? ' has-error' : '' }} col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <label for="altura" class="control-label">Altura (cm)</label>
        <input id="altura" type="number" class="form-control" name="altura" value="{{ $cliente->altura }}" min="0" max="300" autofocus>
        @if ($errors->has('altura'))
            <span class="help-block">
                <strong>{{ $errors->first('altura') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('correoAgendar') ? ' has-error' : '' }} col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <label for="correoAgendar" class="control-label">¿Recibir Correo al agendar?</label>
        <input id="correoAgendar" type="checkbox" class="form-control" name="correoAgendar" {{ $cliente->correoAgendar ? 'checked="checked"' : '' }}>
        @if ($errors->has('correoAgendar'))
            <span class="help-block">
                <strong>{{ $errors->first('correoAgendar') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('correoCancelar') ? ' has-error' : '' }} col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <label for="correoCancelar" class="control-label">¿Recibir Correo al cancelar?</label>
        <input id="correoCancelar" type="checkbox" class="form-control" name="correoCancelar" {{ $cliente->correoCancelar ? 'checked="checked"' : '' }}>
        @if ($errors->has('correoCancelar'))
            <span class="help-block">
                <strong>{{ $errors->first('correoCancelar') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('seEntero') ? ' has-error' : '' }} required control-label col-xs-12 col-md-6">
        <label for="seEntero" class="control-label">¿Cómo te enteraste de nosotros?</label>
        <select name="seEntero"  class="form-control" required>
            @foreach($seEnteroForDropdown as $seEntero)
            <option value="{{ $seEntero }}" {{ $seEntero == $seEnteroSelected ? 'selected="selected"' : '' }}> {{ $seEntero }} </option>
            @endforeach
        </select>
        @if ($errors->has('nombre'))
            <span class="help-block">
                <strong>{{ $errors->first('nombre') }}</strong>
            </span>
        @endif
    </div>



    <div class="form-group col-md-12">
        @if($cliente->id == -1)
            <input type='submit' value='Crear Cliente' class='btn btn-primary btn-small'>
        @else
            <input type='submit' value='Actualizar' class='btn btn-primary btn-small'>
        @endif
    </div>
</form>
@if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
    @if($cliente->id != -1)
        @include('usuario.sucursalesUsuario')
    @endif
@endif
