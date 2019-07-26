<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    public static function getEstatusDropDown()
    {
        $estatus = ['Activo', 'Inactivo', 'SinServicios', 'Terminado'];
        return $estatus;
    }

    public static function getClientes()
    {
        $clientes = Cliente::query();
        $queries = [];

        $columnas = ['sucursal_id', 'estatus'];

        foreach($columnas as $columna){
            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $clientes = $clientes->where($columna,'LIKE','%'.request($columna).'%');
                $queries[$columna] = request($columna);
            }
        }

		//if(request()->has('sort'))
		//{
          //  $meses = $meses->orderBy('ano',request('sort'));
          //  $queries['sort'] = request('sort');
		//}


		$clientes = $clientes->paginate(15,['*'], 'clientes_p')->appends($queries);

        return $clientes ;
    }
}
