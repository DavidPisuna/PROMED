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
        Schema::create('examenes_ginecos', function (Blueprint $table) {
            $table->id();

             // Relación con antecedente gineco
            $table->foreignId('antecedente_gineco_id')->constrained('antecedentes_gineco_obstetricos')->onDelete('cascade');

            // Datos del examen
            $table->string('examen_realizado');
            $table->integer('tiempo_meses')->nullable();
            $table->text('resultado')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examenes_ginecos');
    }
};
