<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Hora;
use tniv\Dia;
use tniv\Mese;
use tniv\Sucursale;
use DateTime;

class DiaController extends Controller
{
    public function dia(Request $request,$id= '-1') {
	    $dia = Dia::find($id);

        # Get estatus
        $estatusForDropdown = Dia::getEstatusDropDown();

        $estatusSelected = request('estatus');

        $mes = Mese::where('id', 'LIKE', $dia->mes_id)->first();
        $sucursal = Sucursale::where('id','LIKE',$mes->sucursal_id)->first();

        if($dia and Sucursale::verificaSucursal($mes->sucursal_id)){
            $estatusSelected = $dia->estatus;
            $horasDia = Hora::where('dia_id', 'LIKE', $id)->get();
        }
        else{
            $dia = new Dia;
            $dia->id = -1;
            $horasDia = [];
        }

        return view('dia.dia')->
        with([  'dia' => $dia,
                'mes'=> $mes,
                'sucursal'=> $sucursal,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected,
                'horasDia'=>$horasDia
                ]);
	}

	public function diaVecino(Request $request,$dir,$id= '-1') {
	    $dia = Dia::find($id);

	    if($dir == 'a'){
	        $res = 'anterior';
            $numDia = $dia->numDia - 1;
        }elseif($dir == 'd'){
	        $res = 'siguiente';
            $numDia = $dia->numDia + 1;
	    }

	    $diaNew = Dia::where('mes_id','=',$dia->mes_id)->where('numDia','=',$numDia)->first();

        if($diaNew){
            return redirect('/dia/'.$diaNew->id);
            #->with('info', 'Se muestra el dia '.$res);
        }
        else{
            return redirect('/dia/'.$dia->id)->with('warning', 'No se puede mostrar el dia '.$res.' porque no existe.');
        }
	}

	public function diaActual(Request $request,$idSuc= '-1') {
	    if($idSuc == '-1'){
	        # Get sucursales
            $sucursales = Sucursale::getSucursales();
            if(count($sucursales)>1){
	            return view('sucursal.sucursalDia')->with(['sucursales' => $sucursales]);
	        }else{
	            $idSuc = $sucursales->first()->id;
	        }
	    }

        $fecha = new DateTime();
        $ano = strftime("%Y", $fecha->getTimestamp());
        $mes = strftime("%m", $fecha->getTimestamp());
        $dia = strftime("%d", $fecha->getTimestamp());

	    $mes = Mese::where('sucursal_id','=',$idSuc)->where('mes','=',$mes)->where('ano','=',$ano)->first();


	    if($mes){
	        $dia = Dia::where('mes_id','=',$mes->id)->where('numDia','=',$dia)->first();
            return redirect('/dia/'.$dia->id);
            #->with('info', 'Se muestra el mes actual.');
        }else{
            return redirect('/mes/-1')->with('info', 'El mes no se ha creado, favor de crearlo.');
        }
	}

    public function abrirCerrarDia(Request $request, $tipo)
    {
        $dia = Dia::find($request['dia']);

        # Set the parameters
        if($dia->estatus == 1){
            $dia->estatus = 0;
            #GOP checar que no haya citas para poder cerrarlo
            $res = "cerró";
        }
        else{
            $dia->estatus = 1;
            $res = "abrió";
        }

        $dia->save();

        if($tipo == "Mes"){
            return redirect('/mes/'.$request['mes']);
            #->with('success', 'Se '.$res.' el dia '.$dia->numDia)->withInput();
        }
        else{
            return redirect('/dia/'.$dia->id)->with('success', 'Se '.$res.' el dia '.$dia->numDia)->withInput();
        }
	 }
}
