<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\SucursalesUsuario;

class SucursalController extends Controller
{
    public function lista()
    {
		$sucursales = Sucursale::all();

		return view('sucursal.sucursalLista')->with(['sucursales' => $sucursales]);
    }

     public function modificaEstatus(Request $request)
    {
        $sucUsu = SucursalesUsuario::where('sucursal_id','=',$request['sucursal'])->where('usuario_id','=',$request['usuario'])->first();

        if($sucUsu){
            if($sucUsu->estatus == 1){
                $sucUsu->estatus = 0;
            }
            else{
                $sucUsu->estatus = 1;
            }
        }else
        {
            $sucUsu = new SucursalesUsuario;
            $sucUsu->sucursal_id = $request['sucursal'];
            $sucUsu->usuario_id = $request['usuario'];
            $sucUsu->estatus = 1;
        }

        $sucUsu->save();

        return back()->with('success', 'Se cambiaron los permisos' )->withInput();

	 }

	 public function seleccionaSucursal(Request $request, $id) {
        $suc = Sucursale::where('id','=',$id)->first();
        $request->session()->put('sucursalSession1', $suc);
        #return back()->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
        #return redirect('/meses/')->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
        return redirect('/')->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
    }
}
