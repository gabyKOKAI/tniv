@extends('layouts.master')

@push('head')
@endpush

@section('content')
    @if(count($sucursales)>0)
        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h1 class="center">Sucursales</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1">
                </div>
                <div class="col-sm-10 align-self-center">
                    <table class="table table-hover table-striped .table-striped table-responsive">
                        <thead>
                            <tr>
                                <!--th class="center">#</th-->
                                <th class="center">Nombre</th>
                                <th class="center">Hora Primera Cita </th>
                                <th class="center">Hora Última Cita</th>
                                <th class="center">Hora Comida</th>
                                <!--th class="center">
                                    <a href="{{URL::to('sucursal/-1')}}" class="glyphicon glyphicon-plus-sign"></a>
                                </th-->
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($sucursales as $sucursal)
                                <tr>
                                    <!--td>{{$sucursal->id}}</td-->
                                    <td> {{$sucursal->nombre}}</td>
                                    <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$sucursal->horaInicio)->format('g:i a')}}</td>
                                    <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$sucursal->horaFin)->format('g:i a')}}</td>
                                    <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$sucursal->horaComida)->format('g:i a')}}</td>
                                    <!--td>
                                        <a href="{{ URL::to('sucursal/'.$sucursal->id)}}" class="glyphicon glyphicon-edit"></a>
                                    </td-->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="col-sm-1">
                </div>
            </div>
        </div>

    <div class="container center">
        <div class="row">
            <div class="col-sm-1 align-self-center">
            </div>
            <div class="col-sm-10 align-self-center">

                <!-- { {$sucursales->lastPage()} } -->
                <!-- { {$sucursales->hasMorePages()} } -->
                <!-- { {$sucursales->url()} } -->
                <!-- { {$sucursales->nextPageUrl()} } -->
                <!-- { {$sucursales->lastItem()} } -->
                <!-- { {$sucursales->firstItem()} } -->
                <!-- { {$sucursales->count()} } -->
                <!-- { {$sucursales->perPage()} } -->
                <!-- { {$sucursales->currentPage()} } -->
                {{$sucursales->render()}}

            </div>
            <div class="col-sm-1 align-self-center">
            </div>
        </div>
    </div>

    @else
        <h1> Sin Sucursales <!--a href="{{ URL::to('sucursal/-1/')}}" class="glyphicon glyphicon-plus-sign"></a--></h1>
    @endif
@endsection
