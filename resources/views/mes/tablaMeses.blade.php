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
                        <div class="col-sm-12 center">
                            <br>
                            <a href="{{ URL::to('mes/-1/')}}" class="glyphicon glyphicon glyphicon-plus-sign"></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 align-self-center">

                            @foreach($meses as $mes)
                                    <?php
                                        setlocale(LC_TIME, 'es_ES');
                                        $fecha = DateTime::createFromFormat('!m', $mes->mes);
                                        $mes1 = strftime("%B", $fecha->getTimestamp()); // marzo
                                    ?>
                                    <div class="col-sm-3">
                                        <form method='POST' action='{{ URL::to('mes/' . $mes->id) }}'>
                                            {{ csrf_field() }}
                                            <input type='submit' value='{{$mes1}} {{$mes->ano}},{{$mes->sucursal->nombre}}' class="mes_{{$mes->estatus}}">

                                        </form>
                                    </div>
                            @endforeach

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
