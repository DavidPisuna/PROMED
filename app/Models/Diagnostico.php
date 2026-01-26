<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue convención)
    protected $table = 'diagnosticos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'registro_id',
        'cie10',
        'descripcion',
        'tipo_diagnostico',
    ];

    /**
     * Relación con el modelo Registro
     * Un diagnóstico pertenece a un registro
     */
    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}