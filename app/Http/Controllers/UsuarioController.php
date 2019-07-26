<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\User;

class UsuarioController extends Controller
{
    public function lista()
    {
		$usuarios = User::paginate(15);

		return view('auth.usuarioLista')->with(['usuarios' => $usuarios]);
    }
}
