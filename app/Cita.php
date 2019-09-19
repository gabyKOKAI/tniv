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

    public static function regresaFechaCodigo(Hora $hora)
    {
        $fechaVacia = Cita::regresaFechaFormato($hora);
        $fecha = strftime("%y%m%d", $fechaVacia->getTimestamp());

        return $fecha;
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
        $fecha = $dia->diaSemana.", ".$dia->numDia." de ".$mesNombre." del ".$mes->ano." a las ".$hora->hora." en ".$sucursal->nombre;

        return $fecha;
    }

    public static function regresaFechaFormato(Hora $hora){
        setlocale(LC_TIME, 'es_ES');
        $dia = Dia::find($hora->dia_id);
        $mes = Mese::find($dia->mes_id);
        $fechaVacia = DateTime::createFromFormat('!m', $mes->mes);
        $mesDosDig = strftime("%m", $fechaVacia->getTimestamp());
        return DateTime::createFromFormat('Ymd H:i:s', $mes->ano.$mesDosDig.$dia->numDia.' '.$hora->hora);
    }

    public static function getProximasCitas()
    {
        setlocale(LC_TIME, 'es_ES');
        $res = [];
        $usuario = auth()->user();
        if($usuario){
            $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            if($cliente){
                $citas = Cita::where('cliente_id','=',$cliente->id)->whereIn('estatus',['Agendada','Valoracion'])->get();
                $res = "";
                foreach ($citas as $cita){
                    if($cita){
                        date_default_timezone_set("America/Mexico_City");
                        $cita->hora = Hora::find($cita->hora_id);
                        $cita->fecha = Cita::regresaFecha($cita->hora);
                        $cita->codigoFecha = Cita::regresaFechaCodigo($cita->hora);

                        $fecha_actual = new DateTime("now");
                        $fecha_dada = Cita::regresaFechaFormato($cita->hora);

                        $diferencia = $fecha_actual->diff($fecha_dada);
                        $difHoras = $diferencia->m*10000 + $diferencia->d*100 + $diferencia->h;
                        if($fecha_actual > $fecha_dada){
                            $cita->diferenciaDias = -1 * $difHoras;
                        }else{
                            $cita->diferenciaDias = $difHoras;
                        }
                    }
                }
                $res = $citas->sortBy('codigoFecha');
            }
         }
        return $res;
    }

    public static function getNumCitasEstatus($idCliente, $estatusArray)
    {
        setlocale(LC_TIME, 'es_ES');
        $numCitas = 0;
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }

            if($cliente){
                $numCitas = Cita::where('cliente_id','=',$cliente->id)->whereIn('estatus', $estatusArray)->count();
            }
         }
        return $numCitas;
    }

    public static function getNumCitas($idCliente)
    {
        return Cita::getNumCitasEstatus($idCliente,['Agendada','Valoracion']);
    }

    public static function getNumCitasTomPerAg($idCliente)
    {
        return Cita::getNumCitasEstatus($idCliente,['Tomada','Perdida','Agendada']);
    }

    public static function getNumCitasTomadas($idCliente)
    {
        return Cita::getNumCitasEstatus($idCliente,['Tomada', 'Perdida']);
    }

    public static function getValoracionTomada($idCliente)
    {
        return Cita::getNumCitasEstatus($idCliente,['VTomada']);
    }

}
