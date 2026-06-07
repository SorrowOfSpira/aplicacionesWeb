<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->renameColumn('correo', 'email');
            $table->string('telefono', 20)->nullable()->after('contrasena');
            $table->string('direccion')->nullable()->after('telefono');
            $table->string('remember_token', 100)->nullable()->after('direccion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->renameColumn('email', 'correo');
            $table->dropColumn(['telefono', 'direccion', 'remember_token', 'created_at', 'updated_at']);
        });
    }
};
