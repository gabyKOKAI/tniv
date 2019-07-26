<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\Sucursale;

class SucursalController extends Controller
{
    public function lista()
    {
		$sucursales = Sucursale::paginate(15);

		return view('sucursal.sucursalLista')->with(['sucursales' => $sucursales]);
    }
}
