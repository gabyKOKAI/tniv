<div>
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8 align-center">
                @if(count($anosForDropdown)>1)

                <div class="col-sm-12 form-group control-label" align="left">
                    <label for='ano'>Año</label>
                            @if($anoSelected=="")
                                <a href="/meses" class="btn btn-filtroSelected">Todos</a>
                            @else
                                <a href="/meses" class="btn btn-filtro">Todos</a>
                            @endif
                        @foreach($anosForDropdown as $ano1)
                            @if($anoSelected==$ano1->ano)
                                <a href="/meses/{{$ano1->ano}}" class="btn btn-filtroSelected">{{$ano1->ano}}</a>
                            @else
                                <a href="/meses/{{$ano1->ano}}" class="btn btn-filtro">{{$ano1->ano}}</a>
                            @endif
                        @endforeach
                    </select>
                </div>
                @endif

        </div>
    </div>

</div>
