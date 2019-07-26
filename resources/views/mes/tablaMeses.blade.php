<div class="row">
    <div class="col-sm-12 align-right">
            <!--div class="container">
                <div class="row">
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                    <div class="col-sm-4 align-center">
                         <h3 class="center">Meses
                         </h3>
                    </div>
                    <div class="col-sm-4 align-left">
                        <hr>
                    </div>
                </div>
            </div-->
            @if(count($meses)>0)
                <div class="container center">
                    <div class="row">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-6 align-self-center">

                        <table class="table table-hover table-striped .table-striped table-responsive">
                            <thead>
                                <tr>
                                    <!--th class="center">#</th-->
                                    <th class="center">Mes-Año <a href="{{ URL::to('mes/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a></th>

                                    <th class="center">Sucursal</th>
                                    <th class="center">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($meses as $mes)
                                    <?php
                                    setlocale(LC_TIME, 'es_ES');
                                    ?>
                                    <tr>
                                        <!--td> <a href="{{ URL::to('mes/' . $mes->id) }}">{{$mes->id}}</a></td-->
                                        <td class="center">
                                            <?php
                                                $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                                $mes1 = strftime("%B", $fecha->getTimestamp()); // marzo
                                            ?>
                                            <a href="{{ URL::to('mes/'.$mes->id)}}">{{$mes1}} {{$mes->ano}}</a>

                                        </td>
                                        <td>{{$mes->sucursal->nombre}}</td>
                                        <td>{{$mes->estatus}}</td>
                                        <!--td>
                                            <a href="{{ URL::to('mes/'.$mes->id)}}" class="glyphicon glyphicon-edit"></a>
                                        </td-->

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
                            <!-- { {$meses->render()} } -->
                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <h4 class="center">
                                Sin Meses <a href="{{ URL::to('mes/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>
