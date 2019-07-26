<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Dia;

class DiaController extends Controller
{
    public function abrirCerrarDia(Request $request)
    {
        $dia = Dia::find($request['dia']);

        # Set the parameters
        if($dia->estatus == 1){
            $dia->estatus = 0;
            $res = "cerró";
        }
        else{
            $dia->estatus = 1;
            $res = "abrió";
        }

        $dia->save();


        return redirect('/mes/'.$request['mes'])->with('success', 'Se '.$res.' el dia '.$dia->numDia)->withInput();
	 }
}
