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
        Schema::create('constantes_vitales', function (Blueprint $table) {
           $table->id();

            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');

            // CONSTANTES VITALES
            $table->decimal('temperatura', 4, 2)->nullable()->comment('Temperatura en °C');

            // PRESIÓN ARTERIAL
            $table->integer('presion_arterial')->nullable()->comment('Presión Arterial (mmHg)');

            $table->integer('frecuencia_cardiaca')->nullable()->comment('Frecuencia cardíaca en lat/min');
            $table->integer('frecuencia_respiratoria')->nullable()->comment('Frecuencia respiratoria en fr/min');
            $table->integer('saturacion_oxigeno')->nullable()->comment('Saturación de O2 en %');

            // ANTROPOMETRÍA
            $table->decimal('peso', 5, 2)->nullable()->comment('Peso en Kg');
            $table->decimal('talla', 5, 2)->nullable()->comment('Talla en cm');
            $table->decimal('imc', 5, 2)->nullable()->comment('Índice de Masa Corporal en kg/m2');
            $table->string('categoria_imc')->nullable()->comment('Categoría según IMC');
            $table->decimal('perimetro_abdominal', 5, 2)->nullable()->comment('Perímetro abdominal en cm');

            $table->text('enfermedad_actual')->nullable()->comment('Enfermedad o problema actual');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constantes_vitales');
    }
};
