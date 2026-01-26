<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puestos';

    protected $fillable = ['registro_id', 'nombre_puesto'];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }

    public function actividades()
    {
        return $this->hasMany(PuestoActividad::class, 'puesto_id');
    }
}