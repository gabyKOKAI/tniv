<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\Mese;
use tniv\Dia;
use DateTime;

class MesController extends Controller
{
    public function lista(Request $request)
    {
        #Parametros por defecto en la lista
        if(!request()->has('estatus')){
            $request['estatus'] = "Abierto";
        }

    	$meses = Mese::getMeses();

        # Get sucursales
        $sucursalesForDropdown = Sucursale::all();
        #dd($sucursalesForDropdown);
        # Get anos
        $anosForDropdown = Mese::distinct()->get(['ano']);
        # Get meses
        $mesesForDropdown = Mese::distinct()->get(['mes']);
        #dd($mesesForDropdown);
        # Get estatus
        $estatusForDropdown = Mese::getEstatusDropDown();

        #Poner valores anteriores en selecciones
        $sucursaleSelected = request('sucursale_id');
        $anoSelected = request('ano');
        $mesSelected = request('mes');
        $estatusSelected = request('estatus');

		return view('mes.mesLista')->
		with([  'meses' => $meses,
		        'sucursalesForDropdown' => $sucursalesForDropdown,
		        'sucursaleSelected'=>$sucursaleSelected,
		        'anosForDropdown' => $anosForDropdown,
		        'anoSelected'=>$anoSelected,
		        'mesesForDropdown' => $mesesForDropdown,
		        'mesSelected'=>$mesSelected,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected]);
    }

    public function mes(Request $request,$id= '-1') {
	    $mes = Mese::find($id);

	    # Get sucursales
        $sucursalesForDropdown = Sucursale::all();
        # Get estatus
        $estatusForDropdown = Mese::getEstatusDropDown();

        $sucursaleSelected = request('sucursale_id');
        $estatusSelected = request('estatus');

        if($mes){
            $sucursaleSelected = $mes->sucursal_id;
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
                'sucursalesForDropdown' => $sucursalesForDropdown,
                'sucursaleSelected'=>$sucursaleSelected,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected,
                'diasMes'=>$diasMes
                ]);
	}

	public function guardar(Request $request,$id) {
	    setlocale(LC_TIME, 'es_ES');
        $mes = Mese::find($id);

        if (!$mes) {
            # Instantiate a new Concepto Model object
            $mes = new Mese();
            $res = "creado";
         } else {
            $res = "actualizado";
        }

        # Set the parameters
        $mes->mes = $request->input('mes');
        $mes->ano = $request->input('ano');
        $mes->estatus = $request->input('estatus');

        $sucursal = Sucursale::find($request->input('sucursal_id'));
        $mes->sucursal()->associate($sucursal); # <--- Associate sucursal with this mes

        $mes->save();

        setlocale(LC_TIME, 'es_ES');
        $fecha = DateTime::createFromFormat('!m', $mes->mes);
        $mes2 = strftime("%B", $fecha->getTimestamp());

        #return view('layouts.prueba');
		# Redirect the user to the page to view
		return redirect('/mes/'.$mes->id)->with('success', 'El mes '.$mes2.' fue '.$res);
	}
}
