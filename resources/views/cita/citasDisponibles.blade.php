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
    @php
        $proxCitas = session('proxCitas');
        $numCitas = session('numCitas');
        $numCitasTomPerAg = session('numCitasTomPerAg');
        $numCitasPosibles = session('numCitasPosibles');
    @endphp
    @if($numCitas < 5 and $numCitasTomPerAg<$numCitasPosibles)
        @if($diaSelect)
            @include('cita.dia')
        @endif
        @if($mesSelect)
            @include('cita.diasCalendarioMes')
        @endif
        @include('cita.tablaMeses')
    @endif
@endsection

@push('body')
    <script src="/js/citas/citasDisponibles.js"></script>
@endpush
