<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadFisica extends Model
{
    use HasFactory;

    protected $table = 'actividades_fisicas'; // <- especificar la tabla exacta

    protected $fillable = [
        'consumo_sustancia_id',
        'actividad_fisica_cual',
        'actividad_fisica_tiempo',
        'actividad_fisica_frecuencia',
    ];

    // Relación con consumo de sustancias
    public function consumoSustancia()
    {
        return $this->belongsTo(ConsumoSustancia::class);
    }
}