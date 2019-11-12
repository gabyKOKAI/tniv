<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use Session;
use tniv\Servicio;

class Cliente extends Model
{
    protected $table = 'clientes';

    public function user()
    {
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\User');
    }

    public function servicios()
    {
        return $this->hasMany('\tniv\Servicio');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Activo', 'ClienteNuevo', 'Inactivo', 'Terminado', 'SinServicios'];
        return $estatus;
    }

    public static function getSeEnteroDropDown()
    {
        $seEnteroLista = ['Facebook', 'Instagram', 'Web', 'Recomendación', 'Twitter', 'Anuncio en Linea', 'Anuncio Papel', 'Otro'];
        return $seEnteroLista;
    }

    public static function getServicios($idCliente)
    {
        return Servicio::getServicios($idCliente);
    }

    public static function getMedidas($idCliente)
    {
        return Medida::getMedidas($idCliente);
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

    public static function getNumCitasServicio($idCliente = -1){
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }

            if($cliente){
                $servicio = Servicio::where('cliente_id','=',$cliente->id)->where('estatus','=','Iniciado')->first();
                if($servicio){
                    return $servicio->numCitas;
                }
                else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public static function getServicioActivo($idCliente = -1)
    {
        $usuario = auth()->user();
        if ($usuario) {
            if (in_array($usuario->rol, ['Master', 'Admin', 'AdminSucursal'])) {
                $cliente = Cliente::find($idCliente);
            } else {
                $cliente = Cliente::where('user_id', '=', $usuario->id)->first();
            }



            if ($cliente) {
                $servicio = Servicio::where('cliente_id', '=', $cliente->id)->where('estatus', '=', 'Iniciado')->first();
                #($servicio->numCitasTomadas+$servicio->numCitasPerdidas)."(t:".$servicio->numCitasTomadas." p:".$servicio->numCitasPerdidas.") de ". $servicio->numCitas." ".$servicio->numCitasAgendadas." agendadas.";
                if(!$servicio){
                    $servicio = new Servicio();
                }
            }else{
                $servicio = new Servicio();
            }
            return $servicio;

        }
    }
}
