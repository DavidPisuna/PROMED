<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenGineco extends Model
{
    use HasFactory;

    protected $table = 'examenes_ginecos'; // <- Aquí

    protected $fillable = [
        'antecedente_gineco_id', 'examen_realizado', 'tiempo_meses', 'resultado'
    ];

    public function antecedenteGineco()
    {
        return $this->belongsTo(AntecedenteGinecoObstetrico::class, 'antecedente_gineco_id');
    }
}