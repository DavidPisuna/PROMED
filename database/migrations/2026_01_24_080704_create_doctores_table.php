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
        Schema::create('doctores', function (Blueprint $table) {
            $table->id();
            $table->string('primer_nombre', 50); // varchar(50) NOT NULL 
            $table->string('segundo_nombre', 50)->nullable(); // varchar(50) DEFAULT NULL 
            $table->string('primer_apellido', 50); // varchar(50) NOT NULL 
            $table->string('segundo_apellido', 50)->nullable(); // varchar(50) DEFAULT NULL 
            $table->string('especialidad', 100); // varchar(100) NOT NULL 
            $table->string('numero_licencia', 20)->unique(); // varchar(20) NOT NULL UNIQUE 
            $table->string('telefono', 15)->nullable(); // varchar(15) DEFAULT NULL 
            $table->string('email', 100)->nullable()->unique(); // varchar(100) DEFAULT NULL UNIQUE 
            $table->string('direccion')->nullable(); // varchar(255) DEFAULT NULL 
            $table->boolean('activo')->nullable(); // tinyint(1) DEFAULT NULL 
            $table->timestamps(); // created_at and updated_at 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctores');
    }
};
