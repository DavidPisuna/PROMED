<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroTrabajo extends Model
{
    use HasFactory;

    protected $table = 'centros_trabajos';

    protected $fillable = [
        'registro_id',
        'nombre_centro_trabajo',
        'actividades_desempenadas',
        'tipo_trabajo',
        'tiempo_trabajo',
        'incidente',
        'accidente',
        'enfermedad_profesional',
        'calificado_iess',
        'fecha_calificacion',
        'especificar',
        'observaciones',
    ];

    protected $casts = [
        'incidente' => 'boolean',
        'accidente' => 'boolean',
        'enfermedad_profesional' => 'boolean',
        'calificado_iess' => 'boolean',
        'fecha_calificacion' => 'date',
    ];

    // Relación con Registro
    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}