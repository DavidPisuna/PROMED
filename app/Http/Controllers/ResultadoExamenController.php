<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\ResultadoExamen;
use Illuminate\Http\Request;

class ResultadoExamenController extends Controller
{
    /**
     * Mostrar formulario de creación de un resultado de examen para un registro
     */
    public function create(Registro $registro)
    {
        return view('admin.resultados_examenes.create', compact('registro'));
    }

    /**
     * Guardar el resultado de examen
     */
    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'nombre_examen.*' => 'required|string|max:255',
            'fecha_examen.*' => 'required|date',
            'resultados.*' => 'nullable|string',
        ]);

        foreach ($request->nombre_examen as $index => $nombre) {
            $registro->resultadosExamenes()->create([
                'nombre_examen' => $nombre,
                'fecha_examen' => $request->fecha_examen[$index],
                'resultados' => $request->resultados[$index] ?? null,
            ]);
        }

        return redirect()
            ->route('admin.diagnosticos.create', $registro)
            ->with('success', 'Resultados de exámenes registrados correctamente');
    }


    /**
     * Mostrar el detalle de un resultado de examen
     */
    public function show(Registro $registro, ResultadoExamen $resultadoExamen)
    {
        return view('admin.resultados_examenes.show', compact('registro', 'resultadoExamen'));
    }

    /**
     * Mostrar formulario de edición de un resultado de examen
     */
    public function edit(Registro $registro, ResultadoExamen $resultadoExamen)
    {
        return view('admin.resultados_examenes.edit', compact('registro', 'resultadoExamen'));
    }

    /**
     * Actualizar un resultado de examen
     */
    public function update(Request $request, Registro $registro, ResultadoExamen $resultadoExamen)
    {
        $request->validate([
            'nombre_examen' => 'required|string|max:255',
            'fecha_examen' => 'required|date',
            'resultados' => 'nullable|string',
        ]);

        $resultadoExamen->update([
            'nombre_examen' => $request->nombre_examen,
            'fecha_examen' => $request->fecha_examen,
            'resultados' => $request->resultados,
        ]);

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Resultado de examen actualizado correctamente');
    }

    /**
     * Eliminar un resultado de examen
     */
    public function destroy(Registro $registro, ResultadoExamen $resultadoExamen)
    {
        $resultadoExamen->delete();

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Resultado de examen eliminado correctamente');
    }
}