<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    public function dia()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Dia');
    }
}
