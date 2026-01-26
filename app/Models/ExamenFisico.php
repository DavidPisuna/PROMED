<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenFisico extends Model
{
    use HasFactory;

    protected $table = 'examenes_fisicos';

    protected $fillable = [
        'registro_id',
        'region',
        'item',
        'valor',
        'observacion',
    ];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}