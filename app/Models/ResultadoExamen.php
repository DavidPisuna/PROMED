<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoExamen extends Model
{
    use HasFactory;

    protected $table = 'resultados_examenes';

    protected $fillable = [
        'registro_id',
        'nombre_examen',
        'fecha_examen',
        'resultados',
    ];

    protected $casts = [
        'fecha_examen' => 'date',
    ];

    // Relación con Registro
    public function registro()
    {
        return $this->belongsTo(Registro::class, 'registro_id');
    }
}