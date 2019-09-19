<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use tniv\Sucursale;
use Session;
use DateTime;
date_default_timezone_set("America/Mexico_City");

class Mese extends Model
{
    protected $table = 'meses';

    public function dias()
    {
        return $this->hasMany('\tniv\Dia');
    }

    public function sucursal()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Sucursale');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Abierto', 'Cerrado', 'Inactivo'];
        return $estatus;
    }

    public static function getMeses()
    {
        $meses = Mese::query();
        $queries = [];

        $columnas = ['mes', 'ano', 'estatus','sucursal_id'];

        foreach($columnas as $columna){
            if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
                $meses = $meses->where($columna,'LIKE',request($columna));
                $queries[$columna] = request($columna);
            }
        }

		if(request()->has('sort'))
		{
            $meses = $meses->orderBy('ano',request('sort'));
            $queries['sort'] = request('sort');
		}

        $sucursales = Sucursale::getSucursales();
        ##foreach($sucursales as $sucursal){
        $arraySuc[] = Session::get('sucursalSession')->id;
        ##}

        $meses = $meses->whereIn('sucursal_id', $arraySuc);

		$meses = $meses ->orderBy('ano', 'DESC')
		                ->orderBy('mes', 'ASC')
                        ->paginate(15,['*'], 'meses_p')->appends($queries);

        return $meses ;
    }

    public static function cerrarMes()
    {
        $fecha = new DateTime();
        $fecha->modify('-1 month');

        $ano1 = strftime("%Y", $fecha->getTimestamp());
        $mes1 = strftime("%m", $fecha->getTimestamp());

        foreach(range(1, $mes1, 1) as $mes2){
            $meses = Mese::where('mes','=',$mes2)->where('ano','=',$ano1)->get();

            foreach($meses as $mes){
                $mes->estatus = "Cerrado";
                $mes->save();
            }
        }
    }
}
