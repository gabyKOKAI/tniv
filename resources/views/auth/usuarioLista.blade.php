@extends('layouts.master')

@push('head')
    <!--link href="/css/usuario.css" type='text/css' rel='stylesheet'-->
@endpush

@section('content')
    @if(count($usuarios)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Usuarios</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6 align-self-center">
                    <table class="table table-hover table-striped .table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <!--th class="center">#</th-->
                                                <th class="center">Nombre</th>
                                                <th class="center">Correo </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($usuarios as $usuario)
                                                <tr>
                                                    <!--td>{{$usuario->id}}</td-->
                                                    <td> {{$usuario->name}}</td>
                                                    <td> {{$usuario->email}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                </div>
                <div class="col-sm-3">
                </div>
            </div>
        </div>

    <div class="container center">
        <div class="row">
            <div class="col-sm-3 align-self-center">
            </div>
            <div class="col-sm-6 align-self-center">
                {{$usuarios->render()}}

            </div>
            <div class="col-sm-3 align-self-center">
            </div>
        </div>
    </div>
    @endif
@endsection