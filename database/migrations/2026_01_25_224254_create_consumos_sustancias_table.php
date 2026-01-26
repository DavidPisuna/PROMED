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
        Schema::create('consumos_sustancias', function (Blueprint $table) {
             $table->id();
            $table->foreignId('registro_id')->constrained('registros')->onDelete('cascade');    

            // CONSUMO DE SUSTANCIAS
            $table->enum('tabaco_estado', ['activo', 'ex_consumidor', 'no_consume'])->default('no_consume');
            $table->integer('tabaco_tiempo_consumo')->nullable();
            $table->integer('tabaco_tiempo_abstinencia')->nullable();
            
            $table->enum('alcohol_estado', ['activo', 'ex_consumidor', 'no_consume'])->default('no_consume');
            $table->integer('alcohol_tiempo_consumo')->nullable();
            $table->integer('alcohol_tiempo_abstinencia')->nullable();
            
            $table->enum('otras_sustancias_estado', ['activo', 'ex_consumidor', 'no_consume'])->default('no_consume');
            $table->string('otras_sustancias_cual')->nullable();
            $table->integer('otras_sustancias_tiempo_consumo')->nullable();
            $table->integer('otras_sustancias_tiempo_abstinencia')->nullable();

            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumos_sustancias');
    }
};
