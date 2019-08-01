<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sucursale extends Model
{
    //protected $dateFormat = 'G:ia';

    public function meses()
    {
        return $this->hasMany('\tniv\Mese');
    }

    public static function all($columns = array('*'))
    {
        return Sucursale::getSucursales();
    }


    public static function getSucursales()
    {
        $sucursales = Sucursale::query();
        $queries = [];

        $columnas = ['nombre'];

        foreach($columnas as $columna){
            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $sucursales = $sucursales->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

        ##filtrar las que puede ver el usuario, por ahora esta solo numeros de prueba
        if( Auth::user() ){
            $user = Auth::user();
            if($user){
                $sucursalesPermitidas = SucursalesUsuario::where('estatus','=',1)->where('usuario_id','=',$user->id)->get();
                foreach($sucursalesPermitidas as $sucIdAllow){
                #foreach(range(1,3,1) as $sucIdAllow){
                    $arraySuc[] = $sucIdAllow->sucursal_id;
                }
                $sucursales = $sucursales->wherein('id',$arraySuc);
            }
        }

		if(request()->has('sort'))
		{
            $sucursales = $sucursales->orderBy('nombre',request('sort'));
            $queries['sort'] = request('sort');
		}

		$sucursales = $sucursales->paginate(15,['*'], '$sucursales_p')->appends($queries);
        return $sucursales ;
    }


    public static function verificaSucursal($idSuc){
        $sucursales = Sucursale::getSucursales()->where('id','=',$idSuc);
        if(count($sucursales)>=1){
            return True;
        }else{
            return False;
        }
    }
}
