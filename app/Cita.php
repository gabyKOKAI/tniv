<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;
use Datetime;
use tniv\Servicio;

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
        $estatus = ['Agendada', 'Cancelada', 'Tomada', 'Perdida', 'Valoracion', 'VTomada'];
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

    public static function regresaFechaCodigoHoy(){
        setlocale(LC_TIME, 'es_ES');
        $fecha = new DateTime();
        return strftime("%y%m%d", $fecha->getTimestamp());
    }

    public static function getProximasCitas($idCliente)
    {
        setlocale(LC_TIME, 'es_ES');
        $res = [];
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }

            if($cliente){
                #$citas = Cita::where('cliente_id','=',$cliente->id)->whereIn('estatus',['Agendada','Valoracion'])->get();
                $citas = Cita::where('cliente_id','=',$cliente->id)->whereIn('estatus',['Agendada', 'Tomada', 'Perdida','Valoracion','VTomada'])->get();
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
                $res = $citas->sortByDesc('codigoFecha');
            }
         }
        return $res;
    }

    public static function getNumCitasEstatus($idCliente, $estatusArray)
    {
        #setlocale(LC_TIME, 'es_ES');
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
        #return Cita::getNumCitasEstatus($idCliente,['Agendada','Valoracion']);
        $numCitas = 0;
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }
            if($cliente){
                $servicio = Servicio::where('cliente_id','=',$cliente->id)->where('estatus','=','Iniciado')->first();
                if($servicio) {
                    $numCitas = $servicio->numCitasAgendadas;
                }else{
                    $numCitas = 0;
                }
            }
        }

        return $numCitas;
    }

    public static function getNumCitasTomPerAg($idCliente)
    {
        #return Cita::getNumCitasEstatus($idCliente,['Tomada','Perdida','Agendada']);
        $numCitas = 0;
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }
            if($cliente){
                $servicio = Servicio::where('cliente_id','=',$cliente->id)->where('estatus','=','Iniciado')->first();
                if($servicio) {
                    $numCitas = $servicio->numCitasTomadas + $servicio->numCitasPerdidas + $servicio->numCitasAgendadas;
                }else{
                    $numCitas = 0;
                }
            }
        }
        return $numCitas;

    }

    public static function getNumCitasTomadas($idCliente)
    {
        #return Cita::getNumCitasEstatus($idCliente,['Tomada', 'Perdida']);
        $numCitas = 0;
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }
            if($cliente){
                $servicio = Servicio::where('cliente_id','=',$cliente->id)->where('estatus','=','Iniciado')->first();
                if($servicio) {
                    $numCitas = $servicio->numCitasTomadas + $servicio->numCitasPerdidas;
                }else{
                    $numCitas = 0;
                }
            }
        }
        return $numCitas;
    }

    public static function getValoracionTomada($idCliente)
    {
        #return Cita::getNumCitasEstatus($idCliente,['VTomada','Valoracion']);
        $numCitas = 0;
        $usuario = auth()->user();
        if($usuario){
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                $cliente = Cliente::find($idCliente);
            }else{
                $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            }
            if($cliente){
                $servicio = Servicio::where('cliente_id','=',$cliente->id)->where('estatus','=','Iniciado')->first();
                if($servicio) {
                    $numCitas = $servicio->valoracion;
                }else{
                    $numCitas = 0;
                }
            }
        }
        return $numCitas;
    }


    public static function tomarCitas()
    {
        $fecha = new DateTime();

        $ano1 = strftime("%Y", $fecha->getTimestamp());
        $mes1 = strftime("%m", $fecha->getTimestamp());
        $dia1 = strftime("%d", $fecha->getTimestamp());
        $hora1 = strftime("%H", $fecha->getTimestamp());
        $min1 = (int)strftime("%M", $fecha->getTimestamp());

	    $meses = Mese::where('mes','=',$mes1)->where('ano','=',$ano1)->get();

	    foreach ($meses as $mes){
            $dia = Dia::where('mes_id','=',$mes->id)->where('numDia','=',$dia1)->first();
            foreach(range(1, $hora1, 1) as $hora2){
                $dateAux = DateTime::createFromFormat('H', $hora2);
                $horaAux = strftime("%H:00:00", $dateAux->getTimestamp());

                $hora = Hora::where('dia_id','=',$dia->id)->where('hora','=',$horaAux)->first();
                if($hora){
                    $citas = Cita::where('hora_id','=',$hora->id)->get();
                    foreach ($citas as $cita){
                        if($cita->estatus == "Agendada"){
                            $cita->estatus = "Tomada";
                        }

                        if($cita->estatus == "Valoracion"){
                            $cita->estatus = "VTomada";
                        }

                        if(in_array($cita->estatus, ['Tomada','VTomada'])) {
                            #Actualizo el numero de citas tomadas en el servicio
                            $servicio = Servicio::where('cliente_id', '=', $cita->cliente_id)->where('estatus', '=', 'Iniciado')->first();
                            if ($servicio) {
                                $servicio->numCitasTomadas = $servicio->numCitasTomadas + 1;
                                $servicio->numCitasAgendadas = $servicio->numCitasAgendadas - 1;
                                $servicio->save();
                            }
                        }
                        $cita->save();
                    }
                }

                if($hora2<$hora1 or ($hora2=$hora1 and $min1>30)){
                    $horaAux = strftime("%H:30:00", $dateAux->getTimestamp());
                    $hora = Hora::where('dia_id','=',$dia->id)->where('hora','=',$horaAux)->first();
                    if($hora){
                        $citas = Cita::where('hora_id','=',$hora->id)->get();
                        foreach ($citas as $cita){
                            if($cita->estatus == "Agendada"){
                                $cita->estatus = "Tomada";
                            }

                            if($cita->estatus == "Valoracion"){
                                $cita->estatus = "VTomada";
                            }

                            if(in_array($cita->estatus, ['Tomada','VTomada'])) {
                                #Actualizo el numero de citas tomadas en el servicio
                                $servicio = Servicio::where('cliente_id', '=', $cita->cliente_id)->where('estatus', '=', 'Iniciado')->first();
                                if ($servicio) {
                                    $servicio->numCitasTomadas = $servicio->numCitasTomadas + 1;
                                    $servicio->numCitasAgendadas = $servicio->numCitasAgendadas - 1;
                                    $servicio->save();
                                }
                            }
                            $cita->save();
                        }
                    }
                }

            }
        }
    }

}
