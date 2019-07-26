<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class Sucursale extends Model
{
    //protected $dateFormat = 'G:ia';

    public function meses()
    {
        return $this->hasMany('\tniv\Mese');
    }
}
