<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctores';

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'especialidad',
        'numero_licencia',
        'telefono',
        'email',
        'direccion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Nombre completo del doctor
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->primer_nombre} {$this->segundo_nombre} {$this->primer_apellido} {$this->segundo_apellido}");
    }

    public function registros()
    {
        return $this->hasMany(Registro::class, 'doctor_id');
    }
    

    public function inmunizaciones()
    {
        return $this->hasMany(Inmunizacion::class);
    }

}