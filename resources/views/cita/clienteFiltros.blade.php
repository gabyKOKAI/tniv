<div>
        <div class="hidden-xs col-sm-1">
        </div>
        <div class="col-xs-12 col-sm-10 align-center">
            <form method='POST' action='/agendarCitaACliente'>
                <?php echo e(csrf_field()); ?>
                <input type="hidden" name="hora" value="{{$hora->id}}">
                <input type="hidden" name="estatus" value="Activo">


                <div class="col-xs-12 col-sm-9 form-group control-label center" align="center">
                        <label for='nombre'>Nombre:</label>
                        <input type="text" name="nombre" value='{{ app('request')->input('nombre') }}'>
                        <input type='submit' value='Buscar' class='btn btn-filtro letraNormal'>
                </div>
                <div class="col-xs-12 col-sm-3 form-group control-label" align="center">
                    <span class="hidden-sm hidden-md hidden-lg hidden-xl"><hr></span>
                    <a href="/dia/{{$hora->dia_id}}" class="btn btn-filtro"><span class=" letraNormal glyphicon glyphicon-remove"></span> Regresar</a>
                </div>
                <!--div class="col-xs-4 form-group control-label" align="center">
                    <label for='correo'>Correo:</label>
                    <input type="text" name="correo" value='{{ app('request')->input('correo') }}'>
                </div-->
            </form>
        </div>

</div>
