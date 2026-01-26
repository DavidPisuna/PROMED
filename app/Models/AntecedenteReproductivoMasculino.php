<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteReproductivoMasculino extends Model
{
    use HasFactory;

    protected $table = 'antecedentes_reproductivos_masculinos';

    protected $fillable = [
        'registro_id',
        'planificacion_si',
        'planificacion_cual',
        'planificacion_no',
        'planificacion_no_responde',
    ];

    /**
     * Relación con el registro del paciente
     */
    public function registro()
    {
        return $this->belongsTo(Registro::class, 'registro_id');
    }

    /**
     * Relación con los exámenes masculinos
     */
    public function examenes()
    {
        return $this->hasMany(ExamenMasculino::class, 'antecedente_mascu_id');
    }
}