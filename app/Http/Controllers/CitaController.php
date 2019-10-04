<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Mese;
use tniv\Dia;
use tniv\Hora;
use tniv\Cita;
use tniv\Cliente;
use tniv\User;
use Datetime;
use URL;
use Redirect;
use Mail;

class CitaController extends Controller
{
    public function citasDisponibles(Request $request, $idMes = -1,$idDia = -1)
    {
        #dd($request);
        $request['estatus'] = "abierto";
        $meses = Mese::getMeses();

        $mes = Mese::find($idMes);
        if($mes){
            $diasMes = Dia::where('mes_id', 'LIKE', $idMes)->get();
        }else{
            $mes = new Mese;
            $diasMes = [];
        }

        $dia = Dia::find($idDia);
        if($dia){
            $horas = Hora::getHoras(1, $idDia);
            foreach ($horas as $hora){
                $hora->citas = Cita::where('hora_id','=',$hora->id)->get();
                $citasActivas = 0;

                foreach ($hora->citas as $cita){
                    $cita->nomCliente = Cliente::find($cita->cliente_id)->nombre;
                    if(in_array($cita->estatus, ['Agendada','Tomada','Perdida'])){
                        $citasActivas = $citasActivas + 1;
                    }
                }
                $hora->citasActivas  = $citasActivas;
            }
        }else{
            $dia = new Dia;
            $dia->id  = -1;
            $horas = [];
        }

		return view('cita.citasDisponibles')->with(
		#return Redirect::to("agendaCita/3/60#mes_seleccionado_3")->with(
		#return Route::view("/agendaCita/3/60#mes_seleccionado_3", "cita.citasDisponibles",
		#$url = URL::route('agendaCita') .'#mes_seleccionado_3';
        #return Redirect::to($url)->with(
		[ 'meses' => $meses,
		        'mesSelect' => $mes,
		        'diasMes'=>$diasMes,
		        'diaSelect' => $dia,
		        'horasDia' => $horas
		        ]);

    }

    public function agendarCitaACliente(Request $request)
    {
        $hora = Hora::find($request['hora']);
        $fecha = Cita::regresaFecha($hora);

        # Get estatus
        $clientes = Cliente::getClientes();

        return view('cita.citaACliente')->
            with([  'fecha' => $fecha,
                    'clientes' => $clientes,
                    'hora' => $hora
                    ]);
    }

    public function agendarCita(Request $request)
    {
        return $this->agendarCitas($request, "cita");
    }

    public function agendarValoracion(Request $request)
    {
        return $this->agendarCitas($request, "valoracion");
    }

    public function enviarCorreo($nombre, $correo, $subject, $mensaje)
    {
        $data = array('nombre'=>$nombre,
                    'mensaje'=>$mensaje);
        $emails = array($correo);
        $emailsBCC = array('gaby@kokai.com.mx');

        $res = Mail::send('emails.contacto',$data, function ($message) use ($emails, $emailsBCC, $subject) {
			$message->from('contacto@vint.mx','VINT');
			$message->to($emails);
			$message->bcc($emailsBCC);
			$message->subject('[VINT] '.$subject);
 		});
 		return $res;
    }

    public function agendarCitas(Request $request, $tipo)
    {
        $hora = Hora::find($request['hora']);
        $dia = Dia::find($hora->dia_id);
        $mes = Mese::find($dia->mes_id);
        $fecha = Cita::regresaFecha($hora);

        $usuario = auth()->user();
        if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
            $cliente = Cliente::find($request['id_cliente']);
        }else{
            $cliente = Cliente::where('user_id','=',$usuario->id)->first();
        }

