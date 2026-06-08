<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    // Campos que permitimos llenar desde un formulario
    protected $fillable = ['nombre', 'nombre_cientifico', 'precio', 'stock', 'img_url'];

    /**
     * Relación con los Tags (Categorías)
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function detallesVenta()
    {
        return $this->hasMany(Detalleventa::class, 'idproducto');
    }
}