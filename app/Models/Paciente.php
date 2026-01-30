<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';

    /**
     * Campos que se pueden asignar en masa
     */
    protected $fillable = [
        'primer_apellido',
        'segundo_apellido',
        'primer_nombre',
        'segundo_nombre',
        'cedula_identidad',
        'codigo_empleado',
        'sexo',
        'grupo_sanguineo',
        'lateralidad',
        'fecha_nacimiento',
        'sucursal_id',
        'activo',
    ];

    /**
     * Conversión de tipos
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * 🔗 Relación: un paciente pertenece a una sucursal
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    /**
     * (Opcional) Nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim(
            "{$this->primer_nombre} {$this->segundo_nombre} {$this->primer_apellido} {$this->segundo_apellido}"
        );
    }
     // Relación con registros
    public function registros()
    {
        return $this->hasMany(Registro::class); // Asumiendo paciente_id como FK
    }

    protected $appends = ['edad'];

    public function getEdadAttribute()
    {
        if (!$this->fecha_nacimiento) {
            return null;
        }

        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    public function inmunizaciones()
    {
        return $this->hasMany(Inmunizacion::class);
    }

}
