<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['nombre'];

    /**
     * Relación con los Productos
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class);
    }
}