        $numCitas = Cita::getNumCitas($request['id_cliente']);
        $numCitasTomadas = Cita::getNumCitasTomadas($request['id_cliente']);
        $numCitasValoracion = Cita::getValoracionTomada($request['id_cliente']);
        $numCitasTomPerAg = Cita::getNumCitasTomPerAg(-1);
        $numCitasPosibles = 21*Cliente::getNumServicio($cliente->id);
        if($numCitas<5 and $numCitasTomPerAg<$numCitasPosibles){
            $cita = Cita::join('horas', 'citas.hora_id', '=', 'horas.id')
            ->join('dias', 'horas.dia_id', '=', 'dias.id')
            ->join('meses', 'dias.mes_id', '=', 'meses.id')
            ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
            ->where('cliente_id','=',$cliente->id)
            ->where('dias.numDia','=',$dia->numDia)
            ->where('meses.mes','=',$mes->mes)
            ->where('meses.ano','=',$mes->ano)
            ->whereIn('citas.estatus',['Agendada','Valoracion','Tomada','VTomada'])
            ->select('horas.hora', 'dias.numDia','meses.mes','meses.ano','clientes.nombre','citas.estatus','dias.id as diaId','meses.id as mesId' )
            ->first();

            if(!$cita){
                $cita = Cita::where('cliente_id','=',$cliente->id)->where('hora_id','=',$hora->id)->first();
                if(!$cita){
                    $cita = new Cita();
                }

                #se checa en el view que no haya mas del numero máximo de citas por hora
                # Set the parameters
                if($tipo == "valoracion" and ($numCitas+$numCitasTomadas+$numCitasValoracion<=0)){
                    $cita->estatus = "Valoracion";
                }else{
                    if($tipo == "valoracion"){
                        $tipo = "cita, ya no puede agendar valoracion,";
                    }
                    $cita->estatus = "Agendada"; #'Agendada', 'Cancelada', 'Tomada', 'Perdida','Valoracion','VTomada'
                }
                $cita->hora_id = $request['hora'];
                $cita->cliente_id = $cliente->id;

                $cita->save();

                #Enviar correo
                $agendadas =  Cita::getNumCitas($request['id_cliente']);
                $tomadas = Cita::getNumCitasTomadas($request['id_cliente']);
                $posibles = 21*Cliente::getNumServicio($request['id_cliente']);
                $mensaje = [];
                $mensaje[0] = "Quedó agendada su ". $tipo.' del '.$fecha.'.';
                $mensaje[1] = "Le recordamos que tiene agendades ".$agendadas." citas y ha tomado ".$tomadas." de ".$posibles.".";
                $mensaje[2] = "Para cualquier cambio o cancelación, favor de hacerlo directamente en la página o comunicarte con nosotros.";
                $mensaje[3] = "Muchas Gracias";
                $mensaje[4] = "";
                $this->enviarCorreo($cliente->nombre, $cliente->correo, 'Cita agendada el '.$fecha, $mensaje);

                if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                    return redirect('dia/'.$dia->id)->with('success', 'Quedó agendada la '. $tipo .' para '.$cliente->nombre.' el '.$fecha);
                }else{
                    return redirect('/')->with('success', 'Quedó agendada su '. $tipo .' del '.$fecha);
                }
            }else{
                if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                    return redirect('dia/'.$dia->id)->with('error', 'El cliente '.$cliente->nombre.' ya tiene una cita agendada este dia');
                }else{
                    return redirect('/agendaCita/'.$cita->mesId.'/'.$cita->diaId)->with('error', 'Ya tiene una cita agendada este día.');
                }
            }
        }else
        {
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                return redirect('dia/'.$dia->id)->with('error', 'El cliente '.$cliente->nombre.' ya no puede agendar más citas');
            }else{
                return redirect('/')->with('error', 'Ya tiene el número máximo de citas que puede agendar.');
            }
        }
    }

    public function modificarEstatusCita(Request $request,$id = -1, $estatus)
    {
        $usuario = auth()->user();

        if($id==-1){
            $cliente = Cliente::where('user_id','=',$usuario->id)->first();
            $cita = Cita::where('estatus','=','Agendada')->where('cliente_id','=',$cliente->id)->first();
        }else{
            $cita = Cita::find($id);
            $cliente = Cliente::find($cita->cliente_id);
        }

        if($cita->estatus == 'Valoracion' and $estatus != 'Cancelada'){
            $estatus = 'VTomada';
        }

        if($cita->estatus == 'VTomada' and $estatus == 'Agendada'){
            $estatus = 'Valoracion';
        }

        # Set the parameters
        $cita->estatus = $estatus;

        $cita->save();

        $hora = Hora::find($cita->hora_id);
        $dia = Dia::find($hora->dia_id);
        $fecha = Cita::regresaFecha($hora);

        if(in_array($estatus,['Cancelada', 'Agendada','Valoracion']) and Cita::regresaFechaCodigo($hora) >= Cita::regresaFechaCodigoHoy()){
            #Enviar correo
            $agendadas =  Cita::getNumCitas($cliente->id);
            $tomadas = Cita::getNumCitasTomadas($cliente->id);
            $posibles = 21*Cliente::getNumServicio($cliente->id);
            $mensaje = [];
            $mensaje[0] = 'Quedó '.$estatus.' su cita del '.$fecha.'.';
            $mensaje[1] = "Le recordamos que tiene agendades ".$agendadas." citas y ha tomado ".$tomadas." de ".$posibles.".";
            $mensaje[2] = "Para cualquier cambio o cancelación, favor de hacerlo directamente en la página o comunicarte con nosotros.";
            $mensaje[3] = "Muchas Gracias";
            $mensaje[4] = "";
            $this->enviarCorreo($cliente->nombre, $cliente->correo, 'Cita '.$estatus.' el '.$fecha, $mensaje);
        }
        if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
            return redirect('dia/'.$dia->id)->with('success', 'Quedó '.$estatus.' la cita para el cliente '.$cliente->nombre.' el '.$fecha);
        }else{
            return redirect('/')->with('success', 'Quedó '.$estatus.' su cita del '.$fecha);
        }

    }

    public function cancelarCita(Request $request,$id = -1)
    {
        return $this->modificarEstatusCita($request, $id, "Cancelada");
    }

    public function tomarCita(Request $request,$id = -1)
    {
        return $this->modificarEstatusCita($request, $id, "Tomada");
    }

    public function perderCita(Request $request,$id = -1)
    {
        return $this->modificarEstatusCita($request, $id, "Perdida");
    }

    public function reagendarCita(Request $request,$id = -1)
    {
        $usuario = auth()->user();
        #checar que no tenga una cita previa
        $cita = Cita::find($id);
        $cliente = Cliente::find($cita->cliente_id);
        #$cita = Cita::where('cliente_id','=',$cliente->id)->where('estatus','=','Agendada')->first();
        $hora = Hora::find($cita->hora_id);
        $dia = Dia::find($hora->dia_id);

        if($cita->estatus == 'Cancelada'){
            $cita = Cita::join('horas', 'citas.hora_id', '=', 'horas.id')
                ->join('dias', 'horas.dia_id', '=', 'dias.id')
                ->join('meses', 'dias.mes_id', '=', 'meses.id')
                ->join('clientes', 'citas.cliente_id', '=', 'clientes.id')
                ->where('cliente_id','=',$cliente->id)
                ->where('dias.numDia','=',$dia->numDia)
                ->whereIn('citas.estatus',['Agendada','Valoracion','Tomada','VTomada'])
                ->select('horas.hora', 'dias.numDia','meses.mes','meses.ano','clientes.nombre','citas.estatus','dias.id as diaId','meses.id as mesId' )
                ->first();

                if(!$cita){
                    return $this->modificarEstatusCita($request, $id, "Agendada");
                }else
                {
                    #$hora = Hora::find($cita->hora_id);
                    #$dia = Dia::find($hora->dia_id);
                    $fecha = Cita::regresaFecha($hora);
                    if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                        return redirect('dia/'.$dia->id)->with('error', 'El cliente '.$cliente->nombre.' ya tiene 1 cita agendada este dia');
                    }else{
                        return redirect('/agendaCita/'.$cita->mesId.'/'.$cita->diaId)->with('error', 'Ya tiene una cita agendada este día.');
                    }
                }
        }else{
            return $this->modificarEstatusCita($request, $id, "Agendada");
        }

    }

}
