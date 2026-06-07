<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    protected $table = 'cliente';

    protected $fillable = ['nombre', 'apellido', 'email', 'password', 'telefono', 'direccion'];

    protected $hidden = ['password', 'remember_token'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idcliente');
    }
}
