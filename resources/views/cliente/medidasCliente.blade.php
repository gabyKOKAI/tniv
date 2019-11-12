@if(in_array(Auth::user()->rol, ['Master','Admin','AdminSucursal']))
   <?php
    $disabled = "";
    $ocultar = "";
    ?>
@else
    <?php
    $disabled = "disabled";
    $ocultar = "ocultar";
    ?>
@endif
<?php
    $numMed = 0
?>
    <form method='POST' action='/medida/guardar'>
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="servicio_id" value="-1">
        <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
        <div class="row">
            <div class="form-group required control-label col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <label>Fecha</label>
                <input name="fecha" type="date" class="form-control" value="{{$medida->fecha}}"  autofocus required>
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <span class="fontBold">¿Vendas? </span>
                <input id="vendas" type="checkbox" class="form-control" name="vendas">
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label>Peso (Kg)</label>
                <input name="peso" type="number" step="any" class="form-control">
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label>Espalda (cm)</label>
                <input name="espalda" type="number" step="any" class="form-control">
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label>Busto (cm)</label>
                <input name="busto" type="number" step="any" class="form-control">
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label>Cintura (cm)</label>
                <input name="cintura" type="number" step="any" class="form-control">
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label>Abdomen (cm)</label>
                <input name="abdomen" type="number" step="any" class="form-control">
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label>Muslo (cm)</label>
                <input name="muslo" type="number" step="any" class="form-control">
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-md-2 col-lg-2">
                <label>Brazo (cm)</label>
                <input name="brazo" type="number" step="any" class="form-control">
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" value="Submit" class='glyphicon glyphicon-ok btn btn-actualizaServ' > </button>
            </div>
        </div>
    </form>


    <table class="table .table-striped table-responsive">
        <tbody>
            <?php
            $numServ= 0
            ?>
            @foreach($cliente->getMedidas($cliente->id) as $servicios)
                <?php
                    $numMed = 0;
                    $numServ = $numServ + 1
                ?>
                <tr class="silver">
                    <th colspan="12" class="center" scope="colgroup">

                    </th>
                </tr>
                <tr class="estatusServicio_{{$servicios[0]->estatus}}">
                    <th rowspan="{{count($servicios)+3}}" colspan="0" class="center">
                        {{$numServ}}
                    </th>


                        <th colspan="10" class="center" scope="colgroup">

                        Estatus: {{$servicios[0]->estatus}}
                        @if($servicios[0]->alimentacion)
                            <span class="hidden-xs center">
                                |
                            </span>
                          <span class="hidden-sm hidden-md hidden-lg hidden-xl center">
                                <br>
                            </span>
                            <label class="control-label">Sigue Alimentación</label>
                        @endif
                        @if($servicios[0]->postParto)
                            <span class="hidden-xs center">
                                |
                            </span>
                            <span class="hidden-sm hidden-md hidden-lg hidden-xl center">
                                <br>
                            </span>
                            <label class="control-label">Durante Postparto</label>
                        @endif
                        @if($servicios[0]->valoracion)
                            <span class="hidden-xs center">
                            |
                        </span>
                            <span class="hidden-sm hidden-md hidden-lg hidden-xl center">
                            <br>
                        </span>
                            <label class="control-label">Valoracion</label>
                        @endif
                    </th>

                    <th rowspan="{{count($servicios)+3}}" colspan="0" class="center">
                    </th>
                </tr>
                <tr>
                    <th class="center">#</th>
                    <th class="center">Fecha</th>
                    <th class="hidden-xs center">Peso</th>
                    <th class="hidden-sm hidden-md hidden-lg hidden-xl ">Medidas</th>
                    <th class="hidden-xs center">Espalda</th>
                    <th class="hidden-xs center">Busto</th>
                    <th class="hidden-xs center">Cintura</th>
                    <th class="hidden-xs center">Abdomen</th>
                    <th class="hidden-xs center">Muslo</th>
                    <th class="hidden-xs center">Brazo</th>
                </tr>
                @foreach($servicios as $medidaAux)
                    <?php
                        $numMed = $numMed + 1
                    ?>
                    <form method='POST' action='/servicio/guardar'>
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="medidaId" value="{{$medidaAux->servicio->id}}">

                    <tr class="vendas_{{$medidaAux->vendas}}">
                        <td>{{$numMed}}</td>
                        <td >{{$medidaAux->fecha}}</td>
                        <td align="left">

                            <span class="hidden-xs center">
                                {{$medidaAux->peso}}
                            </span>
                            <span class="hidden-sm hidden-md hidden-lg hidden-xl">
                                Peso: {{$medidaAux->espalda}}
                                <br> Espalda: {{$medidaAux->espalda}}
                                <br> Busto: {{$medidaAux->busto}}
                                <br> Cintura: {{$medidaAux->cintura}}
                                <br> Abdomen: {{$medidaAux->abdomen}}
                                <br> Muslo: {{$medidaAux->muslo}}
                                <br> Brazo: {{$medidaAux->brazo}}
                            </span>

                        </td>
                        <td class="hidden-xs">{{$medidaAux->espalda}}</td>
                        <td class="hidden-xs">{{$medidaAux->busto}}</td>
                        <td class="hidden-xs">{{$medidaAux->cintura}}</td>
                        <td class="hidden-xs">{{$medidaAux->abdomen}}</td>
                        <td class="hidden-xs">{{$medidaAux->muslo}}</td>
                        <td class="hidden-xs">{{$medidaAux->brazo}}</td>
                    </tr>
                    </form>

                @endforeach
                <tr class="estatusServicio_{{$servicios[0]->estatus}}">
                    <th colspan="2" class="hidden-sm hidden-md hidden-lg hidden-xl " scope="colgroup">
                                  Medidas: {{count($servicios)}}
                                <br> Citas: {{$servicios[0]->numCitasTomadas+$servicios[0]->numCitasPerdidas+$servicios[0]->numCitasAgendadas}}/{{$servicios[0]->numCitas}}
                        <br> Agendadas: {{$servicios[0]->numCitasAgendadas}}
                    </th>
                    <th colspan="1" class="hidden-sm hidden-md hidden-lg hidden-xl" scope="colgroup">
                        F. Inicio: {{$servicios[0]->fechaInicio}}
                        <br> F. Fin: {{$servicios[0]->fechaFin}}
                        <br> F. Pago: {{$servicios[0]->fechaPago}}
                    </th>
                    <th colspan="1" class="hidden-xs center" scope="colgroup">
                        Medidas: {{count($servicios)}}
                    </th>
                    <th colspan="1" class=" hidden-xs" scope="colgroup">
                        Citas: {{$servicios[0]->numCitasTomadas+$servicios[0]->numCitasPerdidas+$servicios[0]->numCitasAgendadas}}/{{$servicios[0]->numCitas}}
                    </th>
                    <th colspan="1" class=" hidden-xs" scope="colgroup">
                        Agendadas: {{$servicios[0]->numCitasAgendadas}}
                    </th>

                    <th colspan="2" class=" hidden-xs" scope="colgroup">
                        F. Inicio: {{$servicios[0]->fechaInicio}}
                    </th>
                    <th colspan="2" class=" hidden-xs" scope="colgroup">
                        F. Fin: {{$servicios[0]->fechaFin}}
                    </th>
                    <th colspan="2" class=" hidden-xs" scope="colgroup">
                        F. Pago: {{$servicios[0]->fechaPago}}
                    </th>

                </tr>
            @endforeach
        </tbody>
    </table>
