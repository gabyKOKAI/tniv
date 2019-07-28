<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Hora;

class HoraController extends Controller
{
    public function abrirCerrarHora(Request $request)
    {
        $hora = Hora::find($request['hora']);

        # Set the parameters
        if($hora    ->estatus == 1){
            $hora->estatus = 0;
            #GOP checar que no haya citas para poder cerrarlo
            $res = "cerró";
        }
        else{
            $hora->estatus = 1;
            $res = "abrió";
        }

        $hora->save();

        return redirect('/dia/'.$hora->dia_id);
        #->with('success', 'Se '.$res.' la hora '.$hora->hora)->withInput();
	 }
}
