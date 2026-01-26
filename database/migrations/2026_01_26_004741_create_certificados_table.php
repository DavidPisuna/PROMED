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
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();

        // 🔗 Relaciones (con foreign keys)
        $table->foreignId('empresa_id')
            ->constrained('empresas')
            ->onDelete('cascade');

        $table->foreignId('paciente_id')
            ->constrained('pacientes')
            ->onDelete('cascade');

        $table->foreignId('doctor_id')
            ->constrained('doctores')
            ->onDelete('cascade');

        // 📄 Tipo de certificado
        $table->enum('tipo', ['ingreso', 'periodica', 'retiro', 'reintegro']);

        // 💼 Información del puesto / fechas
        $table->string('puesto', 100)->nullable();
        $table->date('fecha_emision')->nullable();

        // 🧑‍⚕️ Aptitud del paciente
        // ⚠️ Cambié "aptop" por "apto" porque parece ser un error tipográfico
        $table->enum('aptitud', ['apto', 'apto en observacion', 'apto con limitacion', 'no apto']);
        $table->text('observa_aptitud')->nullable();

        // 🧾 Recomendaciones
        $table->text('descripcion_reco')->nullable();
        $table->text('observa_reco')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
