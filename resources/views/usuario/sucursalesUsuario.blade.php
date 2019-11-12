{{ $sucursalesForDropdown =  tniv\Sucursale::getSucursales() }}
@if(count($sucursalesForDropdown)>1)
    <div class="col-sm-12 " align="center">
        <br>
    </div>
    <div class="col-sm-12 tituloTablaCitas" align="center">

        Sucursales
    </div>
    <div class="col-sm-12 form-group control-label" align="left">
        @foreach($sucursalesForDropdown as $sucursal)
            <div class=" col-xs-12 col-sm-3 col-md-2 form-group control-label" align="center">
            <?php $estatusSucUsu = tniv\SucursalesUsuario::getSucursalesUsuario($usuario->id, $sucursal->id) ?>
            <form method='POST' action='/modificaEstatusSucUsu'>
               {{ csrf_field() }}
               <input type="hidden" name="sucursal" value="{{$sucursal->id}}">
               <input type="hidden" name="usuario" value="{{$usuario->id}}">
               @if($estatusSucUsu == 1)
                    <input type='submit' value='{{$sucursal->nombre}}' class='btn btn-sucPermitida'>
               @else
                    <input type='submit' value='{{$sucursal->nombre}}' class='btn btn-sucNoPermitida'>
               @endif
            </form>
            </div>
        @endforeach
</div>
@endif

