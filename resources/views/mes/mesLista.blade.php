@extends('layouts.master')

@push('head')
    <link href="/css/mes.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    <?php
    setlocale(LC_TIME, 'es_ES');
    ?>
    @include('mes.mesFiltros')
    @include('mes.tablaMeses')
@endsection

@push('body')
    <script src="/js/mes/lista.js"></script>
@endpush
