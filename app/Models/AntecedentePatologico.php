<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentePatologico extends Model
{
    use HasFactory;

    protected $table = 'antecedentes_patologicos';

    protected $fillable = [
        'registro_id',
        'antecedente_app',                  // Antecedentes clínicos y quirúrgicos
        'antecedente_apqx',                 // Antecedentes familiares
        'autoriza_transfusiones',           // BOOLEAN: Sí/No
        'tratamiento_hormonal_si_no',       // BOOLEAN: Sí/No
        'tratamiento_hormonal_descripcion', // TEXT: descripción si aplica
    ];

    protected $casts = [
        'autoriza_transfusiones' => 'boolean',
        'tratamiento_hormonal_si_no' => 'boolean',
    ];

    /**
     * Relación con Registro
     */
    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}