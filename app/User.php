<?php

namespace tniv;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use tniv\User;
use Session;
use Route;

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
        $route = Route::currentRouteName();
        if($rol == 'Master'){

            if(in_array($route, ['usuario','usuarios'])){
                $estatus = ['Master', 'Admin', 'AdminSucursal', 'Cliente', 'ClienteNuevo', 'Inactivo'];
            }elseif(in_array($route, ['cliente','clientes']))   {
                $estatus = ['Cliente', 'ClienteNuevo', 'Inactivo'];
            }
        }
        if($rol == 'Admin'){
            if(in_array($route, ['usuario','usuarios'])){
                $estatus = ['Admin', 'AdminSucursal', 'Inactivo'];
            }elseif(in_array($route, ['cliente','clientes'])){
                $estatus = ['Cliente', 'ClienteNuevo', 'Inactivo'];
            }
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
            ->where('sucursalesUsuarios.estatus', '=', 1)
            ->wherein('users.rol', User::getRolesDropDown())
            ->paginate(15,['*'], '$sucursales_p');
        return $usuarios;
    }
}
