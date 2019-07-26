<div>
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6 align-center">
            <form method='POST' action='/mesesP'>
                <?php echo e(csrf_field()); ?>

                @if(count($anosForDropdown)>1)
                <div class="col-sm-4 form-group control-label" align="left">
                    <label for='ano'>Año</label>
                        <select name="ano"  class="form-control">
                        <option value="all" selected="selected">Todos</option>
                        @foreach($anosForDropdown as $ano1)
                            <option value="{{ $ano1->ano }}" {{ $ano1->ano == $anoSelected ? 'selected="selected"' : '' }}>{{$ano1->ano}}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(count($mesesForDropdown)>1)
                <div class="col-sm-4 form-group control-label" align="center">
                    <label for='mes'>Mes</label>
                        <select name="mes"  class="form-control">
                        <option value="all" selected="selected">Todos</option>
                        @foreach($mesesForDropdown as $mes1)
                            <?php
                                setlocale(LC_TIME, 'es_ES');
                                $fecha = DateTime::createFromFormat('!m', $mes1->mes);
                                $mes2 = strftime("%B", $fecha->getTimestamp()); // marzo
                            ?>
                            <option value="{{ $mes1->mes }}" {{ $mes1->mes == $mesSelected ? 'selected="selected"' : '' }}>{{ $mes2 }} </option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(count($sucursalesForDropdown)>1)
                <div class="col-sm-4 form-group control-label" align="center">
                    <label for='sucursal'>Sucursales</label>
                        <select name="sucursal_id"  class="form-control">
                        <option value="all" selected="selected"> Todas </option>
                        @foreach($sucursalesForDropdown as $sucursale1)
                            <option value="{{ $sucursale1->id }}" {{ $sucursale1->id == $sucursaleSelected ? 'selected="selected"' : '' }}> {{ $sucursale1->nombre }} </option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(count($estatusForDropdown)>1)
                <div class="col-sm-4 form-group control-label" align="center">
                    <label for='estatus'>Estatus</label>
                    <select name="estatus"  class="form-control">
                    <option value="all" selected="selected"> Todos </option>
                    @foreach($estatusForDropdown as $estatus)
                        <option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option>
                    @endforeach
                    </select>
                </div>
                @endif

                <div class="col-sm-12 align-self-center">
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                    </form>
                </div>

                <!--div class="col-sm-2 align-self-center">
                    <br>
                    <form method='GET' action='/meses'>
                        <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                    </form>
                </div-->

        </div>
    </div>

</div>
