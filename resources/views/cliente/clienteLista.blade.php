@extends('layouts.master')

@push('head')
    <link href="/css/mes.css" type='text/css' rel='stylesheet'>
@endpush

@section('content')
    @include('cliente.clienteFiltros')
    @include('cliente.tablaClientes')
@endsection

@push('body')
    <script src="/js/mes/lista.js"></script>
@endpush