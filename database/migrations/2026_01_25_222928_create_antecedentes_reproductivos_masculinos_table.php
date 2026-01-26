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
        Schema::create('antecedentes_reproductivos_masculinos', function (Blueprint $table) {
            $table->id();
            
             // Relación con registro
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');

            // Método de planificación familiar
            $table->boolean('planificacion_si')->nullable();
            $table->string('planificacion_cual')->nullable();
            $table->boolean('planificacion_no')->nullable();
            $table->boolean('planificacion_no_responde')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes_reproductivos_masculinos');
    }
};
