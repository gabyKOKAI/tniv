@extends('layouts.master')

@section('title')
    VINT Bienvenido
@endsection

@section('content')
<?php $proxCitas = session('proxCitas'); ?>
    <h1>Bienvenid@ al Sistema de VINT</h1>

    @if(Auth::user())
        @if(count($proxCitas)>0)
            Próximas citas:
            <br>
            @foreach($proxCitas as $cita)
                {{$cita->fecha}}
                <br>
            @endforeach
        @endif
        @if(in_array(Auth::user()->rol, ['ClienteNuevo','Inactivo']))
        <h4>Su usuario no está activo, solicité en sucursal que lo activen.</h4>
        @endif
    @endif
@endsection
