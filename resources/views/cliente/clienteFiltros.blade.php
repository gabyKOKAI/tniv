<div>
	<div class="row">
		<div class="hidden-xs col-sm-1">
		</div>
		<div class="col-xs-12 col-sm-10" align-center">
                <form method='POST' action='/clientes'>
                    <?php echo e(csrf_field()); ?>
                    <div class="form-group control-label col-xs-12 col-sm-6 offset-sm-2">
                        <label class="control-label" for='nombre'>Nombre</label>
                        <input class="form-control" type="text" name="nombre" value='{{ app('request')->input('nombre') }}'>
                        <input class="form-control" type='submit' value='Buscar' class='btn btn-filtro letraNormal'>
                    </div>
                </form>
            @if(count($estatusForDropdown)>1)
                <div class="col-xs-0 col-sm-3" align="center">
                </div>
                <div class="col-xs-12 col-sm-6" align="center">
                    <!--div class="hidden-xs col-sm-3 align-self-center">
                        <br class="hidden-xs">
                        <label for='estatus'>Estatus:</label>
                    </div-->
                    <div class="col-xs-6 col-sm-4 align-self-center">
                        <form method='POST' action='/clientes'>
                            <?php echo e(csrf_field()); ?>
                            <input type="hidden" name="estatus" value="all">
                            @if( $estatusSelected != "all")
                                <input type='submit' value='Todos' class='btn btn-filtro'>
                            @else
                                    <input type='submit' value='Todos' class='btn btn-filtroSelected'>
                            @endif
                        </form>
                    </div>
                    @foreach($estatusForDropdown as $estatus)
                        <!--option value="{{ $estatus }}" {{ $estatus == $estatusSelected ? 'selected="selected"' : '' }}> {{ $estatus }} </option-->
                        <div class="col-xs-6 col-sm-4 align-self-center">
                            <form method='POST' action='/clientes'>
                                <?php echo e(csrf_field()); ?>
                                <input type="hidden" name="estatus" value="{{ $estatus }}">
                                @if( $estatusSelected != $estatus)
                                    <input type='submit' value='{{ $estatus }}' class='btn btn-filtro'>
                                @else
                                    <input type='submit' value='{{ $estatus }}' class='btn btn-filtroSelected' disabled>
                                @endif
                            </form>
                        </div>
                    @endforeach
                    <!--/select-->
                </div>
            @endif
        </div>
    </div>
</div>
