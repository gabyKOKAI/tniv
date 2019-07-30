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
}
