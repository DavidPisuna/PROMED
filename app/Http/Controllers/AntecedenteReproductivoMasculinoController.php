<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\AntecedenteReproductivoMasculino;
use App\Models\ExamenMasculino;
use Illuminate\Http\Request;

class AntecedenteReproductivoMasculinoController extends Controller
{
    /**
     * Mostrar formulario para crear antecedentes reproductivos masculinos
     */
    public function create($registroId)
    {
        $registro = Registro::with('paciente')->findOrFail($registroId);

        // Evitar duplicados
        if ($registro->antecedenteMasculino) {
            return redirect()
                ->route('admin.antecedentes_masculinos.edit', $registro->antecedenteMasculino)
                ->with('info', 'Este registro ya tiene antecedentes reproductivos masculinos.');
        }

        return view('admin.antecedentes_masculinos.create', compact('registro'));
    }

    /**
     * Guardar antecedentes reproductivos masculinos
     */
    public function store(Request $request, $registroId)
    {
        $registro = Registro::with('paciente')->findOrFail($registroId);

        $validated = $request->validate([
            'planificacion_si' => 'nullable|boolean',
            'planificacion_cual' => 'nullable|string|max:255',
            'planificacion_no' => 'nullable|boolean',
            'planificacion_no_responde' => 'nullable|boolean',
        ]);

        // Forzar checkbox
        $validated['planificacion_si'] = $request->boolean('planificacion_si');
        $validated['planificacion_no'] = $request->boolean('planificacion_no');
        $validated['planificacion_no_responde'] = $request->boolean('planificacion_no_responde');

        // Crear antecedente
        $antecedente = $registro->antecedenteMasculino()->create($validated);

        // Guardar exámenes
        if ($request->filled('examen_realizado')) {
            foreach ($request->examen_realizado as $key => $nombre) {
                $antecedente->examenes()->create([
                    'examen_realizado' => $nombre,
                    'tiempo_meses' => $request->tiempo_meses[$key] ?? null,
                    'resultado' => $request->resultado[$key] ?? null,
                ]);
            }
        }

        return redirect()
            ->route('admin.consumos.create', $registro->id)
            ->with(
                'success',
                'Antecedentes reproductivos masculinos guardados correctamente. Ahora registra el consumo de sustancias.'
            );
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(AntecedenteReproductivoMasculino $antecedenteMasculino)
{
    // Cargamos la relación 'examenes' que pertenece al antecedente, no al registro
    $antecedenteMasculino->load('examenes');
    
    // Obtenemos el registro para mostrar datos del paciente si es necesario
    $registro = $antecedenteMasculino->registro; 

    return view(
        'admin.antecedentes_masculinos.edit',
        compact('antecedenteMasculino', 'registro')
    );
}

    /**
     * Actualizar antecedentes reproductivos masculinos
     */
    public function update(Request $request, AntecedenteReproductivoMasculino $antecedenteMasculino)
    {
        $validated = $request->validate([
            'planificacion_si' => 'nullable|boolean',
            'planificacion_cual' => 'nullable|string|max:255',
            'planificacion_no' => 'nullable|boolean',
            'planificacion_no_responde' => 'nullable|boolean',
        ]);

        $validated['planificacion_si'] = $request->boolean('planificacion_si');
        $validated['planificacion_no'] = $request->boolean('planificacion_no');
        $validated['planificacion_no_responde'] = $request->boolean('planificacion_no_responde');

        $antecedenteMasculino->update($validated);

        // Reemplazar exámenes
        $antecedenteMasculino->examenes()->delete();

        if ($request->filled('examen_realizado')) {
            foreach ($request->examen_realizado as $key => $nombre) {
                $antecedenteMasculino->examenes()->create([
                    'examen_realizado' => $nombre,
                    'tiempo_meses' => $request->tiempo_meses[$key] ?? null,
                    'resultado' => $request->resultado[$key] ?? null,
                ]);
            }
        }

        return redirect()
            ->route('admin.registros.show', $antecedenteMasculino->registro_id)
            ->with('success', 'Antecedentes reproductivos masculinos actualizados correctamente.');
    }

    /**
     * Mostrar detalle
     */
    public function show(AntecedenteReproductivoMasculino $antecedenteMasculino)
{
    // Misma lógica: cargar exámenes desde el modelo correcto
    $antecedenteMasculino->load('examenes');
    $registro = $antecedenteMasculino->registro;

    return view(
        'admin.antecedentes_masculinos.show',
        compact('antecedenteMasculino', 'registro')
    );
}
}
