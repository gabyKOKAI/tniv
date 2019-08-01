@extends('layouts.master')

@section('title')
    VINT Bienvenido
@endsection

@section('content')
    <h1>Bienvenid@ al Sistema de VINT</h1>

    @if(Auth::user())
        @if(in_array(Auth::user()->rol, ['ClienteNuevo','Inactivo']))
        <h4>Su usuario no está activo, solicité en sucursal que lo activen.</h4>
        @endif
    @endif
@endsection
