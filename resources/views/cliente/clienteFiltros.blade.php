<div>
    <div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10 align-center">


                @if(count($estatusForDropdown)>1)

                <div class="col-sm-12 form-group control-label" align="center">
                    <div class="col-sm-1 align-self-center">
                    <br>
                    <label for='estatus'>Estatus:</label>
                    </div>
                    <!--select name="estatus"  class="form-control">
                    <option value="all" selected="selected"> Todos </option-->
                    <div class="col-sm-1 align-self-center">
                        <form method='POST' action='/clientes'>
                            <?php echo e(csrf_field()); ?>
                            <input type="hidden" name="estatus" value="all">
                            @if( $estatusSelected != "all")
                                <input type='submit' value='Todos' class='btn btn-primary btn-small'>
                            @else
                                <input type='submit' value='Todos' class='btn btn-primary btn-small' disabled>
                            @endif
                        </form>
                    </div>
                    @foreach($estatusForDropdown as $estatus)
                        <!--option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option-->
                        <div class="col-sm-2 align-self-center">
                            <form method='POST' action='/clientes'>
                                <?php echo e(csrf_field()); ?>
                                <input type="hidden" name="estatus" value="{{ $estatus }}">
                                @if( $estatusSelected != $estatus)
                                    <input type='submit' value='{{ $estatus }}' class='btn btn-primary btn-small'>
                                @else
                                    <input type='submit' value='{{ $estatus }}' class='btn btn-primary btn-small' disabled>
                                @endif
                            </form>
                        </div>
                    @endforeach
                    <!--/select-->
                </div>
                @endif

                <!--div class="col-sm-2 align-self-center">
                    <input type='submit' value='Aplicar Filtros' class='btn btn-primary btn-small'>
                </div-->

                <!--div class="col-sm-2 align-self-center">
                    <br>
                    <form method='GET' action='/meses'>
                        <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                    </form>
                </div-->

        </div>
    </div>

</div>
