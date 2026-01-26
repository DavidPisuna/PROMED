<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetiroEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'retiros_evaluaciones';

    protected $fillable = [
        'registro_id',
        'se_realiza_evaluacion',
        'condicion_salud_relacionada',
        'observaciones',
    ];

    /**
     * Relación con registro
     */
    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}