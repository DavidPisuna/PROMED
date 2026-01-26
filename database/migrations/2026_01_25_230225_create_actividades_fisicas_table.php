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
        Schema::create('actividades_fisicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumo_sustancia_id')->constrained('consumos_sustancias')->onDelete('cascade');
            $table->string('actividad_fisica_cual')->nullable();
            $table->integer('actividad_fisica_tiempo')->nullable();
            $table->string('actividad_fisica_frecuencia', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_fisicas');
    }
};
