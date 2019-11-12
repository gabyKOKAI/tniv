<div class="col-sm-12 align-right">
    <div class="container">
        <div class="row">
            <div class="hidden-xs col-sm-4 align-left">
                <hr>
            </div>
            <div class="col-sm-4 align-center">
                 <h3 class="center">Clientes
                 </h3>
            </div>
            <div class="hidden-xs col-sm-4 align-left">
                <hr>
            </div>
        </div>
    </div>
    @if(count($clientes)>0)
        <div class="col-sm-12 align-self-center">
            <table class="table table-hover table-striped .table-striped table-responsive">
                <thead>
                    <tr>
                        <!--th class="center">#</th-->
                        <!--th class="center"># Cliente </th-->
                        <th class="center">Cliente <a href="{{ URL::to('cliente/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></th>
                        <th class="hidden-xs hidden-sm center ">Correo</th>
                        <th class="hidden-xs center">Estatus</th>
                        <th class="hidden-xs center"># Servicios</th>
                        <th class="hidden-xs center"># Medidas</th>
                        <th class="center"># Citas</th>
                        <th class="hidden-xs center"># Tomadas</th>
                        <th class="hidden-xs center"># Perdidas</th>
                        <th class="hidden-xs center"># Agendadas</th>
                        <th class="hidden-xs center">Valoración</th>
                    </tr>
                </thead>
                <tbody>

                     @foreach($clientes as $cliente)
                        <tr>
                            <!--td>{{$cliente->numCliente}}</td-->
                            <td class="hidden-xs">
                                <a href="{{ URL::to('cliente/1/'.$cliente->id)}}">{{$cliente->nombre}}</a>
                            </td>
                            @if(in_array(Auth::user()->rol, ['Master']))
                                <td class="hidden-xs hidden-sm center ">
                                <a href="{ { URL::to('usuario/'.$cliente->user_id)} }">
                                {{$cliente->correo}}
                                </a></td>
                            @else
                                <td class="hidden-xs hidden-sm center ">{{$cliente->correo}}</td>
                            @endif
                            <td class="hidden-sm hidden-md hidden-lg hidden-xl left">
                                <a href="{{ URL::to('cliente/1/'.$cliente->id)}}">{{$cliente->nombre}}</a>
                                <br>
                                {{$cliente->estatus}}
                                <br>
                                {{count($cliente->getServicios($cliente->id))}} servicio(s)
                                <br>
                                {{count($cliente->getMedidas($cliente->id))}} medida(s)
                            </td>
                            <td class="hidden-xs ">{{$cliente->estatus}}</td>
                            <td class="hidden-xs ">{{count($cliente->getServicios($cliente->id))}}</td>
                            <td class="hidden-xs ">{{count($cliente->getMedidas($cliente->id))}}</td>
                            <td class="hidden-sm hidden-md hidden-lg hidden-xl left">
                                Citas: {{$cliente->getServicioActivo($cliente->id)->numCitas}}
                                <br>
                                Tomadas: {{$cliente->getServicioActivo($cliente->id)->numCitasTomadas}}
                                <br>
                                Perdidas: {{$cliente->getServicioActivo($cliente->id)->numCitasPerdidas}}
                                <br>
                                Agendadas: {{$cliente->getServicioActivo($cliente->id)->numCitasAgendadas}}
                                <br>
                                @if($cliente->getServicioActivo($cliente->id)->valoracion)
                                    Con Valoración
                                @else
                                    Sin Valoración
                                @endif
                            </td>
                            <td class="hidden-xs ">{{$cliente->getServicioActivo($cliente->id)->numCitas}}</td>
                            <td class="hidden-xs ">{{$cliente->getServicioActivo($cliente->id)->numCitasTomadas}}</td>
                            <td class="hidden-xs ">{{$cliente->getServicioActivo($cliente->id)->numCitasPerdidas}}</td>
                            <td class="hidden-xs ">{{$cliente->getServicioActivo($cliente->id)->numCitasAgendadas}}</td>
                            @if($cliente->getServicioActivo($cliente->id)->valoracion)
                                <td class="hidden-xs ">Si</td>
                            @else
                                <td class="hidden-xs ">No</td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="container center">
            <div class="row">
                <div class="col-sm-12 align-self-center">

                    <!-- { {$meses->lastPage()} } -->
                    <!-- { {$meses->hasMorePages()} } -->
                    <!-- { {$meses->url()} } -->
                    <!-- { {$meses->nextPageUrl()} } -->
                    <!-- { {$meses->lastItem()} } -->
                    <!-- { {$meses->firstItem()} } -->
                    <!-- { {$meses->count()} } -->
                    <!-- { {$meses->perPage()} } -->
                    <!-- { {$meses->currentPage()} } -->
                    {{$clientes->render()}}
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-sm-12 align-center">
                    <h4 class="center">
                        Sin Clientes <a href="{{ URL::to('cliente/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                    </h4>
                </div>
            </div>
        </div>
    @endif
</div>
