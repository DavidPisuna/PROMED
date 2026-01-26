<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenMasculino extends Model
{
    use HasFactory;

    protected $table = 'examenes_masculinos';

    protected $fillable = [
        'antecedente_mascu_id',
        'examen_realizado',
        'tiempo_meses',
        'resultado',
    ];

    /**
     * Relación con el antecedente masculino
     */
    public function antecedenteMasculino()
    {
        return $this->belongsTo(AntecedenteReproductivoMasculino::class, 'antecedente_mascu_id');
    }
}