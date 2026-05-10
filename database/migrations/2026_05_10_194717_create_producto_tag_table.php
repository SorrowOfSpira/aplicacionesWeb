<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    // Fase 1: Crear la tabla y sus columnas
    Schema::create('producto_tag', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('producto_id');
        $table->unsignedBigInteger('tag_id');
        $table->timestamps();
        // Fase 2: Crear las relaciones por separado
        //$table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        //$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');    
    });

    

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_tag');
    }
};
