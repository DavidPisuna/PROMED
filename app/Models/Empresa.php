<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue convención)
    protected $table = 'empresas';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'nombre',
        'actividad_economica',
        'ruc',
        'direccion',
        'representante_legal',
        'ciiu',
        'activo',
    ];

    // Casting para convertir automáticamente 'activo' en boolean
    protected $casts = [
        'activo' => 'boolean',
    ];

    // Scopes útiles
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    public function scopeInactivas($query)
    {
        return $query->where('activo', false);
    }
}