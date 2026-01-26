<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\ExamenFisico;

class ExamenFisicoController extends Controller
{
    /**
     * Mostrar formulario de creación de examen físico para un registro
     */
    public function create(Registro $registro)
    {
        // Puedes pasar un array de regiones e ítems predefinidos
        $regiones = [
            'piel' => ['cicatrices', 'piel_faneras'],
            'ojos' => ['parpados', 'conjuntivas', 'pupilas', 'cornea', 'motilidad'],
            'oido' => ['conducto_auditivo', 'pabellon', 'timpanos'],
            'orofaringe' => ['labios', 'lengua', 'faringe', 'amigdalas', 'dentadura'],
            'nariz' => ['tabique', 'cornetes', 'mucosas', 'senos_paranasales'],
            'cuello' => ['tiroides_masas', 'movilidad'],
            'torax_mamas' => ['mamas'],
            'torax_organos' => ['pulmones', 'corazon', 'parrilla_costal'],
            'abdomen' => ['visceras', 'pared_abdominal'],
            'columna' => ['flexibilidad', 'desviacion', 'dolor'],
            'pelvis' => ['pelvis', 'genitales'],
            'extremidades' => ['vascular', 'miembros_superiores', 'miembros_inferiores'],
            'neurologico' => ['fuerza', 'sensibilidad', 'marcha', 'reflejos']
        ];

        return view('admin.examenes_fisicos.create', compact('registro', 'regiones'));
    }

    /**
     * Guardar los exámenes físicos
     */
    public function store(Request $request, Registro $registro)
    {
        $data = $request->input('examenes', []);

        foreach ($data as $region => $items) {
            foreach ($items as $item => $detalle) {
                // Si el checkbox no está marcado, no guardamos la observación
                $valor = isset($detalle['valor']) && $detalle['valor'] == 1;
                $observacion = $valor ? ($detalle['observacion'] ?? null) : null;

                ExamenFisico::create([
                    'registro_id' => $registro->id,
                    'region' => $region,
                    'item' => $item,
                    'valor' => $valor,
                    'observacion' => $observacion,
                ]);
            }
        }

        return redirect()
            ->route('admin.puestos.create', $registro)
            ->with('success', 'Exámenes físicos registrados correctamente');
    }


    /**
     * Mostrar formulario de edición
     */
  public function edit(Registro $registro)
    {
        // Cargar los exámenes ya guardados
        $registro->load('examenesFisicos');

        // Lista de regiones e ítems
        $regiones = [
            'piel' => ['cicatrices', 'piel_faneras'],
            'ojos' => ['parpados', 'conjuntivas', 'pupilas', 'cornea', 'motilidad'],
            'oido' => ['conducto_auditivo', 'pabellon', 'timpanos'],
            'orofaringe' => ['labios', 'lengua', 'faringe', 'amigdalas', 'dentadura'],
            'nariz' => ['tabique', 'cornetes', 'mucosas', 'senos_paranasales'],
            'cuello' => ['tiroides_masas', 'movilidad'],
            'torax_mamas' => ['mamas'],
            'torax_organos' => ['pulmones', 'corazon', 'parrilla_costal'],
            'abdomen' => ['visceras', 'pared_abdominal'],
            'columna' => ['flexibilidad', 'desviacion', 'dolor'],
            'pelvis' => ['pelvis', 'genitales'],
            'extremidades' => ['vascular', 'miembros_superiores', 'miembros_inferiores'],
            'neurologico' => ['fuerza', 'sensibilidad', 'marcha', 'reflejos'],
        ];

        // Exámenes agrupados por región
        $examenes = $registro->examenesFisicos->groupBy('region');

        return view('admin.examenes_fisicos.edit', compact('registro', 'regiones', 'examenes'));
    }




    /**
     * Actualizar exámenes físicos
     */
   public function update(Request $request, Registro $registro)
    {
        $data = $request->input('examenes', []);

        // Obtener todos los exámenes existentes indexados
        $examenesExistentes = $registro->examenesFisicos()->get()->keyBy(function ($item) {
            return $item->region . '_' . $item->item;
        });

        foreach ($data as $region => $items) {
            foreach ($items as $item => $detalle) {
                $key = $region . '_' . $item;
                $valor = isset($detalle['valor']) ? (int)$detalle['valor'] : 0;
                $observacion = $valor ? ($detalle['observacion'] ?? null) : null;

                if (isset($examenesExistentes[$key])) {
                    // Actualizar examen existente
                    $examen = $examenesExistentes[$key];
                    $examen->update([
                        'valor' => $valor,
                        'observacion' => $observacion
                    ]);
                } else {
                    // Crear nuevo examen si no existía
                    if ($valor) {
                        ExamenFisico::create([
                            'registro_id' => $registro->id,
                            'region' => $region,
                            'item' => $item,
                            'valor' => $valor,
                            'observacion' => $observacion,
                        ]);
                    }
                }
            }
        }

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Exámenes físicos actualizados correctamente');
    }



    /**
     * Mostrar detalle de exámenes físicos
     */
    public function show(Registro $registro)
    {
        $examenes = $registro->examenesFisicos()->get()->groupBy('region');
        return view('admin.examenes_fisicos.show', compact('registro', 'examenes'));
    }
}