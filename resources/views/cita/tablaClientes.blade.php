<div class="row">
    <div class="col-sm-12 align-right">
            <div class="container">
                <div class="row">
                    <div class="hidden-xs col-sm-1 align-left">
                        <hr>
                    </div>
                    <div class="col-xs-12 col-sm-10 align-center    ">
                         <span class="center letraNormal">Cita para el {{$fecha}}
                         </span>
                    </div>
                    <div class="hidden-xs col-sm-1 align-left">
                        <hr>
                    </div>
                </div>
            </div>
            @if(count($clientes)>0)
                <div class="container center">
                    <div class="row">
                        <div class="hidden-xs col-sm-2">
                        </div>
                        <div class="col-xs-12 col-sm-8 align-self-center">
                            <table class="table table-hover table-striped .table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <!--th class="center"># Cliente </th-->
                                        <th class="center">Nombre</th>
                                        <!--th class="center">Correo</th-->
                                        <th class="center" colspan="2" >Agendar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($clientes as $cliente)
                                        <tr>
                                            <!--td>{{$cliente->numCliente}}</td-->
                                            <td>{{$cliente->nombre}}</td>
                                            <!--td>{{$cliente->correo}}</td-->
                                            <td>
                                                <form method='POST' action='/agendarCita'>
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="hora" value="{{$hora->id}}">
                                                    <input type="hidden" name="id_cliente" value="{{$cliente->id}}">
                                                    <input type='submit' value='Cita' class='btn btn-cerrarH '>
                                                </form>
                                            </td>
                                            <td>
                                                <form method='POST' action='/agendarValoracion'>
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="hora" value="{{$hora->id}}">
                                                    <input type="hidden" name="id_cliente" value="{{$cliente->id}}">
                                                    <input type='submit' value='Valoración' class='btn btn-cerrarH '>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="hidden-xs col-sm-2">
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
