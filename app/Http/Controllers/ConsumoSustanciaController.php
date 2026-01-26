<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\ConsumoSustancia;
use App\Models\ActividadFisica;
use App\Models\MedicacionHabitual;

class ConsumoSustanciaController extends Controller
{
    /**
     * Mostrar formulario para crear consumos y estilos de vida
     */
    public function create($registroId)
    {
        $registro = Registro::findOrFail($registroId);
        return view('admin.consumos.create', compact('registro'));
    }

    /**
     * Guardar los consumos y estilos de vida
     */
    public function store(Request $request, $registroId)
    {
        $registro = Registro::findOrFail($registroId);

        // Validación general
        $validated = $request->validate([
            'tabaco_estado' => 'required|in:activo,ex_consumidor,no_consume',
            'tabaco_tiempo_consumo' => 'nullable|integer',
            'tabaco_tiempo_abstinencia' => 'nullable|integer',
            'alcohol_estado' => 'required|in:activo,ex_consumidor,no_consume',
            'alcohol_tiempo_consumo' => 'nullable|integer',
            'alcohol_tiempo_abstinencia' => 'nullable|integer',
            'otras_sustancias_estado' => 'required|in:activo,ex_consumidor,no_consume',
            'otras_sustancias_cual' => 'nullable|string',
            'otras_sustancias_tiempo_consumo' => 'nullable|integer',
            'otras_sustancias_tiempo_abstinencia' => 'nullable|integer',
            'observaciones' => 'nullable|string',
        ]);

        // Crear registro de consumo
        $consumo = $registro->consumoSustancia()->create($validated);

        // Actividades físicas
        if($request->has('actividad_fisica_cual')) {
            foreach($request->actividad_fisica_cual as $key => $actividad) {
                if($actividad) {
                    $consumo->actividadesFisicas()->create([
                        'realiza_actividad_fisica' => true,
                        'actividad_fisica_cual' => $actividad,
                        'actividad_fisica_tiempo' => $request->actividad_fisica_tiempo[$key] ?? null,
                        'actividad_fisica_frecuencia' => $request->actividad_fisica_frecuencia[$key] ?? null,
                    ]);
                }
            }
        }

        // Medicaciones habituales
        if($request->has('medicacion_habitual_cual')) {
            foreach($request->medicacion_habitual_cual as $key => $medicacion) {
                if($medicacion) {
                    $consumo->medicacionesHabituales()->create([
                        'toma_medicacion_habitual' => true,
                        'medicacion_habitual_cual' => $medicacion,
                        'medicacion_habitual_cantidad' => $request->medicacion_habitual_cantidad[$key] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.constantes_vitales.create', $registro)
                         ->with('success', 'Consumos y estilos de vida registrados correctamente.');
    }

    /**
     * Editar consumos y estilos de vida
     */
    public function edit($consumoId)
    {
        $consumo = ConsumoSustancia::with(['actividadesFisicas', 'medicacionesHabituales'])->findOrFail($consumoId);
        $registro = $consumo->registro;
        return view('admin.consumos.edit', compact('registro', 'consumo'));
    }

    /**
     * Actualizar consumos y estilos de vida
     */
    public function update(Request $request, $consumoId)
    {
        $consumo = ConsumoSustancia::findOrFail($consumoId);
        $registro = $consumo->registro;

        // Validación igual que en store
        $validated = $request->validate([
            'tabaco_estado' => 'required|in:activo,ex_consumidor,no_consume',
            'tabaco_tiempo_consumo' => 'nullable|integer',
            'tabaco_tiempo_abstinencia' => 'nullable|integer',
            'alcohol_estado' => 'required|in:activo,ex_consumidor,no_consume',
            'alcohol_tiempo_consumo' => 'nullable|integer',
            'alcohol_tiempo_abstinencia' => 'nullable|integer',
            'otras_sustancias_estado' => 'required|in:activo,ex_consumidor,no_consume',
            'otras_sustancias_cual' => 'nullable|string',
            'otras_sustancias_tiempo_consumo' => 'nullable|integer',
            'otras_sustancias_tiempo_abstinencia' => 'nullable|integer',
            'observaciones' => 'nullable|string',
        ]);

        // Actualizar consumo principal
        $consumo->update($validated);

        // Reemplazar actividades físicas
        $consumo->actividadesFisicas()->delete();
        if($request->has('actividad_fisica_cual')) {
            foreach($request->actividad_fisica_cual as $key => $actividad) {
                if($actividad) {
                    $consumo->actividadesFisicas()->create([
                        'realiza_actividad_fisica' => true,
                        'actividad_fisica_cual' => $actividad,
                        'actividad_fisica_tiempo' => $request->actividad_fisica_tiempo[$key] ?? null,
                        'actividad_fisica_frecuencia' => $request->actividad_fisica_frecuencia[$key] ?? null,
                    ]);
                }
            }
        }

        // Reemplazar medicaciones habituales
        $consumo->medicacionesHabituales()->delete();
        if($request->has('medicacion_habitual_cual')) {
            foreach($request->medicacion_habitual_cual as $key => $medicacion) {
                if($medicacion) {
                    $consumo->medicacionesHabituales()->create([
                        'toma_medicacion_habitual' => true,
                        'medicacion_habitual_cual' => $medicacion,
                        'medicacion_habitual_cantidad' => $request->medicacion_habitual_cantidad[$key] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.registros.show', $registro)
                         ->with('success', 'Consumos y estilos de vida actualizados correctamente.');
    }
}