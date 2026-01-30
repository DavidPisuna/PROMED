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
        Schema::create('inmunizacion_detalles', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación padre
            $table->foreignId('inmunizacion_id')
                ->constrained('inmunizaciones')
                ->onDelete('cascade');

            // 💉 Datos de la vacuna (imagen)
            $table->string('vacuna', 100);
            $table->string('dosis', 20); // 1°, 2°, 3°, Única
            $table->date('fecha')->nullable();
            $table->string('lote', 50)->nullable();

            $table->boolean('esquema_completo')->default(false);

            $table->string('responsable_vacunacion', 150)->nullable();
            $table->string('establecimiento_salud', 150)->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inmunizacion_detalles');
    }
};
