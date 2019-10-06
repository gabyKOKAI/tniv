<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use Session;

class Cliente extends Model
{
    protected $table = 'clientes';

    public static function getEstatusDropDown()
    {
        $estatus = ['Activo', 'ClienteNuevo', 'Inactivo', 'Terminado', 'SinServicios'];
        return $estatus;
    }

    public static function getClientes()
    {
        $clientes = Cliente::join('sucursalesUsuarios', 'clientes.user_id', '=', 'sucursalesUsuarios.usuario_id')
            ->select('clientes.id', 'clientes.nombre', 'clientes.numCliente', 'clientes.correo', 'sucursalesUsuarios.estatus', 'clientes.estatus','clientes.user_id')
            ->where('sucursalesUsuarios.sucursal_id', '=', Session::get('sucursalSession')->id)
            ->where('sucursalesUsuarios.estatus', '=', 1);
        $queries = [];

        if(request()->has("estatus") and request("estatus")!= 'all' and request("estatus")!= ''){
            $clientes = $clientes->where("clientes.estatus",'=',request("estatus"));
                $queries["estatus"] = request("estatus");
        }

        if(request()->has("nombre") and request("nombre")!= 'all' and request("nombre")!= ''){
            $clientes = $clientes->where("clientes.nombre",'like', "%".request("nombre")."%");
            $queries["nombre"] = request("nombre");
        }

        if(request()->has("correo") and request("correo")!= 'all' and request("correo")!= ''){
            $clientes = $clientes->where("clientes.correo",'like', "%".request("correo")."%");
            $queries["correo"] = request("correo");
        }

		$clientes = $clientes->paginate(15,['*'], 'clientes_p')->appends($queries);

        return $clientes;
    }

    public static function getNumServicio($id = -1){
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($id);
                if($cliente){
                    return 1; #GOP falta obterner el numero de servicios
                }else{
                    return 0;
                }
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
                return 1; #GOP falta obterner el numero de servicios
            }
        }else{
            return 0;
        }


    }
}
