<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteGinecoObstetrico extends Model
{
    use HasFactory;

    protected $table = 'antecedentes_gineco_obstetricos'; // <- especificar la tabla exacta

    protected $fillable = [
        'registro_id',
        'fecha_ultima_menstruacion',
        'gestas',
        'partos',
        'cesareas',
        'abortos',
        'planificacion_si',
        'planificacion_cual',
        'planificacion_no',
        'planificacion_no_responde',
    ];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }

    public function examenes()
    {
        return $this->hasMany(ExamenGineco::class, 'antecedente_gineco_id');
    }

}