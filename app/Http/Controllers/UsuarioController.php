<?php

namespace tniv\Http\Controllers;

use Illuminate\Http\Request;
use tniv\User;
use tniv\Sucursale;
use tniv\SucursalesUsuario;
use Session;

class UsuarioController extends Controller
{
    public function lista()
    {
		$usuarios = User::getUsuarios();

		return view('usuario.usuarioLista')->with(['usuarios' => $usuarios]);
    }

    public function usuario(Request $request,$id= '-1') {
	    $estatusUsuarioSucursal = SucursalesUsuario::where('estatus','=',1)->where('usuario_id','=',$id)->where('sucursal_id','=',Session::get('sucursalSession')->id)->first();

	    # Get roles
        $rolesForDropdown = User::getRolesDropDown();
        $rolSelected = request('rol');

        if($estatusUsuarioSucursal){
            $usuario = User::where('id','=',$id)->wherein('rol', User::getRolesDropDown())->first();

            if($usuario){
                $rolSelected = $usuario->rol;
            }
            else{
                $usuario = new User;
                $usuario->id = -1;
                $rolSelected = 'Inactivo';
            }

            return view('usuario.usuario')->
                with([  'usuario' => $usuario,
                        'rolesForDropdown' => $rolesForDropdown,
                        'rolSelected'=>$rolSelected
                        ]);
        }else{
            $usuario = new User;
            $usuario->id = -1;
            $rolSelected = 'Inactivo';
            return view('usuario.usuario')->
                with([  'usuario' => $usuario,
                        'rolesForDropdown' => $rolesForDropdown,
                        'rolSelected'=>$rolSelected
                        ])->with('warning', 'El usuario '.$usuario->email.' ya esta creado, si no pudes verlo pertenece a otra sucursal y debes comunicarte con el administrador.');
        }
	}

    public function guardar(Request $request,$id) {
        $usuario = User::find($id);

        if (!$usuario) {
            $usuario = User::where('email', 'LIKE', $request['email'])->first();
            if (!$usuario) {
                # Instantiate a new Model object
                $usuario = new User();
                $res = "creado";
                $usuario->password = 'TEPORALkokai123456.!*';
            }else{
                $res = "ya existe";
            }
         } else {
            $res = "actualizado";
        }

        if($res == "ya existe"){
            return redirect('/usuario/'.$usuario->id)->with('warning', 'El usuario '.$usuario->email.' ya esta creado, si no pudes verlo pertenece a otra sucursal y debes comunicarte con el administrador.');
        }
        else{
            # Set the parameters
            $usuario->name = $request->input('name');
            $usuario->email = $request->input('email');
            $usuario->rol = $request->input('rol');

            $usuario->save();

            if($res == "creado"){
                $sucursal = Sucursale::find(Session::get('sucursalSession')->id);
                $this->crearSucursalUsuario($usuario, $sucursal, 1);

            }
        }
        return redirect('/usuario/'.$usuario->id)->with('success', 'El usuario '.$usuario->email.' fue '.$res);
    }

    public function crearSucursalUsuario($usuario, $sucursal,$estatus) {

        # Instantiate a new Model object
        $sucursalUsuario = new SucursalesUsuario();

        # Set the parameters
        $sucursalUsuario->estatus = $estatus;
        $sucursalUsuario->usuario_id = $usuario->id;
        $sucursalUsuario->sucursal_id = $sucursal->id;

        #$sucursalUsuario->user()->associate($usuario);
        #$sucursalUsuario->sucursal()->associate($sucursal);

        $sucursalUsuario->save();

        return true;
	}

}
