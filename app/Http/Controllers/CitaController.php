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
        $hora = Hora::find($request['hora']);
        $dia = Dia::find($hora->dia_id);
        $fecha = Cita::regresaFecha($hora);

        $usuario = auth()->user();
        if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
            $cliente = Cliente::find($request['id_cliente']);
        }else{
            $cliente = Cliente::where('user_id','=',$usuario->id)->first();
        }

        $cita = Cita::where('cliente_id','=',$cliente->id)->where('estatus','=','Agendada')->first();
        if(!$cita){
            $cita = Cita::where('cliente_id','=',$cliente->id)->where('hora_id','=',$hora->id)->first();
            if(!$cita){
                $cita = new Cita();
            }

            #se checa en el view que no haya mas del numero máximo de citas por hora
            # Set the parameters
            $cita->estatus = "Agendada"; #'Agendada', 'Cancelada', 'Tomada', 'Perdida','Libre'
            $cita->hora_id = $request['hora'];
            $cita->cliente_id = $cliente->id;

            $cita->save();

            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                return redirect('dia/'.$dia->id)->with('success', 'Quedó agendada la cita para '.$cliente->nombre.' el '.$fecha.' a las '.$hora->hora);
            }else{
                return redirect('/')->with('success', 'Quedó agendada su cita del '.$fecha.' a las '.$hora->hora);
            }
        }else
        {
            $hora = Hora::find($cita->hora_id);
            $fecha = Cita::regresaFecha($hora);
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                return redirect('dia/'.$dia->id)->with('error', 'El '.$cliente->nombre.' ya tiene una cita agendada el '.$fecha.' a las '.$hora->hora);
            }else{
                return redirect('/')->with('error', 'Ya tiene una cita agendada el '.$fecha.' a las '.$hora->hora);
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


        # Set the parameters
        $cita->estatus = $estatus;

        $cita->save();

        $hora = Hora::find($cita->hora_id);
        $dia = Dia::find($hora->dia_id);
        $fecha = Cita::regresaFecha($hora);

        if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
            return redirect('dia/'.$dia->id)->with('success', 'Quedó '.$estatus.' la cita para '.$cliente->nombre.' el '.$fecha.' a las '.$hora->hora);
        }else{
            return redirect('/')->with('success', 'Quedó '.$estatus.' su cita del '.$fecha.' a las '.$hora->hora);
        }

    }

    public function cancelarCita(Request $request,$id = -1)
    {
        #GOP solo si es en más de 24h se puede cancelar, si no pasa a perdida
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
        $cita = Cita::where('cliente_id','=',$cliente->id)->where('estatus','=','Agendada')->first();

        if(!$cita){
            return $this->modificarEstatusCita($request, $id, "Agendada");
        }else
        {
            $hora = Hora::find($cita->hora_id);
            $dia = Dia::find($hora->dia_id);
            $fecha = Cita::regresaFecha($hora);
            if(in_array($usuario->rol, ['Master','Admin','AdminSucursal'])){
                return redirect('dia/'.$dia->id)->with('error', 'El '.$cliente->nombre.' ya tiene una cita agendada el '.$fecha.' a las '.$hora->hora);
            }else{
                return redirect('/')->with('error', 'Ya tiene una cita agendada el '.$fecha.' a las '.$hora->hora);
            }
        }
    }

}
