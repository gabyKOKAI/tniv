@extends('layouts.master')

@push('head')
    <link href="/css/citasDisponibles.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    <?php
        setlocale(LC_TIME, 'es_ES');
    ?>
    <?php
        setlocale(LC_TIME, 'es_ES');
        if($mesSelect->mes){
            $fechaVacia = DateTime::createFromFormat('!m', $mesSelect->mes);
            $mesSelectedNombre = strftime("%B", $fechaVacia->getTimestamp());
        }
    ?>
    <?php $proxCita = session('proxCita'); ?>
    @if($proxCita == -1)
        @include('cita.tablaMeses')
        @if($mesSelect)
            @include('cita.diasCalendarioMes')
        @endif
        @if($diaSelect)
            @include('cita.dia')
        @endif
    @endif
@endsection

@push('body')
    <script src="/js/citas/citasDisponibles.js"></script>
@endpush
