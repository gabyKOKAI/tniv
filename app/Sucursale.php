<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

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

        ##GOP ojo filtrar las que puede ver el usuario, por ahora esta solo numeros de prueba
        foreach(range(1,4,2) as $sucIdAllow){
            $arraySuc[] = $sucIdAllow;
        }
        $sucursales = $sucursales->wherein('id',$arraySuc);

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
