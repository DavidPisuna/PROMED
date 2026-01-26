<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoActividad extends Model
{
    use HasFactory;

    protected $table = 'puestos_actividades';

    protected $fillable = ['puesto_id', 'nombre_actividad'];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id');
    }

    public function factoresRiesgo()
    {
        return $this->hasMany(ActividadFactorRiesgo::class, 'puesto_actividad_id');
    }
}