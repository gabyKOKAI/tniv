<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;

class SucursalController extends Controller
{
    public function lista()
    {
		$sucursales = Sucursale::all();

		return view('sucursal.sucursalLista')->with(['sucursales' => $sucursales]);
    }
}
