@extends('layouts.master')

@push('head')
    <link href="/css/mes.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    <?php setlocale(LC_TIME, 'es_ES'); ?>
    <div class="container">
        <div class="row">
            Por favor seleccione la sucursal:
            <div class="col-sm-12 align-center">
                @foreach($sucursales as $sucursal)
                    <span class="btn btn-primary btn-small"> <a href="/mesActual/{{$sucursal->id}}">{{$sucursal->nombre}}</a></span>
                @endforeach
			</div>
		</div>
    </div>

@endsection
