@extends('layouts.master')
@section('content')

@if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
    <?php
    $ocultar = "";
    $ocultarCliente = "";
    $ocultarTodo = "";
    ?>
@else
    <?php
    $ocultar = "ocultar";
    $ocultarCliente = "";
    $ocultarTodo = "";
    ?>
@endif

@if(in_array(Auth::user()->rol, ['ClienteNuevo']))
    <?php
    $ocultarCliente = "ocultar";
    ?>
@endif
@if($cliente->aceptoCondiciones==0 and $cliente->id != -1)
    <div class="col-xs-12 red">
        <label for="aceptoCondiciones" class="control-label">{{$cliente->nombre}} NO ha aceptado las condiciones de contrato y de servicio, favor de aceptarlas para poder continuar.</label>
    @if(in_array(Auth::user()->rol, ['Cliente','ClienteNuevo','Inactivo']))

        <form method='POST' action='/aceptoCondiciones'>
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{Auth::user()->id }}">
            <input type='submit' value='Acepto Condiciones de Contrato' class='btn btn-condiciones '>
        </form>

        <?php
        $ocultarTodo = "ocultar";
        ?>
    @endif
    </div>
@endif
<div class="col-md-12 {{$ocultarTodo}}">

    <div class="col-xs-4 col-sm-2 pestañasCliente" >
        <a id="iconoPestana" href="{{ URL::to('cliente/1/'.$cliente->id)}}">Información</a>
    </div>
    <div class="col-xs-4 col-sm-2 pestañasCliente {{$ocultar}}">
        <a id="iconoPestana" href="{{ URL::to('cliente/4/'.$cliente->id)}}">Servicios</a>
    </div>
    <div class="col-xs-4 col-sm-2 pestañasCliente {{$ocultarCliente}}">
        <a id="iconoPestana" href="{{ URL::to('cliente/2/'.$cliente->id)}}">Citas</a>
    </div>
    <div class="col-xs-4 col-sm-2 pestañasCliente {{$ocultarCliente}}">
        <a id="iconoPestana" href="{{ URL::to('cliente/3/'.$cliente->id)}}">Medidas</a>
    </div>
    <div class="col-xs-4 col-sm-2 pestañasCliente {{$ocultarCliente}}" >
        <a id="iconoPestana" href="{{ URL::to('cliente/5/'.$cliente->id)}}">Fotos</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading col-xs-12">

            @if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
                {{ $cliente->nombre }} <a href="{{ URL::to('clientes/')}}" class="glyphicon glyphicon glyphicon glyphicon-th-list"></a>
            @else
                {{$cliente->nombre}}
            @endif
        </div>

        <div class="panel-body" {{$hiddenInfo}}>
            @include('cliente.informacionCliente')
        </div>
        <div class="panel-body" {{$hiddenServ}}>
            @include('cliente.serviciosCliente')
        </div>
        <div class="panel-body" {{$hiddenRegi}}>
            @include('cliente.medidasCliente')
        </div>
        <div class="panel-body" {{$hiddenCita}}>
                @if($cliente->id != -1)
                    @include('cliente.citasCliente')
                @endif
        </div>
        <div class="panel-body" {{$hiddenFoto}}>
            @include('cliente.fotosCliente')
        </div>

    </div>
    <div class="col-xs-12 ">
        @if($cliente->aceptoCondiciones==1)
            <label for="aceptoCondiciones" class="control-label">{{$cliente->nombre}} aceptó las condiciones de contrato y de servicio, si tiene alguna duda comuniquese a sucursal.</label>
        @endif
    </div>

</div>
@endsection
