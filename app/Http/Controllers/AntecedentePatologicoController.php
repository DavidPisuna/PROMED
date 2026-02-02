<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AntecedentePatologico;
use App\Models\Registro;

class AntecedentePatologicoController extends Controller
{
    /**
     * Mostrar formulario para crear antecedentes patológicos
     */
    public function create($registro_id)
    {
        $registro = Registro::with('paciente')->findOrFail($registro_id);

        // Evitar duplicados (1 antecedente por registro)
        if ($registro->antecedentePatologico) {
            return redirect()
                ->route('admin.antecedentes_patologicos.edit', $registro->antecedentePatologico)
                ->with('info', 'Este registro ya tiene antecedentes patológicos.');
        }

        return view('admin.antecedentes_patologicos.create', compact('registro'));
    }

    /**
     * Guardar antecedentes patológicos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registro_id' => 'required|exists:registros,id',
            'antecedente_app' => 'nullable|string',
            'antecedente_apqx' => 'nullable|string',
            'autoriza_transfusiones' => 'nullable|boolean',
            'tratamiento_hormonal_si_no' => 'nullable|boolean',
            'tratamiento_hormonal_descripcion' => 'nullable|string',
        ]);

        // Forzar booleanos (checkbox)
        $validated['autoriza_transfusiones'] = $request->boolean('autoriza_transfusiones');
        $validated['tratamiento_hormonal_si_no'] = $request->boolean('tratamiento_hormonal_si_no');

        $registro = Registro::with('paciente')->findOrFail($validated['registro_id']);

        // Crear antecedente asociado al registro
        $antecedente = $registro->antecedentePatologico()->create($validated);

        // Flujo según sexo
        return $this->redirectPorSexo($registro);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(AntecedentePatologico $antecedente)
    {
        // Cargamos el registro y el paciente para mostrar la info en la vista
        $registro = $antecedente->registro()->with('paciente', 'doctor')->first();
        
        return view('admin.antecedentes_patologicos.edit', compact('antecedente', 'registro'));
    }

    /**
     * Actualizar antecedentes patológicos
     */
    public function update(Request $request, AntecedentePatologico $antecedente)
    {
        $data = $request->validate([
            'antecedente_app' => 'nullable|string',
            'antecedente_apqx' => 'nullable|string',
            'autoriza_transfusiones' => 'nullable|boolean',
            'tratamiento_hormonal_si_no' => 'nullable|boolean',
            'tratamiento_hormonal_descripcion' => 'nullable|string',
        ]);

        $data['autoriza_transfusiones'] = $request->boolean('autoriza_transfusiones');
        $data['tratamiento_hormonal_si_no'] = $request->boolean('tratamiento_hormonal_si_no');

        $antecedente->update($data);

        return redirect()
            ->route('admin.registros.show', $antecedente->registro_id)
            ->with('success', 'Antecedentes patológicos actualizados correctamente.');
    }

    /**
     * Redirección según sexo del paciente
     */
    private function redirectPorSexo(Registro $registro)
    {
        return match ($registro->paciente->sexo) {
            'F' => redirect()
                ->route('admin.antecedentes_gineco_obstetricos.create', $registro->id)
                ->with('success', 'Antecedente patológico registrado. Complete antecedentes gineco-obstétricos.'),

            'M' => redirect()
                ->route('admin.antecedentes_masculinos.create', $registro->id)
                ->with('success', 'Antecedente patológico registrado. Complete antecedentes masculinos.'),

            default => redirect()
                ->route('admin.registros.show', $registro->id)
                ->with('warning', 'Sexo del paciente no definido.'),
        };
    }
}
