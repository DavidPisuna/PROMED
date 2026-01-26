<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AptitudMedica extends Model
{
    use HasFactory;

    protected $table = 'aptitudes_medicas';

    protected $fillable = [
        'registro_id',
        'aptitud',
        'observaciones',
        'recomendaciones_tratamiento',
    ];

    /**
     * Relación con el modelo Registro
     * Una aptitud médica pertenece a un registro
     */
    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}