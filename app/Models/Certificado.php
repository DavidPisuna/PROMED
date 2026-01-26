<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $table = 'certificados';

    /**
     * Campos que se pueden asignar de forma masiva (mass assignment)
     */
    protected $fillable = [
        'empresa_id',
        'paciente_id',
        'doctor_id',
        'tipo',
        'puesto',
        'fecha_emision',
        'observaciones',
        'aptitud',
        'observa_aptitud',
        'descripcion_reco',
        'observa_reco',
    ];

    /**
     * Relaciones
     */
    
    protected $casts = [
        'fecha_emision' => 'date',
    ];
    // Un certificado pertenece a una empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // Un certificado pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Un certificado pertenece a un doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Accesor opcional: concatenar tipo y aptitud (ejemplo de uso)
     */
    public function getResumenAttribute()
    {
        return ucfirst($this->tipo) . ' - ' . ucfirst($this->aptitud);
    }
}