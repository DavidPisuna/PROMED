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
        Schema::create('medicaciones_habituales', function (Blueprint $table) {
           $table->id();
            $table->foreignId('consumo_sustancia_id')->constrained('consumos_sustancias')->onDelete('cascade');
            $table->text('medicacion_habitual_cual')->nullable();
            $table->string('medicacion_habitual_cantidad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicaciones_habituales');
    }
};
