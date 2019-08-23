@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">

                    @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                        Cliente <a href="{{ URL::to('clientes/')}}" class="glyphicon glyphicon glyphicon glyphicon-th-list"></a>
                    @else
                        {{$cliente->nombre}}
                    @endif
                </div>

                <div class="panel-body">
                   @if($cliente->id != -1)
                        <form method='POST' action='/cliente/guardar/{{$cliente->id}}'>
                   @else
                        <form method='POST' action='/cliente/guardar/-1'>
                   @endif
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $cliente->nombre }}" required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('correo') ? ' has-error' : '' }}">
                            <label for="correo" class="col-md-4 control-label">Correo Electrónico</label>

                            <div class="col-md-6">
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
                        </div>

                        @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                            <div class="form-group{{ $errors->has('estatus') ? ' has-error' : '' }}">
                                <label for="rol" class="col-md-4 control-label">Estatus</label>

                                <div class="col-md-6">
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
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <br>
                                @if($cliente->id == -1)
                                    <input type='submit' value='Crear Cliente' class='btn btn-primary btn-small'>
                                @else
                                    <input type='submit' value='Actualizar' class='btn btn-primary btn-small'>
                                @endif
                            </div>
                        </div>
                    </form>
                    @if(in_array(Auth::user()->rol, ['Master1','Admin1']))
                        @if($cliente->id != -1)
                            @include('usuario.sucursalesUsuario')
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
