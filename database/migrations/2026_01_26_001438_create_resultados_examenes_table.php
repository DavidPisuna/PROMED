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
        Schema::create('resultados_examenes', function (Blueprint $table) {
           $table->id(); // PK
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade'); 
            // Relación con el registro, se elimina si se elimina el registro
            $table->string('nombre_examen'); // Nombre del examen (personalizable)
            $table->date('fecha_examen'); // Fecha del examen
            $table->text('resultados')->nullable(); // Resultado en texto, opcional
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados_examenes');
    }
};
