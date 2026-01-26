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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('nombre'); // Nombre de la empresa
            $table->string('actividad_economica'); // Actividad económica principal
            $table->string('ruc', 13)->unique(); // RUC, único
            $table->string('direccion'); // Dirección fiscal
            $table->string('representante_legal'); // Nombre del representante legal
            $table->string('ciiu')->nullable(); // Código CIIU, opcional
            $table->boolean('activo')->default(true); // Campo para activar/desactivar empresa
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
