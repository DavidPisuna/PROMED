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
        Schema::create('antecedentes_patologicos', function (Blueprint $table) {
             $table->id();

            // Relación con registro
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');

            $table->text('antecedente_app')->nullable(); // ANTECEDENTES CLÍNICOS Y QUIRÚRGICOS
            $table->text('antecedente_apqx')->nullable(); //  ANTECEDENTES FAMILIARES
             // Campo para 'En caso de requerir transfusiones autoriza: Si/NO'
            // Se recomienda un BOOLEAN para respuestas binarias (Sí/No)
            $table->boolean('autoriza_transfusiones')->nullable();

            // Campo para 'Se encuentra bajo algún tratamiento hormonal: Si/NO'
            // Se recomienda un BOOLEAN para respuestas binarias (Sí/No)
            $table->boolean('tratamiento_hormonal_si_no')->nullable();
            // Campo para '¿Cuál describir?' (si el tratamiento hormonal es Sí)
            // Se recomienda un TEXT por si la descripción es larga
            $table->text('tratamiento_hormonal_descripcion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes_patologicos');
    }
};
