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
        Schema::create('aptitudes_medicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');
             // Aptitud médica (solo puede ser una)
            $table->enum('aptitud', [
                'apto',
                'apto_observacion', 
                'apto_limitaciones',
                'no_apto'
            ]);
            // Observaciones
            $table->text('observaciones')->nullable();

            // Recomendaciones y/o tratamiento
            $table->text('recomendaciones_tratamiento')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aptitudes_medicas');
    }
};
