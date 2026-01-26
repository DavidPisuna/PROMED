<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Puesto;
use App\Models\PuestoActividad;
use App\Models\ActividadFactorRiesgo;

class PuestoController extends Controller
{
    /**
     * Mostrar formulario de creación de puesto para un registro
     */
    public function create(Registro $registro)
    {
        $factoresRiesgo = $this->obtenerFactoresRiesgo();
        return view('admin.puestos.create', compact('registro', 'factoresRiesgo'));
    }

    /**
     * Guardar el puesto con sus actividades y factores de riesgo
     */
    public function store(Request $request, Registro $registro)
    {
        $request->validate([
            'nombre_puesto' => 'required|string|max:150',
            'actividades' => 'required|array|min:1',
            'actividades.*.nombre' => 'required|string|max:255',
        ]);

        // Crear el puesto
        $puesto = Puesto::create([
            'registro_id' => $registro->id,
            'nombre_puesto' => $request->nombre_puesto
        ]);

        // Procesar actividades y factores de riesgo
        $this->procesarActividadesYFactores($puesto, $request);

        return redirect()
            ->route('admin.centros_trabajos.create', $registro)
            ->with('success', 'Puesto de trabajo registrado correctamente.');
    }

    /**
     * Mostrar detalle del puesto específico
     */
    public function show(Registro $registro, Puesto $puesto)
    {
        $puesto->load(['actividades.factoresRiesgo']);
        return view('admin.puestos.show', compact('registro', 'puesto'));
    }

    /**
     * Mostrar formulario de edición de puesto específico
     */
    public function edit(Registro $registro, Puesto $puesto)
    {
        $puesto->load(['actividades.factoresRiesgo']);
        $factoresRiesgo = $this->obtenerFactoresRiesgo();

        // Ya no definimos funciones aquí, se manejarán desde un helper global
        return view('admin.puestos.edit', compact('registro', 'puesto', 'factoresRiesgo'));
    }

    /**
     * Actualizar puesto específico
     */
    public function update(Request $request, Registro $registro, Puesto $puesto)
    {
        $request->validate([
            'nombre_puesto' => 'required|string|max:150',
            'actividades' => 'required|array|min:1',
            'actividades.*.nombre' => 'required|string|max:255',
        ]);

        // Actualizar nombre del puesto
        $puesto->update([
            'nombre_puesto' => $request->nombre_puesto
        ]);

        // Eliminar actividades y factores existentes
        $puesto->actividades()->each(function($actividad){
            $actividad->factoresRiesgo()->delete();
            $actividad->delete();
        });

        // Crear actividades y factores según el formulario
        foreach ($request->actividades as $actividadData) {
            $actividad = $puesto->actividades()->create([
                'nombre_actividad' => $actividadData['nombre']
            ]);

            if (isset($actividadData['factores'])) {
                foreach ($actividadData['factores'] as $factorKey) {
                    [$categoria, $factor] = explode('_', $factorKey, 2);

                    $actividad->factoresRiesgo()->create([
                        'categoria' => $categoria,
                        'factor_riesgo' => $factor
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Puesto de trabajo actualizado correctamente');
    }




    /**
     * Eliminar puesto específico
     */
    public function destroy(Registro $registro, Puesto $puesto)
    {
        $puesto->delete();

        return redirect()
            ->route('admin.registros.show', $registro)
            ->with('success', 'Puesto de trabajo eliminado correctamente.');
    }

    /**
     * Métodos auxiliares privados
     */
    private function procesarActividadesYFactores(Puesto $puesto, Request $request)
    {
        $actividadesData = $request->input('actividades', []);
        $factoresData = $request->input('factores_riesgo', []);

        foreach ($actividadesData as $index => $actividadData) {
            // Crear actividad
            $actividad = $puesto->actividades()->create([
                'nombre_actividad' => $actividadData['nombre']
            ]);

            // Asignar factores de riesgo si existen para esta actividad
            if (isset($factoresData[$index])) {
                foreach ($factoresData[$index] as $factorKey) {
                    $parts = explode('_', $factorKey, 2);

                    if (count($parts) === 2) {
                        [$categoria, $factor] = $parts;

                        $actividad->factoresRiesgo()->create([
                            'categoria' => $categoria,
                            'factor_riesgo' => $factor
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Factores de riesgo predefinidos
     */
    private function obtenerFactoresRiesgo()
    {
        return [
            'fisico' => [
                'Temperaturas altas',
                'Temperaturas bajas',
                'Radiación Ionizante',
                'Radiación No Ionizante',
                'Ruido',
                'Vibración',
                'Iluminación',
                'Ventilación',
                'Fluido eléctrico',
                'Otros'
            ],
            'seguridad' => [
                'Falta de señalización, aseo, desorden',
                'Atrapamiento entre Máquinas y o superficies',
                'Atrapamiento entre objetos',
                'Caída de objetos',
                'Caídas al mismo nivel',
                'Caídas a diferente nivel',
                'Pinchazos',
                'Cortes',
                'Choques /colisión vehicular',
                'Atropellamientos por vehículos',
                'Proyección de fluidos',
                'Proyección de partículas – fragmentos',
                'Contacto con superficies de trabajos',
                'Contacto eléctrico',
                'Otros'
            ],
            'quimico' => [
                'Polvos',
                'Sólidos',
                'Humos',
                'Líquidos',
                'Vapores',
                'Aerosoles',
                'Neblinas',
                'Gaseosos',
                'Otros'
            ],
            'biologico' => [
                'Virus',
                'Hongos',
                'Bacterias',
                'Parásitos',
                'Exposición a vectores',
                'Exposición a animales selváticos',
                'Otros'
            ],
            'ergonomico' => [
                'Manejo manual de cargas',
                'Movimientos repetitivos',
                'Posturas forzadas',
                'Trabajos con PVD',
                'Diseño inadecuado del puesto',
                'Otros'
            ],
            'psicosocial' => [
                'Monotonía del trabajo',
                'Sobrecarga laboral',
                'Minuciosidad de la tarea',
                'Alta responsabilidad',
                'Autonomía en la toma de decisiones',
                'Supervisión y estilos de dirección deficiente',
                'Conflicto de rol',
                'Falta de claridad en las funciones',
                'Incorrecta distribución del trabajo',
                'Turnos rotativos',
                'Relaciones interpersonales',
                'Inestabilidad laboral',
                'Amenaza delincuencial',
                'Otros'
            ]
        ];
    }
}