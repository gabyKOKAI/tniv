<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class Cita extends Model
{
    public function clientes()
    {
        return $this->hasMany('\tniv\Cliente');
    }

    public function horas()
    {
        return $this->hasMany('\tniv\Hora');
    }

    public static function getCitas()
    {

    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Agendada', 'Cancelada', 'Tomada', 'Perdida'];
        return $estatus;
    }

    public static function getProximaCita()
    {
        setlocale(LC_TIME, 'es_ES');
        $res = -1;
        $usuario = auth()->user();
        if($usuario){
            $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            if($cliente){
                $cita = Cita::where('cliente_id','=',$cliente->id)->where('estatus','=','Agendada')->first();
                if($cita){
                    $hora = Hora::find($cita->hora_id);
                    $fecha = Cita::regresaFecha($hora);
                    $res = $fecha.' a las '.$hora->hora;
                 }
            }
         }
        return $res;


    }

    public static function regresaFecha(Hora $hora)
    {
        setlocale(LC_TIME, 'es_ES');
        $dia = Dia::find($hora->dia_id);
        $mes = Mese::find($dia->mes_id);
        $sucursal = Sucursale::find($mes->sucursal_id);
        setlocale(LC_TIME, 'es_ES');
        $fechaVacia = DateTime::createFromFormat('!m', $mes->mes);
        $mesNombre = strftime("%B", $fechaVacia->getTimestamp());
        $fecha = $dia->diaSemana.", ".$dia->numDia." de ".$mesNombre." del ".$mes->ano." en ".$sucursal->nombre;

        return $fecha;
    }

}
