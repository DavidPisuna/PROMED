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
        Schema::create('examenes_fisicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_id')
                  ->constrained('registros')
                  ->onDelete('cascade');

            $table->string('region'); // Ej: piel, ojos, oido, etc.
            $table->string('item');   // Ej: cicatrices, pupilas, motilidad
            $table->boolean('valor')->default(false); // Marcado sí/no
            $table->text('observacion')->nullable();  // Observaciones opcionales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examenes_fisicos');
    }
};
