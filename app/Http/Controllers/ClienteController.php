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
        # Get sucursales
        $sucursalesForDropdown = Sucursale::all();
        #dd($sucursalesForDropdown);

        #Poner valores anteriores en selecciones
        $estatusSelected = request('estatus');
        $sucursaleSelected = request('sucursale_id');

		return view('cliente.clienteLista')->
		with([  'clientes' => $clientes,
		        'sucursalesForDropdown' => $sucursalesForDropdown,
		        'sucursaleSelected'=>$sucursaleSelected,
		        'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected]);

    }

    public function cliente(Request $request,$id= '-1') {
	    $cliente = Cliente::find($id);

	    # Get sucursales
        $sucursalesForDropdown = Sucursale::all();
        # Get estatus
        $estatusForDropdown = Cliente::getEstatusDropDown();

        $sucursaleSelected = request('sucursale_id');
        $estatusSelected = request('estatus');

        if($cliente){
            $sucursaleSelected = $cliente->sucursale_id;
            $estatusSelected = $sucursal->estatus;
        }
        else{
            $cliente = new Cliente;
            $cliente->id = -1;
        }

        return view('cliente.cliente')->
        with([  'cliente' => $cliente,
                'sucursalesForDropdown' => $sucursalesForDropdown,
                'sucursaleSelected'=>$sucursaleSelected,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected,
                ]);
	}
}
