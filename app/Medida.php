<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    public function servicio()
    {
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Servicio');
    }

    public static function getMedidas($idCliente)
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

            $medidas = Medida::join('servicios', 'medidas.servicio_id', '=', 'servicios.id')
                ->where('cliente_id','=',$cliente->id)
                ->get()
                ->sortByDesc('fecha')
                ->groupBy('id');
                #dd($medidas);

                #dd($medidas);

                $res = $medidas->sortByDesc('fecha');
            }
         }
        return $res;
    }
}
