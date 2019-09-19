<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use DateTime;
date_default_timezone_set("America/Mexico_City");

class Hora extends Model
{
    public function dia()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Dia');
    }

    public static function getHoras($estatus, $id)
    {
        $horas = Hora::where('dia_id', 'LIKE', $id)->get();

        return $horas ;
    }

    public static function cerrarHoraSucursales(){
        $sucursales = Sucursale::getSucursales();
        foreach($sucursales as $sucursal){
            Hora::cerrarHora($sucursal->horasCancelar,$sucursal->id);
        }
    }

    public static function cerrarHora($tiempo,$sucursal)
    {
        $fecha = new DateTime();
        $fecha->modify('+'.$tiempo.' hour');
        #dd($fecha);

        $ano1 = strftime("%Y", $fecha->getTimestamp());
        $mes1 = strftime("%m", $fecha->getTimestamp());
        $dia1 = strftime("%d", $fecha->getTimestamp());
        $hora1 = strftime("%H", $fecha->getTimestamp());


	    $meses = Mese::where('sucursal_id','=',$sucursal)->where('mes','=',$mes1)->where('ano','=',$ano1)->get();

	    foreach ($meses as $mes){
            $dia = Dia::where('mes_id','=',$mes->id)->where('numDia','=',$dia1)->first();
            foreach(range(1, $hora1, 1) as $hora2){
                $dateAux = DateTime::createFromFormat('H', $hora2);
                $horaAux = strftime("%H:00:00", $dateAux->getTimestamp());
                $hora = Hora::where('dia_id','=',$dia->id)->where('hora','=',$horaAux)->first();
                if($hora){
                    $hora->estatus = 0;
                    $hora->save();
                }
                $horaAux = strftime("%H:30:00", $dateAux->getTimestamp());
                $hora = Hora::where('dia_id','=',$dia->id)->where('hora','=',$horaAux)->first();
                if($hora){
                    $hora->estatus = 0;
                    $hora->save();
                }
            }
        }
    }
}
