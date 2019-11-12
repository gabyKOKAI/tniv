<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    public function medidas()
    {
        return $this->hasMany('\tniv\Medida');
    }

    public function cliente()
    {
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Cliente');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Inactivo', 'Pagado', 'Iniciado', 'Terminado', 'Suspendido'];
        return $estatus;
    }

    public static function getServicios($idCliente)
    {
        $res = [];
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }

            if($cliente){
                $servicios = Servicio::where('cliente_id','=',$cliente->id)->get();
                $res = $servicios->sortByDesc('fechaInicio');
            }
         }
        return $res;
    }

}
