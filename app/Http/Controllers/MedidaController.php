<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Medida;
use tniv\Cliente;
use tniv\Servicio;
use tniv\User;

class MedidaController extends Controller
{

    public function guardar(Request $request) {
        $medida = Medida::find($request->input('medida_id'));

        $servicio = Servicio::where('cliente_id','=',$request->input('cliente_id'))
        ->where('estatus','=','Iniciado')->first();

        if(!$servicio){
            return redirect('/cliente/3/'.$request->input('cliente_id'))->with('error', 'No tiene un servicio iniciado, por lo que no puedes registrar medidas. Favor de contactar al equipo vint');
        }else{
            if (!$medida) {
                # Instantiate a new Model object
                $medida = new Medida();
                $res = "registrada";

             } else {
                $res = "actualizado";
            }

            # Set the parameters
            $medida->fecha = $request->input('fecha');

            if($request->input('vendas')){
                $medida->vendas = 1;
            }else{
                $medida->vendas = 0;
            }

            $medida->peso = $request->input('peso');
            $medida->espalda = $request->input('espalda');
            $medida->busto = $request->input('busto');
            $medida->cintura = $request->input('cintura');
            $medida->abdomen = $request->input('abdomen');
            $medida->muslo = $request->input('muslo');
            $medida->brazo = $request->input('brazo');
            $medida->servicio_id = $servicio->id;

            $medida->save();

            return redirect('/cliente/3/'.$request->input('cliente_id'))->with('success', 'La medida fue '.$res);
        }
    }
}
