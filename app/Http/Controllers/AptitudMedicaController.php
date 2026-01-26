<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\AptitudMedica;
use Illuminate\Http\Request;

class AptitudMedicaController extends Controller
{
    public function create(Registro $registro)
    {
        return view('admin.aptitudes_medicas.create', compact('registro'));
    }

    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'aptitud' => 'required|in:apto,apto_observacion,apto_limitaciones,no_apto',
            'observaciones' => 'nullable|string',
            'recomendaciones_tratamiento' => 'nullable|string',
        ]);

        $registro->aptitudesMedicas()->create($request->all());

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Aptitud médica registrada correctamente');
    }

    public function show(Registro $registro, AptitudMedica $aptitudMedica)
    {
        return view('admin.aptitudes_medicas.show', compact('registro', 'aptitudMedica'));
    }

    public function edit(Registro $registro, AptitudMedica $aptitudMedica)
    {
        return view('admin.aptitudes_medicas.edit', compact('registro', 'aptitudMedica'));
    }

    public function update(Request $request, Registro $registro, AptitudMedica $aptitudMedica)
    {
        $request->validate([
            'aptitud' => 'required|in:apto,apto_observacion,apto_limitaciones,no_apto',
            'observaciones' => 'nullable|string',
            'recomendaciones_tratamiento' => 'nullable|string',
        ]);

        $aptitudMedica->update($request->all());

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Aptitud médica actualizada correctamente');
    }

    public function destroy(Registro $registro, AptitudMedica $aptitudMedica)
    {
        $aptitudMedica->delete();

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Aptitud médica eliminada correctamente');
    }
}