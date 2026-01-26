<?php

namespace App\Http\Controllers;


use App\Models\Registro;
use App\Models\AntecedenteGinecoObstetrico;
use App\Models\ExamenGineco;
use Illuminate\Http\Request;

class AntecedenteGinecoObstetricoController extends Controller
{
    // Mostrar formulario para crear antecedentes gineco para un registro
    
    public function create(Registro $registro)
    {
        return view('admin.antecedentes_gineco_obstetricos.create', compact('registro'));
    }

    // Guardar antecedentes gineco junto con los exámenes
    public function store(Request $request, Registro $registro)
    {
        $validated = $request->validate([
            'fecha_ultima_menstruacion' => 'nullable|date',
            'gestas' => 'nullable|integer|min:0',
            'partos' => 'nullable|integer|min:0',
            'cesareas' => 'nullable|integer|min:0',
            'abortos' => 'nullable|integer|min:0',
            'planificacion_si' => 'nullable|boolean',
            'planificacion_cual' => 'nullable|string|max:255',
            'planificacion_no' => 'nullable|boolean',
            'planificacion_no_responde' => 'nullable|boolean',

            // Validación de exámenes
            'examen_realizado.*' => 'required|string|max:255',
            'tiempo_meses.*' => 'nullable|integer|min:0',
            'resultado.*' => 'nullable|string',
        ]);

        // Crear el antecedente gineco asociado al registro
        $antecedente = $registro->antecedenteGineco()->create($validated);

        // Guardar exámenes si se envían
        if ($request->has('examen_realizado')) {
            foreach ($request->examen_realizado as $key => $nombre) {
                $antecedente->examenes()->create([
                    'examen_realizado' => $nombre,
                    'tiempo_meses' => $request->tiempo_meses[$key] ?? null,
                    'resultado' => $request->resultado[$key] ?? null,
                ]);
            }
        }

       return redirect()->route('admin.consumos.create', $registro)
                     ->with('success', 'Antecedente gineco-obstétrico creado. Ahora registra el consumo de sustancias.');
    }

    // Mostrar formulario para editar antecedente gineco
    public function edit(AntecedenteGinecoObstetrico $antecedenteGineco)
    {
        $registro = $antecedenteGineco->registro;
        $antecedenteGineco->load('examenes');
        return view('admin.antecedentes_gineco_obstetricos.edit', compact('registro', 'antecedenteGineco'));
    }

    // Actualizar antecedente gineco y exámenes
    public function update(Request $request, AntecedenteGinecoObstetrico $antecedenteGineco)
    {
        $validated = $request->validate([
            'fecha_ultima_menstruacion' => 'nullable|date',
            'gestas' => 'nullable|integer|min:0',
            'partos' => 'nullable|integer|min:0',
            'cesareas' => 'nullable|integer|min:0',
            'abortos' => 'nullable|integer|min:0',
            'planificacion_si' => 'nullable|boolean',
            'planificacion_cual' => 'nullable|string|max:255',
            'planificacion_no' => 'nullable|boolean',
            'planificacion_no_responde' => 'nullable|boolean',

            'examen_realizado.*' => 'required|string|max:255',
            'tiempo_meses.*' => 'nullable|integer|min:0',
            'resultado.*' => 'nullable|string',
        ]);

        // Actualizar el antecedente gineco
        $antecedenteGineco->update($validated);

        // Eliminar los exámenes antiguos y guardar los nuevos
        $antecedenteGineco->examenes()->delete();

        if ($request->has('examen_realizado')) {
            foreach ($request->examen_realizado as $key => $nombre) {
                $antecedenteGineco->examenes()->create([
                    'examen_realizado' => $nombre,
                    'tiempo_meses' => $request->tiempo_meses[$key] ?? null,
                    'resultado' => $request->resultado[$key] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.registros.show', $antecedenteGineco->registro)
                         ->with('success', 'Antecedente gineco-obstétrico actualizado correctamente.');
    }

    // Mostrar detalle del antecedente gineco (opcional)
    public function show(AntecedenteGinecoObstetrico $antecedenteGineco)
    {
        $antecedenteGineco->load('examenes', 'registro');
        return view('admin.antecedentes_gineco_obstetricos.show', compact('antecedenteGineco'));
    }
}