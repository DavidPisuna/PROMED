<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadExtra extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'actividades_extras';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'registro_id',
        'tipo_actividad',
        'fecha',
    ];

    // Cast para el campo fecha
    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Relación con Registro
     */
    public function registro()
    {
        return $this->belongsTo(Registro::class, 'registro_id');
    }
}