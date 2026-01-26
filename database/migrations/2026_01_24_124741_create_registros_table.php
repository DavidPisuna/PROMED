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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            // Relaciones
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctores')->onDelete('cascade');

            // Información del registro
            $table->enum('tipo', ['ingreso', 'periodica', 'retiro','reintegro']);
            $table->string('atencion_prioritaria', 100)->nullable();  //Embarazada, Persona con Discapacidad,E.Catastrófica, lactancia,Adulto Mayor 
            $table->string('puesto', 100)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_periodica')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->date('fecha_reintegro')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
