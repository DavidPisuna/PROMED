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
        Schema::create('centros_trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');
            $table->string('nombre_centro_trabajo', 150);
            $table->text('actividades_desempenadas');
            $table->enum('tipo_trabajo', ['anterior', 'actual']);
            $table->string('tiempo_trabajo', 50)->nullable();
            $table->boolean('incidente')->default(false);
            $table->boolean('accidente')->default(false);
            $table->boolean('enfermedad_profesional')->default(false);
            $table->boolean('calificado_iess')->default(false);
            $table->date('fecha_calificacion')->nullable();
            $table->text('especificar')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centros_trabajos');
    }
};
