<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
    protected $table = 'detalleventa';
    public $timestamps = false;
    protected $fillable = ['idventa', 'idproducto', 'cantidad', 'preciounitario'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idventa');
    }
}