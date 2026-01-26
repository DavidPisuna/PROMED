<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'registros';

    protected $fillable = [
        'empresa_id',
        'paciente_id',
        'doctor_id',
        'tipo', // ingreso, periodica, retiro,reintegro
        'puesto',
        'atencion_prioritaria',
        'fecha_ingreso',
        'fecha_periodica',
        'fecha_reintegro',
        'fecha_retiro',
        'observaciones',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_periodica' => 'date',
        'fecha_reintegro' => 'date',
        'fecha_retiro' => 'date',
    ];

    // Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function antecedentePatologico()
    {
        return $this->hasOne(AntecedentePatologico::class, 'registro_id');
    }
    
    public function antecedenteGineco()
    {
        return $this->hasOne(AntecedenteGinecoObstetrico::class, 'registro_id');
    }

    public function antecedenteMasculino()
    {
        return $this->hasOne(AntecedenteReproductivoMasculino::class, 'registro_id');
    }

    public function consumoSustancia()
    {
        return $this->hasOne(ConsumoSustancia::class);
    }

    // Relación directa a actividades físicas a través del consumo
    public function actividadesFisicas()
    {
        return $this->hasManyThrough(
            ActividadFisica::class,
            ConsumoSustancia::class,
            'registro_id',        // FK de ConsumoSustancia hacia Registro
            'consumo_sustancia_id', // FK de ActividadFisica hacia ConsumoSustancia
            'id',                 // PK de Registro
            'id'                  // PK de ConsumoSustancia
        );
    }

    // Relación directa a medicaciones habituales a través del consumo
    public function medicacionesHabituales()
    {
        return $this->hasManyThrough(
            MedicacionHabitual::class,
            ConsumoSustancia::class,
            'registro_id',
            'consumo_sustancia_id',
            'id',
            'id'
        );
    }

    // Relación con Constante Vital
    public function constanteVital()
    {
        return $this->hasOne(ConstanteVital::class);
    }

    public function examenesFisicos()
    {
        return $this->hasMany(ExamenFisico::class);
    }

    
    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'registro_id');
    }

    public function actividadesPuestos()
    {
        return $this->hasManyThrough(
            PuestoActividad::class,
            Puesto::class,
            'registro_id', // FK en Puesto
            'puesto_id',   // FK en PuestoActividad
            'id',          // PK en Registro
            'id'           // PK en Puesto
        );
    }

    // ⚠️ CORRECCIÓN: no se puede usar hasManyThrough con 3 niveles
    // por eso usamos un accessor (getter) para traer todos los factores.
    public function getFactoresRiesgoAttribute()
    {
        return $this->puestos()
            ->with('actividades.factoresRiesgo')
            ->get()
            ->pluck('actividades')
            ->flatten()
            ->pluck('factoresRiesgo')
            ->flatten();
    }

    // ============================================================
    // 🔹 MÉTODOS AUXILIARES
    // ============================================================

    public function getCantidadPuestosAttribute()
    {
        return $this->puestos()->count();
    }

    public function tienePuestos()
    {
        return $this->puestos()->exists();
    }

    public function puestosCompletos()
    {
        return $this->puestos()->with(['actividades.factoresRiesgo'])->get();
    }

    public function centros()
    {
        return $this->hasMany(CentroTrabajo::class, 'registro_id');
    }
    public function actividadesExtras()
    {
        return $this->hasMany(ActividadExtra::class, 'registro_id');
    }
    public function resultadosExamenes()
    {
        return $this->hasMany(ResultadoExamen::class, 'registro_id');
    }

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class);
    }
    public function aptitudesMedicas()
    {
        return $this->hasMany(AptitudMedica::class);
    }
    public function retirosEvaluaciones()
    {
        return $this->hasMany(RetiroEvaluacion::class);
    }


    
}