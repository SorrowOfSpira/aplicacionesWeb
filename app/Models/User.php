<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Estas son las columnas que Laravel tiene permiso de escribir en Neon.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Estas columnas no se mostrarán en las consultas por seguridad.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}