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
        Schema::create('retiros_evaluaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');
             // Pregunta 1: Se realiza la evaluación
            $table->boolean('se_realiza_evaluacion')->default(false);
            
            // Pregunta 2: La condición de salud está relacionada con el trabajo
            $table->boolean('condicion_salud_relacionada')->default(false);
            
            // Observaciones
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retiros_evaluaciones');
    }
};
