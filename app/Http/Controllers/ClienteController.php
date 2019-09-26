<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\Cliente;
use tniv\User;
use Session;
use tniv\Http\Controllers\UsuarioController;

class ClienteController extends Controller
{
    public function lista(Request $request)
    {
    	#Parametros por defecto en la lista
        #if(!request()->has('estatus')){
        #    $request['estatus'] = "Activo";
        #}

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
            $estatusSelected = $cliente->estatus;
        }
        else{
            $cliente = new Cliente;
            $cliente->id = -1;
        }

        return view('cliente.cliente')->
        with([  'cliente' => $cliente,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected
                ]);
	}

	public function clienteUser(Request $request,$id= '-1') {

	    $cliente = Cliente::where('user_id','=',$id)->first();

        if(!$cliente){
            return redirect('/')->with('warning', 'No tiene un cliente asociado, pongase en contacto con alguien de la sucursal.');
        }else{
            return view('cliente.cliente')->
            with([  'cliente' => $cliente
                ]);
        }


	}

	public function guardar(Request $request,$id) {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            $cliente = Cliente::where('correo', 'LIKE', $request['correo'])->first();
            if (!$cliente) {
                # Instantiate a new Model object
                $cliente = new Cliente();
                $res = "creado";
            }else{
                $res = "ya existe";
            }
         } else {
            $res = "actualizado";
        }

        if($res == "ya existe"){
            return redirect('/cliente/'.$cliente->id)->with('warning', 'El cliente '.$cliente->correo.' ya esta creado, si no pudes verlo pertenece a otra sucursal y debes comunicarte con el administrador.');
        }
        else{
            # Set the parameters
            $cliente->nombre = $request->input('nombre');
            $cliente->correo = $request->input('correo');
            $cliente->numCliente = '---';
            if($request->input('estatus')){
                $cliente->estatus = $request->input('estatus');
            }
            $cliente->seEntero = "probando";


            $usuario = User::where('email', 'LIKE', $request['correo'])->first();
            if (!$usuario) {
                $usuario = new User;
                $res1 = "creado";
                #$usuario->password = 'TEPORALkokai123456.!*';
                $usuario->email = $request->input('correo');
            }else{
                $res1 = "actualizado";
            }

                # Set the parameters
                $usuario->name = $request->input('nombre');

                if(in_array($cliente->estatus, ['Activo', 'Terminado'])){
                    $usuario->rol = 'Cliente';
                }elseif(in_array($cliente->estatus, ['Inactivo'])){
                    #$usuario->password = 'TEPORALkokai123456.!*?';
                    $usuario->rol = 'Inactivo';
                }elseif(in_array($cliente->estatus, ['ClienteNuevo', 'SinServicios'])){
                    $usuario->rol = 'ClienteNuevo';
                }
                $usuario->save();

                if($res1 == "creado"){
                    $sucursal = Sucursale::find(Session::get('sucursalSession')->id);
                    $usuarioController = new UsuarioController;
                    $usuarioController->crearSucursalUsuario($usuario, $sucursal, 1);
                }
                $cliente->user_id = $usuario->id;


            $cliente->save();
        }
        if(in_array( auth()->user()->rol, ['Master','Admin','AdminSucursal'])){
            return redirect('/cliente/'.$cliente->id)->with('success', 'El cliente '.$cliente->nombre.' fue '.$res);
        }else{
            return redirect('/clienteUser/'.$usuario->id)->with('success', 'Tu perfil fue '.$res);
        }
    }
}
