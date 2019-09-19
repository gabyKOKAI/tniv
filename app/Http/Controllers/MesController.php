<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\Mese;
use tniv\Dia;
use tniv\Hora;
use DateTime;
use Session;
setlocale(LC_TIME, 'es_ES');

class MesController extends Controller
{
    public function lista(Request $request, $ano=-1)
    {
        #Parametros por defecto en la lista
        #if(!request()->has('estatus')){
            #$request['estatus'] = "Abierto";
        #}
        if($ano != -1){
            $request['ano'] = $ano;
            $request['estatus'] = "all";
        }
    	$meses = Mese::getMeses();

        # Get anos
        $anosForDropdown = Mese::distinct()->get(['ano']);
        # Get meses
        $mesesForDropdown = Mese::distinct()->get(['mes']);
        #dd($mesesForDropdown);
        # Get estatus
        $estatusForDropdown = Mese::getEstatusDropDown();

        #Poner valores anteriores en selecciones

        $anoSelected = request('ano');
        $mesSelected = request('mes');
        $estatusSelected = request('estatus');

		return view('mes.mesLista')->
		with([  'meses' => $meses,
		        'anosForDropdown' => $anosForDropdown,
		        'anoSelected'=>$anoSelected,
		        'mesesForDropdown' => $mesesForDropdown,
		        'mesSelected'=>$mesSelected,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected]);
    }

    public function mes(Request $request,$id= '-1') {
	    $mes = Mese::find($id);

        # Get estatus
        $estatusForDropdown = Mese::getEstatusDropDown();

        $estatusSelected = request('estatus');

        $sucSes = Session::get('sucursalSession')->id;
        if($mes and Sucursale::verificaSucursal($mes->sucursal_id) and $sucSes  == $mes->sucursal_id){
            $estatusSelected = $mes->estatus;
            $diasMes = Dia::where('mes_id', 'LIKE', $id)->get();
        }
        else{
            $mes = new Mese;
            $mes->id = -1;
            $mes->ano = Date('Y');
            $mes->mes = Date('m');
            $diasMes = [];
        }


        return view('mes.mes')->
            with([  'mes' => $mes,
                    'estatusForDropdown' => $estatusForDropdown,
                    'estatusSelected'=>$estatusSelected,
                    'diasMes'=>$diasMes
                    ]);
	}

	public function mesVecino(Request $request,$dir,$id= '-1') {
	    $mes = Mese::find($id);
	    $ano = $mes->ano;

	    if($dir == 'a'){
	        $res = 'anterior';

	        if($mes->mes == 1){
	            $numMes = 12;
	            $ano = $ano -1;
            }else{
                $numMes = $mes->mes - 1;
            }
        }elseif($dir == 'd'){
	        $res = 'siguiente';

	        if($mes->mes == 12){
	            $numMes = 1;
	            $ano = $ano + 1;
            }else{
                $numMes = $mes->mes + 1;
            }
	    }
	    $mesNew = Mese::where('sucursal_id','=',$mes->sucursal_id)->where('mes','=',$numMes)->where('ano','=',$ano)->first();

        if($mesNew){
            return redirect('/mes/'.$mesNew->id);
            #->with('info', 'Se muestra el mes '.$res);
        }
        else{
            return redirect('/mes/'.$mes->id)->with('warning', 'No se puede mostrar el mes '.$res.' porque no existe, favor de crearlo.');
        }
	}

    public function anoActual(Request $request) {
        $fecha = new DateTime();
        $ano = strftime("%Y", $fecha->getTimestamp());
        return redirect('/meses/'.$ano);
	}

	public function mesActual(Request $request) {
        $fecha = new DateTime();
        $ano = strftime("%Y", $fecha->getTimestamp());
        $mes = strftime("%m", $fecha->getTimestamp());
	    $mes = Mese::where('sucursal_id','=', Session::get('sucursalSession')->id)->where('mes','=',$mes)->where('ano','=',$ano)->first();

	    if($mes){
            return redirect('/mes/'.$mes->id);
            #->with('info', 'Se muestra el mes actual.');
        }else{
            return redirect('/mes/-1')->with('info', 'El mes no se ha creado, favor de crearlo.');
        }
	}

