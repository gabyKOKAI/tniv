<div>
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8 align-center">
                @if(count($anosForDropdown)>1)

                <div class="col-sm-12 form-group control-label" align="left">
                    <label for='ano'>Año</label>
                        <a href="/meses" class="btn btn-filtro">Todos</a>
                        @foreach($anosForDropdown as $ano1)
                            <a href="/meses/{{$ano1->ano}}" class="btn btn-filtro">{{$ano1->ano}}</a>
                        @endforeach
                    </select>
                </div>
                @endif

        </div>
    </div>

</div>
