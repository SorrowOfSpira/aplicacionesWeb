<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    // Campos que permitimos llenar desde un formulario
    protected $fillable = ['nombre', 'nombre_cientifico', 'precio'];

    /**
     * Relación con los Tags (Categorías)
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}