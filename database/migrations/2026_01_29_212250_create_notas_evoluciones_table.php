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
        Schema::create('notas_evoluciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->onDelete('cascade');

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->onDelete('cascade');

            $table->foreignId('doctor_id')
                ->constrained('doctores')
                ->onDelete('cascade');

            $table->date('fecha');
            $table->time('hora');

            $table->string('problemas', 255)->nullable();
            $table->text('evolucion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_evoluciones');
    }
};
