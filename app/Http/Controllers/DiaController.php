<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Hora;
use tniv\Dia;
use tniv\Mese;
use tniv\Sucursale;
use tniv\Cita;
use tniv\Cliente;
use DateTime;
use Session;
date_default_timezone_set("America/Mexico_City");

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
            foreach ($horasDia as $hora){
                $hora->citas = Cita::where('hora_id','=',$hora->id)->get();
                $citasActivas = 0;

                $fecha_actual = new DateTime("now");
                $fecha_dada = Cita::regresaFechaFormato($hora);
                $hora->pasada = 0;

                if($fecha_actual > $fecha_dada){
                    $hora->pasada = 1;
                }

                foreach ($hora->citas as $cita){
                    $cita->nomCliente = Cliente::find($cita->cliente_id)->nombre;

                    $fecha_actual = new DateTime("now");
                    $fecha_dada = Cita::regresaFechaFormato($hora);
                    $cita->pasada = 0;

                    if($fecha_actual > $fecha_dada){
                        $cita->pasada = 1;
                    }

                    if(in_array($cita->estatus, ['Agendada','Tomada','Perdida'])){
                        $citasActivas = $citasActivas + 1;
                    }
                }
                $hora->citasActivas  = $citasActivas;
            }
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
            Session::flash('message', 'Se muestra el dia '.$res);
            return redirect('/dia/'.$diaNew->id);
            #->with('info', 'Se muestra el dia '.$res);
        }
        else{
            return redirect('/dia/'.$dia->id)->with('warning', 'No se puede mostrar el dia '.$res.' porque no existe.');
        }
	}

	public function diaActual(Request $request) {
        $fecha = new DateTime();
        $ano = strftime("%Y", $fecha->getTimestamp());
        $mes = strftime("%m", $fecha->getTimestamp());
        $dia = strftime("%d", $fecha->getTimestamp());

	    $mes = Mese::where('sucursal_id','=',Session::get('sucursalSession')->id)->where('mes','=',$mes)->where('ano','=',$ano)->first();


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
            #al cerrar el dia el cliente no puede agendar,
            #pero no se eliminan las citas previamente agendadas
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
