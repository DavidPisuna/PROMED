<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoSustancia extends Model
{
    use HasFactory;

    protected $table = 'consumos_sustancias';

    protected $fillable = [
        'registro_id',
        'tabaco_estado',
        'tabaco_tiempo_consumo',
        'tabaco_tiempo_abstinencia',
        'alcohol_estado',
        'alcohol_tiempo_consumo',
        'alcohol_tiempo_abstinencia',
        'otras_sustancias_estado',
        'otras_sustancias_cual',
        'otras_sustancias_tiempo_consumo',
        'otras_sustancias_tiempo_abstinencia',
        'observaciones',
    ];

    // Relación con registro
    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }

    // Relación con actividades físicas
    public function actividadesFisicas()
    {
        return $this->hasMany(ActividadFisica::class);
    }

    // Relación con medicaciones habituales
    public function medicacionesHabituales()
    {
        return $this->hasMany(MedicacionHabitual::class);
    }
}