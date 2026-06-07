<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Venta extends Model
{
    protected $table = 'venta';
    public $timestamps = false;
    protected $fillable = ['fecha', 'idcliente'];

    public function detalles()
    {
        return $this->hasMany(Detalleventa::class, 'idventa');
    }

    public function getTotalAttribute()
    {
        return $this->detalles->sum(function ($detalle) {
            return $detalle->cantidad * $detalle->preciounitario;
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }
}

