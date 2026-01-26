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
        Schema::create('actividades_factores_riesgos', function (Blueprint $table) {
            $table->id();
                $table->foreignId('puesto_actividad_id')->constrained('puestos_actividades')->onDelete('cascade');
                $table->string('categoria'); // fisico, seguridad, quimico, etc.
                $table->string('factor_riesgo'); // nombre del factor
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_factores_riesgos');
    }
};
