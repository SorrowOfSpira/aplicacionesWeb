<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'cliente';

    protected $fillable = ['nombre', 'apellido', 'email', 'password', 'telefono', 'direccion'];

    protected $hidden = ['password', 'remember_token'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idcliente');
    }
}
