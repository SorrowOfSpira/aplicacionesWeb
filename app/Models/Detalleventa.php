<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
    protected $table = 'detalleventa';

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}