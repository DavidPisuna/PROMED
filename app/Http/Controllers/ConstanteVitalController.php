<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\ConstanteVital;

class ConstanteVitalController extends Controller
{
    /**
     * Mostrar formulario de creación
     */
    public function create(Registro $registro)
    {
        return view('admin.constantes_vitales.create', compact('registro'));
    }

    /**
     * Guardar nueva constante vital
     */
    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'temperatura' => 'nullable|numeric',
            'presion_arterial' => 'nullable|string|max:10',
            'frecuencia_cardiaca' => 'nullable|integer',
            'frecuencia_respiratoria' => 'nullable|integer',
            'saturacion_oxigeno' => 'nullable|integer',
            'peso' => 'nullable|numeric',
            'talla' => 'nullable|numeric',
            'imc' => 'nullable|numeric',
            'categoria_imc' => 'nullable|string|max:50',
            'perimetro_abdominal' => 'nullable|numeric',
            'enfermedad_actual' => 'nullable|string',
        ]);

        $registro->constanteVital()->create($request->all());

        return redirect()->route('admin.examenes_fisicos.create', $registro)
                         ->with('success', 'Constante vital registrada correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(ConstanteVital $constanteVital)
    {
        $registro = $constanteVital->registro;
        return view('admin.constantes_vitales.edit', compact('constanteVital', 'registro'));
    }

    /**
     * Actualizar constante vital
     */
    public function update(Request $request, ConstanteVital $constanteVital)
    {
        $request->validate([
            'temperatura' => 'nullable|numeric',
            'presion_arterial' => 'nullable|string|max:10',
            'frecuencia_cardiaca' => 'nullable|integer',
            'frecuencia_respiratoria' => 'nullable|integer',
            'saturacion_oxigeno' => 'nullable|integer',
            'peso' => 'nullable|numeric',
            'talla' => 'nullable|numeric',
            'imc' => 'nullable|numeric',
            'categoria_imc' => 'nullable|string|max:50',
            'perimetro_abdominal' => 'nullable|numeric',
            'enfermedad_actual' => 'nullable|string',
        ]);

        $constanteVital->update($request->all());

        return redirect()->route('admin.registros.show', $constanteVital->registro)
                         ->with('success', 'Constante vital actualizada correctamente');
    }

    /**
     * Mostrar detalle
     */
    public function show(ConstanteVital $constanteVital)
    {
        $registro = $constanteVital->registro;
        return view('admin.constantes_vitales.show', compact('constanteVital', 'registro'));
    }
}