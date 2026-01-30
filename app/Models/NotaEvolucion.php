<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaEvolucion extends Model
{
    protected $table = 'notas_evoluciones';

    protected $fillable = [
        'empresa_id',
        'paciente_id',
        'doctor_id',
        'fecha',
        'hora',
        'problemas',
        'evolucion',
    ];

    // 🔗 Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}

