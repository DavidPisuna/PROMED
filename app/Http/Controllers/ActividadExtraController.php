<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\ActividadExtra;

class ActividadExtraController extends Controller
{
    /**
     * Mostrar formulario de creación de actividad extra para un registro
     */
    public function create(Registro $registro)
    {
        return view('admin.actividades_extras.create', compact('registro'));
    }

    /**
     * Guardar nueva actividad extra
     */
    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'actividades' => 'required|array|min:1',
            'actividades.*.tipo_actividad' => 'required|string|max:255',
            'actividades.*.fecha' => 'nullable|date',
        ]);

        $actividadesInput = $request->input('actividades', []);

        foreach ($actividadesInput as $actividadData) {
            $registro->actividadesExtras()->create([
                'tipo_actividad' => $actividadData['tipo_actividad'],
                'fecha' => $actividadData['fecha'] ?? null,
            ]);
        }

        return redirect()
            ->route('admin.resultados_examenes.create', $registro)
            ->with('success', 'Actividades extras registradas correctamente');
    }


    /**
     * Mostrar detalle de la actividad extra
     */
    public function show(Registro $registro, ActividadExtra $actividadExtra)
    {
        return view('admin.actividades_extras.show', compact('registro', 'actividadExtra'));
    }

    /**
     * Mostrar formulario de edición de actividad extra
     */
    public function edit(Registro $registro, ActividadExtra $actividadExtra)
    {
        return view('admin.actividades_extras.edit', compact('registro', 'actividadExtra'));
    }

    /**
     * Actualizar actividad extra
     */
    public function update(Request $request, Registro $registro, ActividadExtra $actividadExtra)
    {
        $request->validate([
            'tipo_actividad' => 'required|string|max:255',
            'fecha' => 'nullable|date',
        ]);

        // Actualizar los campos directamente
        $actividadExtra->update([
            'tipo_actividad' => $request->tipo_actividad,
            'fecha' => $request->fecha,
        ]);

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Actividad extra actualizada correctamente');
    }


    /**
     * Eliminar actividad extra
     */
    public function destroy(Registro $registro, ActividadExtra $actividadExtra)
    {
        $actividadExtra->delete();

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Actividad extra eliminada correctamente.');
    }
}