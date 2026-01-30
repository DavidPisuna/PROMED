<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InmunizacionDetalle extends Model
{
    use HasFactory;

    protected $table = 'inmunizacion_detalles';

    protected $fillable = [
        'inmunizacion_id',
        'vacuna',
        'dosis',
        'fecha',
        'lote',
        'esquema_completo',
        'responsable_vacunacion',
        'establecimiento_salud',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'esquema_completo' => 'boolean',
    ];

    // 🔗 Relación
    public function inmunizacion()
    {
        return $this->belongsTo(Inmunizacion::class);
    }
}
