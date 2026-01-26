<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstanteVital extends Model
{
    use HasFactory;

    protected $table ='constantes_vitales';
    
    protected $fillable = [
        'registro_id',
        'temperatura',
        'presion_arterial',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'saturacion_oxigeno',
        'peso',
        'talla',
        'imc',
        'categoria_imc',
        'perimetro_abdominal',
        'enfermedad_actual',
    ];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
    
}