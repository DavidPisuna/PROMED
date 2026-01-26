<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\RetiroEvaluacion;
use Illuminate\Http\Request;

class RetiroEvaluacionController extends Controller
{
    public function create(Registro $registro)
    {
        // Validar que solo se pueda crear si el tipo de registro es "Retiro"
        if ($registro->tipo !== 'retiro') {
            return redirect()
                ->route('admin.registros.show', $registro)
                ->with('error', 'Solo se pueden crear evaluaciones para registros de tipo Retiro.');
        }

        return view('admin.retiros_evaluaciones.create', compact('registro'));
    }


    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'se_realiza_evaluacion' => 'required|boolean',
            'condicion_salud_relacionada' => 'required|boolean',
            'observaciones' => 'nullable|string',
        ]);

        $registro->retirosEvaluaciones()->create($request->all());

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Evaluación registrada correctamente');
    }

    public function show(Registro $registro, RetiroEvaluacion $retiroEvaluacion)
    {
        return view('admin.retiros_evaluaciones.show', compact('registro', 'retiroEvaluacion'));
    }

    public function edit(Registro $registro, RetiroEvaluacion $retiroEvaluacion)
    {
        return view('admin.retiros_evaluaciones.edit', compact('registro', 'retiroEvaluacion'));
    }

    public function update(Request $request, Registro $registro, RetiroEvaluacion $retiroEvaluacion)
    {
        $request->validate([
            'se_realiza_evaluacion' => 'required|boolean',
            'condicion_salud_relacionada' => 'required|boolean',
            'observaciones' => 'nullable|string',
        ]);

        $retiroEvaluacion->update($request->all());

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Evaluación actualizada correctamente');
    }

    public function destroy(Registro $registro, RetiroEvaluacion $retiroEvaluacion)
    {
        $retiroEvaluacion->delete();

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Evaluación eliminada correctamente');
    }
}