<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadFactorRiesgo extends Model
{
    use HasFactory;

    protected $table = 'actividades_factores_riesgos';

    protected $fillable = ['puesto_actividad_id', 'categoria', 'factor_riesgo'];

    public function actividad()
    {
        return $this->belongsTo(PuestoActividad::class, 'puesto_actividad_id');
    }
}