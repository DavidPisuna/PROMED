<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\CentroTrabajo;

class CentroTrabajoController extends Controller
{
    // Mostrar formulario de creación
    public function create(Registro $registro)
    {
        return view('admin.centros_trabajos.create', compact('registro'));
    }

    // Guardar centro de trabajo
    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'nombre_centro_trabajo.*' => 'required|string|max:150',
            'actividades_desempenadas.*' => 'required|string',
            'tipo_trabajo.*' => 'required|in:anterior,actual',
        ]);

        // Recorremos cada bloque de centro
        foreach ($request->nombre_centro_trabajo as $index => $nombre) {
            $registro->centros()->create([
                'nombre_centro_trabajo' => $nombre,
                'actividades_desempenadas' => $request->actividades_desempenadas[$index],
                'tipo_trabajo' => $request->tipo_trabajo[$index],
                'tiempo_trabajo' => $request->tiempo_trabajo[$index] ?? null,
                'incidente' => isset($request->incidente[$index]),
                'accidente' => isset($request->accidente[$index]),
                'enfermedad_profesional' => isset($request->enfermedad_profesional[$index]),
                'calificado_iess' => isset($request->calificado_iess[$index]),
                'fecha_calificacion' => $request->fecha_calificacion[$index] ?? null,
                'especificar' => $request->especificar[$index] ?? null,
                'observaciones' => $request->observaciones[$index] ?? null,
            ]);
        }

        return redirect()
            ->route('admin.actividades_extras.create', $registro)
            ->with('success', 'Centros de trabajo agregados correctamente.');
    }


    // Mostrar formulario de edición
    public function edit(Registro $registro, CentroTrabajo $centro)
    {
        return view('admin.centros_trabajos.edit', compact('registro', 'centro'));
    }



    // Actualizar centro de trabajo
    // Actualizar centro de trabajo
    // Actualizar un centro de trabajo
    public function update(Request $request, Registro $registro, CentroTrabajo $centro)
    {
        $request->validate([
            'nombre_centro_trabajo' => 'required|string|max:150',
            'actividades_desempenadas' => 'required|string',
            'tipo_trabajo' => 'required|in:anterior,actual',
            'tiempo_trabajo' => 'nullable|string|max:50',
            'fecha_calificacion' => 'nullable|date',
            'especificar' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $centro->update([
            'nombre_centro_trabajo' => $request->nombre_centro_trabajo,
            'actividades_desempenadas' => $request->actividades_desempenadas,
            'tipo_trabajo' => $request->tipo_trabajo,
            'tiempo_trabajo' => $request->tiempo_trabajo,
            'incidente' => $request->has('incidente'),
            'accidente' => $request->has('accidente'),
            'enfermedad_profesional' => $request->has('enfermedad_profesional'),
            'calificado_iess' => $request->has('calificado_iess'),
            'fecha_calificacion' => $request->fecha_calificacion,
            'especificar' => $request->especificar,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('admin.registros.show', $registro)
                        ->with('success', 'Centro de trabajo actualizado correctamente.');
    }

    // Eliminar centro de trabajo
    public function destroy(Registro $registro, CentroTrabajo $centro)
    {
        $centro->delete();

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Centro de trabajo eliminado correctamente.');
    }

}