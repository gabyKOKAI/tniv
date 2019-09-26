<div class="row">
    <div class="col-sm-12 align-right">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                    <div class="col-sm-4 align-center">
                         <h3 class="center">Clientes
                         </h3>
                    </div>
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                </div>
            </div>
            @if(count($clientes)>0)
                <div class="container center">
                    <div class="row">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-8 align-self-center">

                        <table class="table table-hover table-striped .table-striped table-responsive">
                            <thead>
                                <tr>
                                    <!--th class="center">#</th-->
                                    <th class="center"># Cliente </th>
                                    <th class="center">Nombre <a href="{{ URL::to('cliente/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></th>
                                    <th class="center">Correo</th>
                                    <th class="center">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{$cliente->numCliente}}</td>
                                        <td><a href="{{ URL::to('cliente/'.$cliente->id)}}">{{$cliente->nombre}}</a></td>
                                        @if(in_array(Auth::user()->rol, ['Master','Admin']))
                                            <td><!--a href="{ { URL::to('usuario/'.$cliente->user_id)} }"-->{{$cliente->correo}}<!--/a--></td>
                                        @else
                                            <td>{{$cliente->correo}}</td>
                                        @endif
                                        <td>{{$cliente->estatus}}</td>
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
</div>
