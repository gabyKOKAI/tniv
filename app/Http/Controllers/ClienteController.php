<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\Cliente;

class ClienteController extends Controller
{
    public function lista(Request $request)
    {
    	#Parametros por defecto en la lista
        if(!request()->has('estatus')){
            $request['estatus'] = "Activo";
        }

        $clientes = Cliente::getClientes();

        # Get estatus
        $estatusForDropdown = Cliente::getEstatusDropDown();

        #Poner valores anteriores en selecciones
        $estatusSelected = request('estatus');

		return view('cliente.clienteLista')->
		with([  'clientes' => $clientes,
		        'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected]);

    }

    public function cliente(Request $request,$id= '-1') {
	    $cliente = Cliente::find($id);

        # Get estatus
        $estatusForDropdown = Cliente::getEstatusDropDown();

        $estatusSelected = request('estatus');

        if($cliente){
            $estatusSelected = $sucursal->estatus;
        }
        else{
            $cliente = new Cliente;
            $cliente->id = -1;
        }

        return view('cliente.cliente')->
        with([  'cliente' => $cliente,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected,
                ]);
	}
}