	public function guardar(Request $request,$id) {
	    setlocale(LC_TIME, 'es_ES');
        $mes = Mese::find($id);

        if (!$mes) {
            $mes = Mese::where('mes', 'LIKE', $request['mes'])->where('ano', 'LIKE', $request['ano'])->where('sucursal_id', 'LIKE', Session::get('sucursalSession')->id)->first();
            if (!$mes) {
                # Instantiate a new Model object
                $mes = new Mese();
                $res = "creado";
            }else{
                $res = "ya existe";
            }
         } else {
            $res = "actualizado";
        }

        if($res == "ya existe"){
            setlocale(LC_TIME, 'es_ES');
            $fecha = DateTime::createFromFormat('!m', $mes->mes);
            $mes2 = strftime("%B", $fecha->getTimestamp());
            return redirect('/mes/'.$mes->id)->with('warning', 'El mes '.$mes2.' del '.$mes->ano.' ya estaba creado para la sucursal');
        }
        else{
            # Set the parameters
            $mes->mes = $request->input('mes');
            $mes->ano = $request->input('ano');
            $mes->estatus = $request->input('estatus');

            $sucursal = Sucursale::find(Session::get('sucursalSession')->id);
            $mes->sucursal()->associate($sucursal); # <--- Associate sucursal with this mes

            $mes->save();

            if($res == "creado"){
                foreach (range(1, 31, 1) as $dia1){
                    $formato = 'd-m-Y';
                    $mesNuevo = DateTime::createFromFormat($formato, $dia1.'-'.$mes->mes.'-'.$mes->ano)->format('m');
                    if($mesNuevo==$mes->mes){
                        $this->crearDia($dia1, $sucursal, $mes);
                    }
                }
            }

            setlocale(LC_TIME, 'es_ES');
            $fecha = DateTime::createFromFormat('!m', $mes->mes);
            $mes2 = strftime("%B", $fecha->getTimestamp());

            #return view('layouts.prueba');
            # Redirect the user to the page to view
            return redirect('/mes/'.$mes->id)->with('success', 'El mes '.$mes2.' fue '.$res);
        }
	}

	public function crearDia($dia1, $sucursal, $mes) {
        # Instantiate a new Model object
        $dia = new Dia();


        # Set the parameters
        $dia->numDia = $dia1;
        setlocale(LC_TIME, 'es_ES');
        $formato = 'd-m-Y';
        #$diaSemana = DateTime::createFromFormat($formato, $dia->numDia.'-'.$mes->mes.'-'.$mes->ano)->format('l');
        #setlocale(LC_TIME, 'es_ES.UTF8'); ##GOP ojo cambiar en produccion
        setlocale(LC_TIME, 'es_ES');
        $fecha = DateTime::createFromFormat($formato, $dia->numDia.'-'.$mes->mes.'-'.$mes->ano);
        $dia->diaSemana = strftime("%A", $fecha->getTimestamp());
        if($dia->diaSemana == "sábado" or $dia->diaSemana == "domingo"){
            $dia->estatus = 0;
        }else{
            $dia->estatus = 1;
        }
        $dia->mes_id = $mes->id;

        $dia->mes()->associate($mes);

        $dia->save();





        $start = new \DateTime($sucursal->horaInicio);
        $end = new \DateTime($sucursal->horaFin);
        $start = $start->sub(new \DateInterval('PT30M'));
        while($start < $end){
            $hr = $start->add(new \DateInterval('PT30M'));
            $this->crearHora($hr, $sucursal,$dia);
        }

        return true;
	}

	public function crearHora($hr, $sucursal,$dia) {

        # Instantiate a new Model object
        $hora = new Hora();

        # Set the parameters
        $hora->hora = $hr->format('H:i:s');
        $hora->numCitasMax = $sucursal->numCitasMax;
        $hrComida = new \DateTime($sucursal->horaComida);
        $hrComida2 = new \DateTime($sucursal->horaComida);
        $hrComida2 = $hrComida2->add(new \DateInterval('PT30M'));

        if($hr == $hrComida or $hr == $hrComida2){
            $hora->estatus = 0;
        }else{
            $hora->estatus = 1;
        }
        $hora->dia_id = $dia->id;

        $hora->dia()->associate($dia);

        $hora->save();

        return true;
	}
}
