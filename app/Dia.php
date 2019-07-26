<?php

namespace tniv;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    public function dia()
    {
        # Proyecto belongs to Cliente
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('tniv\Mese');
    }
}
