<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Servicio;

class ServicioController extends Controller
{
    public function guardar(Request $request) {
        $servicio = Servicio::find($request->input('servicioId'));

        if (!$servicio) {
            # Instantiate a new Model object
            $servicio = new Servicio();
            $res = "creado";
            # Set the parameters
            $servicio->numCitas = 21;
            $servicio->numCitasAgendadas = 0;
            $servicio->numCitasTomadas = 0;
            $servicio->numCitasPerdidas = 0;
            $servicio->fechaInicio = $request->input('fechaInicio');
            $servicio->estatus = 'Inactivo';
            $servicio->cliente_id = $request->input('cliente_id');

         } else {
            $res = "actualizado";

            # Set the parameters
            $servicio->fechaPago = $request->input('fechaPago');
            $servicio->fechaInicio = $request->input('fechaInicio');
            $servicio->fechaFin = $request->input('fechaFin');
            $servicio->numCitas = $request->input('numCitas');
            $servicio->numCitasAgendadas = $request->input('numCitasAgendadas');
            $servicio->numCitasTomadas = $request->input('numCitasTomadas');
            $servicio->numCitasPerdidas = $request->input('numCitasPerdidas');


            if($request->input('estatusServ') == "Iniciado"){
                #checar que no haya mas servicios iniciados para este cliente
                $servicios = Servicio::where('cliente_id','=',$servicio->cliente_id)->where('estatus','=','Iniciado')->where('id','<>',$servicio->id)->get();
                #dd($servicios);
                if(count($servicios)==0){
                    $servicio->estatus = $request->input('estatusServ');
                }else{
                    $res = "actualizado, pero no se actualizo el estatus porque ya tiene un servicio iniciado.";
                }
            }else{
                $servicio->estatus = $request->input('estatusServ');
            }
        }

        if($request->input('valoracion')){
            $servicio->valoracion = 1;
        }else{
            $servicio->valoracion = 0;
        }

        if($request->input('postParto')){
            $servicio->postParto = 1;
        }else{
            $servicio->postParto = 0;
        }

        if($request->input('alimentacion')){
            $servicio->alimentacion = 1;
        }else{
            $servicio->alimentacion = 0;
        }


        $servicio->save();

        return redirect('/cliente/4/'.$servicio->cliente_id)->with('success', 'El servicio fue '.$res);
    }
}
