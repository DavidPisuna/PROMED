<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicacionHabitual extends Model
{
    use HasFactory;

    protected $table = 'medicaciones_habituales';

    protected $fillable = [
        'consumo_sustancia_id',
        'medicacion_habitual_cual',
        'medicacion_habitual_cantidad',
    ];

    // Relación con consumo de sustancias
    public function consumoSustancia()
    {
        return $this->belongsTo(ConsumoSustancia::class);
    }
}