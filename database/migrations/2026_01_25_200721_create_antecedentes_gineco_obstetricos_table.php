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
        Schema::create('antecedentes_gineco_obstetricos', function (Blueprint $table) {
            $table->id();
            // Relación con registro
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');

            // Información gineco-obstétrica
            $table->date('fecha_ultima_menstruacion')->nullable();
            $table->integer('gestas')->nullable();
            $table->integer('partos')->nullable();
            $table->integer('cesareas')->nullable();
            $table->integer('abortos')->nullable();

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
        Schema::dropIfExists('antecedentes_gineco_obstetricos');
    }
};
