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


    public static function getSucursales()
    {
        //$meses = Mese::query();
        //$queries = [];

        //$columnas = ['mes', 'ano', 'estatus','sucursal_id'];

        //foreach($columnas as $columna){
          //  if(request()->has($columna) and request($columna)!= 'all' and request($columna)!= ''){
            //    $meses = $meses->where($columna,'LIKE','%'.request($columna).'%');
              //  $queries[$columna] = request($columna);
            //}
        }
}
