<?php

namespace tniv;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use tniv\User;
use Session;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getRolesDropDown()
    {
        $rol = Auth::user()->rol;
        if($rol == 'Master'){
            $estatus = ['Master', 'Admin', 'AdminSucursal', 'Cliente', 'ClienteNuevo', 'Inactivo'];
        }
        if($rol == 'Admin'){
            $estatus = ['Admin', 'AdminSucursal', 'Cliente', 'ClienteNuevo', 'Inactivo'];
        }
        if($rol == 'AdminSucursal'){
            $estatus = ['Cliente', 'ClienteNuevo', 'Inactivo'];
        }
        return $estatus;
    }

    public static function getUsuarios()
    {

        $usuarios = User::join('sucursalesUsuarios', 'users.id', '=', 'sucursalesUsuarios.usuario_id')
            ->select('users.id', 'users.name', 'sucursalesUsuarios.estatus', 'users.email', 'users.rol')
            ->where('sucursalesUsuarios.sucursal_id', '=', Session::get('sucursalSession')->id)
            ->wherein('users.rol', User::getRolesDropDown())
            ->paginate(15,['*'], '$sucursales_p');
        return $usuarios;
    }
}
