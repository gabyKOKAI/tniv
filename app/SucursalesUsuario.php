<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class SucursalesUsuario extends Model
{

    protected $table = 'sucursalesUsuarios';

    public function users()
    {
        return $this->hasMany('\tniv\User');
    }

    public function sucursales()
    {
        return $this->hasMany('\tniv\Sucursale');
    }

    public static function getSucursalesUsuario($idUsuario, $idSucursal){
        $estatusUsuarioSucursal = SucursalesUsuario::where('usuario_id','=',$idUsuario)->where('sucursal_id','=',$idSucursal)->first();
        if($estatusUsuarioSucursal){
            return $estatusUsuarioSucursal->estatus;
        }else{
            return 0;
        }
    }

}
