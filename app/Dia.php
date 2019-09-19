<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use tniv\Mese;
use DateTime;
date_default_timezone_set("America/Mexico_City");

class Dia extends Model
{
    public function mes()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Mese');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Abierto', 'Cerrado'];
        return $estatus;
    }

    public static function cerrarDia()
    {
        $fecha = new DateTime();
        $fecha->modify('-1 day');
        ##$fecha->modify('-20 hour');

        $ano1 = strftime("%Y", $fecha->getTimestamp());
        $mes1 = strftime("%m", $fecha->getTimestamp());
        $dia1 = strftime("%d", $fecha->getTimestamp());

	    $meses = Mese::where('mes','=',$mes1)->where('ano','=',$ano1)->get();

	    foreach ($meses as $mes){
	        foreach(range(1, $dia1, 1) as $dia2){
	            $dia = Dia::where('mes_id','=',$mes->id)->where('numDia','=',$dia2)->first();
                $dia->estatus = 0;
                $dia->save();
            }
        }
    }
}
