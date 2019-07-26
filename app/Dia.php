<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    public function mes()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Mese');
    }

    public static function getEstatusDropDown()
    {
        $estatus = ['Abierto', 'Cerrado'];
        return $estatus;
    }
}
