@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <!--div class="container center">
            <div class="row center">
                <div class="col-md-12">
                    ¿Ya tienes una cuenta? <a href='/login'>Entra aquí...</a>
                </div>
            </div>
        </div-->

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Usuario <a href="{{ URL::to('usuarios/')}}" class="glyphicon glyphicon glyphicon glyphicon-th-list"></a>
                </div>

                <div class="panel-body">
                    @if($usuario->id != -1)
                        <form method='POST' action='/usuario/guardar/{{$usuario->id}}'>
                   @else
                        <form method='POST' action='/usuario/guardar/-1'>
                   @endif
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $usuario->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                            <div class="col-md-6">
                                @if($usuario->id == -1)
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>
                                @else
                                    <input type="hidden" name="email" value="{{ $usuario->email }}">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}" disabled>
                                @endif

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('rol') ? ' has-error' : '' }}">
                            <label for="rol" class="col-md-4 control-label">Rol</label>

                            <div class="col-md-6">
                                <select name="rol"  class="form-control" required>
                                    @foreach($rolesForDropdown as $rol)
                                    <option value="{{ $rol }}" {{ $rol == $rolSelected ? 'selected="selected"' : '' }}> {{ $rol }} </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('rol'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rol') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <br>
                                @if($usuario->id == -1)
                                    <input type='submit' value='Crear Usuario' class='btn btn-primary btn-small'>
                                @else
                                    <input type='submit' value='Actualizar' class='btn btn-primary btn-small'>
                                @endif
                            </div>
                        </div>
                    </form>
                    @if(in_array(Auth::user()->rol, ['Master','Admin']))
                        @if($usuario->id != -1)
                            @include('usuario.sucursalesUsuario')
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
