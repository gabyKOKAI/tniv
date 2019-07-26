<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Hora;
use tniv\Dia;
use tniv\Mese;
use tniv\Sucursale;

class DiaController extends Controller
{
    public function dia(Request $request,$id= '-1') {
	    $dia = Dia::find($id);

        # Get estatus
        $estatusForDropdown = Dia::getEstatusDropDown();

        $estatusSelected = request('estatus');

        if($dia){
            $estatusSelected = $dia->estatus;
            $horasDia = Hora::where('dia_id', 'LIKE', $id)->get();
        }
        else{
            $dia = new Dia;
            $dia->id = -1;
            $horasDia = [];
        }

        $mes = Mese::where('id', 'LIKE', $dia->mes_id)->first();
        $sucursal = Sucursale::where('id','LIKE',$mes->sucursal_id)->first();

        return view('dia.dia')->
        with([  'dia' => $dia,
                'mes'=> $mes,
                'sucursal'=> $sucursal,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected,
                'horasDia'=>$horasDia
                ]);
	}

    public function abrirCerrarDia(Request $request, $tipo)
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

        if($tipo == "Mes"){
            return redirect('/mes/'.$request['mes'])->with('success', 'Se '.$res.' el dia '.$dia->numDia)->withInput();
        }
        else{
            return redirect('/dia/'.$dia->id)->with('success', 'Se '.$res.' el dia '.$dia->numDia)->withInput();
        }
	 }
}
