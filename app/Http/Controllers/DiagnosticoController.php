<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Diagnostico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    /**
     * Mostrar formulario para crear un diagnóstico para un registro
     */
    public function create(Registro $registro)
    {
        return view('admin.diagnosticos.create', compact('registro'));
    }

    /**
     * Guardar un nuevo diagnóstico
     */
    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'cie10.*' => 'required|string|max:250',
            'descripcion.*' => 'required|string',
            'tipo_diagnostico.*' => 'required|in:presuntivo,definitivo',
        ]);

        foreach ($request->cie10 as $index => $cie10) {
            $registro->diagnosticos()->create([
                'cie10' => $cie10,
                'descripcion' => $request->descripcion[$index],
                'tipo_diagnostico' => $request->tipo_diagnostico[$index],
            ]);
        }

        return redirect()
            ->route('admin.aptitudes_medicas.create', $registro)
            ->with('success', 'Diagnósticos registrados correctamente');
    }


    /**
     * Mostrar detalle de un diagnóstico
     */
    public function show(Registro $registro, Diagnostico $diagnostico)
    {
        return view('admin.diagnosticos.show', compact('registro', 'diagnostico'));
    }

    /**
     * Mostrar formulario de edición de un diagnóstico
     */
    public function edit(Registro $registro, Diagnostico $diagnostico)
    {
        return view('admin.diagnosticos.edit', compact('registro', 'diagnostico'));
    }

    /**
     * Actualizar un diagnóstico
     */
    public function update(Request $request, Registro $registro, Diagnostico $diagnostico)
    {
        $request->validate([
            'cie10' => 'required|string|max:250',
            'descripcion' => 'required|string',
            'tipo_diagnostico' => 'required|in:presuntivo,definitivo',
        ]);

        $diagnostico->update([
            'cie10' => $request->cie10,
            'descripcion' => $request->descripcion,
            'tipo_diagnostico' => $request->tipo_diagnostico,
        ]);

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Diagnóstico actualizado correctamente');
    }

    /**
     * Eliminar un diagnóstico
     */
    public function destroy(Registro $registro, Diagnostico $diagnostico)
    {
        $diagnostico->delete();

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Diagnóstico eliminado correctamente');
    }
}