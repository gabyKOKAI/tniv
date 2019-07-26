<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\Mese;
use tniv\Dia;

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
            $sucursaleSelected = $mes->sucursale_id;
            $estatusSelected = $mes->estatus;
            $diasMes = Dia::where('mes_id', 'LIKE', $id)->get();
        }
        else{
            $mes = new Mese;
            $mes->id = -1;
            $mes->ano = Date('Y');
            $mes->mes = Date('m');
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
}
