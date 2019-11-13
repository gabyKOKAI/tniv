@extends('layouts.master')

@section('title')
    VINT Bienvenido
@endsection

@section('content')
    <h1 class="bienvenido">¡Bienvenido al Sistema Vint!</h1>
    @if(Auth::user())
        @if(in_array(Auth::user()->rol, ['ClienteNuevo','Inactivo']))
            <h4>Su usuario no está activo, si aun no lo hace favor de aceptar las condiciones de contrato y solicitar en sucursal que lo activen.</h4>
            @if(Auth::user()->getCliente(Auth::user()->id)->aceptoCondiciones==0)
                <form method='POST' action='/aceptoCondiciones'>
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type='submit' value='Acepto Condiciones de Contrato' class='btn btn-condiciones '>
                </form>
            @endif
        @else
           @include('cliente.citasCliente')
        @endif
    @endif
@endsection
