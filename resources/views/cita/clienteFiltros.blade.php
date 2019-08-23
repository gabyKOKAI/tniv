<div>
    <div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10 align-center">

            <form method='POST' action='/agendarCitaACliente'>
                <?php echo e(csrf_field()); ?>
                <input type="hidden" name="hora" value="{{$hora->id}}">
                <input type="hidden" name="estatus" value="Activo">


                <div class="col-sm-4 form-group control-label" align="center">
                        <label for='estatus'>Nombre:</label>
                        <input type="text" name="nombre" value='{{ app('request')->input('nombre') }}'>
                </div>
                <div class="col-sm-4 form-group control-label" align="center">
                    <label for='correo'>Correo:</label>
                    <input type="text" name="correo" value='{{ app('request')->input('correo') }}'>
                </div>
                <div class="col-sm-1 form-group control-label" align="center">
                    <input type='submit' value='Filtrar' class='btn btn-primary btn-small'>
                </div>
            </form>
                <!--div class="col-sm-2 align-self-center">
                    <br>
                    <form method='GET' action='/meses'>
                        <input type='submit' value='Limpiar Filtros' class='btn btn-primary btn-small'>
                    </form>
                </div-->

        </div>
    </div>

</div>
