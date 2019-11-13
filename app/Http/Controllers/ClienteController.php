<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\SucursalesUsuario;
use tniv\Cliente;
use tniv\Servicio;
use tniv\Medida;
use tniv\User;
use tniv\Cita;
use Session;
use Auth;
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

    public function clienteUser(Request $request,$idUser= '-1')
    {
        $cliente = Cliente::where('user_id', '=', $idUser)->first();

        if (!$cliente) {
            return redirect('/')->with('warning', 'No tiene un cliente asociado, pongase en contacto con alguien de la sucursal.');
        } else {
            return $this->cliente($request, 1, $cliente->id);
        }
    }

    public function cliente(Request $request,$pestana='1',$idCliente= '-1') {

        $hiddenInfo = "hidden";
        $hiddenCita = "hidden";
        $hiddenRegi = "hidden";
        $hiddenServ = "hidden";
        $hiddenFoto = "hidden";

        switch ($pestana) {
            case "1":
                $hiddenInfo = "";
                break;
            case "2":
                $hiddenCita = "";
                break;
            case "3":
                $hiddenRegi = "";
                break;
            case "4":
                $hiddenServ = "";
                break;
            case "5":
                $hiddenFoto = "";
                break;
            default:
                $hiddenInfo = "";
        }

        $usuario = auth()->user();
        if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
            $cliente = Cliente::find($idCliente);
        }else{
            $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            if(in_array($usuario->rol, ['Cliente'])) {
                $hiddenServ = "hidden";
            }
            if(in_array($usuario->rol, ['ClienteNuevo'])) {
                $hiddenRegi = "hidden";
                $hiddenCita = "hidden";
            }
        }

        # Get estatus
        $estatusForDropdown = Cliente::getEstatusDropDown();
        $estatusSelected = request('estatus');

        $estatusServForDropdown = Servicio::getEstatusDropDown();
        $estatusServSelected = request('estatusServ');

        $seEnteroForDropdown = Cliente::getSeEnteroDropDown();
        $seEnteroSelected = request('seEntero');

        if($cliente){
            $estatusSelected = $cliente->estatus;
            $usuario = $cliente->user;
        }
        else{
            $cliente = new Cliente;
            $cliente->id = -1;
        }

        $proxCitas = Cita::getProximasCitas($cliente->id);
        $request->session()->put('proxCitas', $proxCitas);
        $numCitas = Cita::getNumCitas($cliente->id);
        $request->session()->put('numCitas', $numCitas);
        $numCitasTomPerAg = Cita::getNumCitasTomPerAg($cliente->id);
        $request->session()->put('numCitasTomPerAg', $numCitasTomPerAg);
        $numCitasPosibles = Cliente::getNumCitasServicio($cliente->id);
        $request->session()->put('numCitasPosibles', $numCitasPosibles);
        $valoracion = Cita::getValoracionTomada($cliente->id);
        $request->session()->put('valoracion', $valoracion);

        $medida = new Medida;

        return view('cliente.cliente')->
        with([  'cliente' => $cliente,
                'estatusForDropdown' => $estatusForDropdown,
                'estatusSelected'=>$estatusSelected,
                'estatusServForDropdown' => $estatusServForDropdown,
                'estatusServSelected'=>$estatusServSelected,
                'seEnteroForDropdown' => $seEnteroForDropdown,
                'seEnteroSelected'=>$seEnteroSelected,
                'usuario' => $usuario,
                'hiddenInfo' => $hiddenInfo,
                'hiddenCita' => $hiddenCita,
                'hiddenRegi' => $hiddenRegi,
                'hiddenServ' => $hiddenServ,
                'hiddenFoto' => $hiddenFoto,
                'medida' => $medida
                ]);
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
            return redirect('/cliente/'.$cliente->id)->with('warning', 'El cliente '.$cliente->correo.' ya esta creado, si no puedes verlo pertenece a otra sucursal y debes comunicarte con el administrador.');
        }
        else{
            # Set the parameters
            $cliente->numCliente = $request->input('numCliente');
            $cliente->nombre = $request->input('nombre');
            $cliente->correo = $request->input('correo');
            if($request->input('estatus')){
                $cliente->estatus = $request->input('estatus');
            }
            $cliente->telefono1 = $request->input('telefono1');
            $cliente->telefono2 = $request->input('telefono2');
            $cliente->fechaNacimiento = $request->input('fechaNacimiento');
            $cliente->altura = $request->input('altura');
            if($request->input('correoAgendar')){
                $cliente->correoAgendar = 1;
            }else{
                $cliente->correoAgendar = 0;
            }
            if($request->input('correoCancelar')){
                $cliente->correoCancelar = 1;
            }else{
                $cliente->correoCancelar = 0;
            }

            $cliente->seEntero = $request->input('seEntero');


            $usuario = User::where('email', 'LIKE', $request['correo'])->first();
            if (!$usuario) {
                $usuario = new User;
                $res1 = "creado";
                #$usuario->password = 'TEPORALkokai123456.!*';
                $usuario->email = $request->input('correo');
                $usuario->rol = "";
            }else{
                $res1 = "actualizado";
            }

                # Set the parameters
                $usuario->name = $request->input('nombre');


                if(!in_array($usuario->rol,['Master', 'Admin', 'AdminSucursal'])){
                    if(in_array($cliente->estatus, ['Activo', 'Terminado'])){
                        $usuario->rol = 'Cliente';
                    }elseif(in_array($cliente->estatus, ['Inactivo'])){
                        #$usuario->password = 'TEPORALkokai123456.!*?';
                        $usuario->rol = 'Inactivo';
                    }elseif(in_array($cliente->estatus, ['ClienteNuevo', 'SinServicios'])){
                        $usuario->rol = 'ClienteNuevo';
                    }
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
            return redirect('/cliente/1/'.$cliente->id)->with('success', 'El cliente '.$cliente->nombre.' fue '.$res);
        }else{
            return redirect('/cliente/1/'.$cliente->id)->with('success', 'Tu perfil fue '.$res);
        }
    }

    public function aceptoCondiciones(Request $request) {
        $cliente = Cliente::where('user_id','=',$request->input('user_id'))->first();

        # Set the parameters
        $cliente->aceptoCondiciones = 1;
        $cliente->save();

        return redirect('/cliente/1/'.$cliente->id)->with('success', 'Aceptaste las condiciones de Contrato y de servicio, favor de solicitar en sucursal que lo activen.');
    }
}
