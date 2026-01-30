<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmunizacion extends Model
{
    use HasFactory;

    protected $table = 'inmunizaciones';

    protected $fillable = [
        'empresa_id',
        'paciente_id',
        'doctor_id',
        'observaciones_generales',
    ];

    // 🔗 Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function detalles() {
    return $this->hasMany(InmunizacionDetalle::class, 'inmunizacion_id');
    }
}
