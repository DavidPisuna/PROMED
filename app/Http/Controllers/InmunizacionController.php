<?php

namespace App\Http\Controllers;

use App\Models\Inmunizacion;
use App\Models\InmunizacionDetalle;
use App\Models\Empresa;
use App\Models\Paciente;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InmunizacionController extends Controller
{
    public function index()
    {
        $inmunizaciones = Inmunizacion::with(['empresa', 'paciente', 'doctor'])
            ->latest()
            ->paginate(10);

        return view('admin.inmunizaciones.index', compact('inmunizaciones'));
    }

    public function createFromPaciente(Paciente $paciente)
    {
        $empresas = Empresa::where('activo', true)->get();
        $doctores = Doctor::where('activo', true)->get();

        return view('admin.inmunizaciones.create', compact('paciente', 'empresas', 'doctores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'vacunas' => 'required|array|min:1',
            'vacunas.*.vacuna' => 'required|string|max:100',
            'vacunas.*.dosis' => 'required|string|max:20',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $inmunizacion = Inmunizacion::create([
                    'empresa_id' => $request->empresa_id,
                    'paciente_id' => $request->paciente_id,
                    'doctor_id' => $request->doctor_id,
                    'observaciones_generales' => $this->u($request->observaciones_generales),
                ]);

                foreach ($request->vacunas as $v) {
                    $inmunizacion->detalles()->create([
                        'vacuna' => $this->u($v['vacuna']),
                        'dosis' => $this->u($v['dosis']),
                        'fecha' => $v['fecha'],
                        'lote' => $this->u($v['lote'] ?? null),
                        'esquema_completo' => isset($v['esquema_completo']),
                        'responsable_vacunacion' => $this->u($v['responsable_vacunacion'] ?? null),
                        'establecimiento_salud' => $this->u($v['establecimiento_salud'] ?? null),
                        'observaciones' => $this->u($v['observaciones'] ?? null),
                    ]);
                }

                return redirect()->route('admin.inmunizaciones.byPaciente', $request->paciente_id)
                    ->with('success', '💉 Registro guardado con éxito.');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    // ✅ NUEVO: Método para mostrar el formulario de edición
    public function edit(Inmunizacion $inmunizacion)
    {
        $inmunizacion->load(['paciente', 'detalles']);
        $empresas = Empresa::where('activo', true)->get();
        $doctores = Doctor::where('activo', true)->get();

        return view('admin.inmunizaciones.edit', compact('inmunizacion', 'empresas', 'doctores'));
    }

    // ✅ NUEVO: Método para procesar la actualización
    public function update(Request $request, Inmunizacion $inmunizacion)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'doctor_id' => 'required|exists:doctores,id',
            'vacunas' => 'required|array|min:1',
        ]);

        try {
            DB::transaction(function () use ($request, $inmunizacion) {
                // Actualizar cabecera
                $inmunizacion->update([
                    'empresa_id' => $request->empresa_id,
                    'doctor_id' => $request->doctor_id,
                    'observaciones_generales' => $this->u($request->observaciones_generales),
                ]);

                // Sincronizar detalles: Borramos los anteriores y creamos los nuevos
                $inmunizacion->detalles()->delete();
                foreach ($request->vacunas as $v) {
                    $inmunizacion->detalles()->create([
                        'vacuna' => $this->u($v['vacuna']),
                        'dosis' => $this->u($v['dosis']),
                        'fecha' => $v['fecha'],
                        'lote' => $this->u($v['lote'] ?? null),
                        'esquema_completo' => isset($v['esquema_completo']),
                        'responsable_vacunacion' => $this->u($v['responsable_vacunacion'] ?? null),
                        'establecimiento_salud' => $this->u($v['establecimiento_salud'] ?? null),
                        'observaciones' => $this->u($v['observaciones'] ?? null),
                    ]);
                }
            });

            return redirect()->route('admin.inmunizaciones.byPaciente', $inmunizacion->paciente_id)
                ->with('success', '✅ Registro actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function show(Inmunizacion $inmunizacion)
    {
        $inmunizacion->load(['empresa', 'paciente', 'doctor', 'detalles']);
        return view('admin.inmunizaciones.show', compact('inmunizacion'));
    }

    public function destroy(Inmunizacion $inmunizacion)
    {
        $paciente_id = $inmunizacion->paciente_id;
        $inmunizacion->delete();
        return redirect()->route('admin.inmunizaciones.byPaciente', $paciente_id)
            ->with('success', '❌ Registro eliminado correctamente.');
    }

    public function pdf(Inmunizacion $inmunizacion)
    {
        $inmunizacion->load(['empresa', 'paciente', 'doctor', 'detalles']);
        $pdf = Pdf::loadView('admin.inmunizaciones.pdf', compact('inmunizacion'))
                  ->setPaper('A4', 'portrait');
        return $pdf->stream("inmunizacion_{$inmunizacion->id}.pdf");
    }

    public function byPaciente(Paciente $paciente)
    {
        $inmunizaciones = Inmunizacion::where('paciente_id', $paciente->id)
            ->with(['empresa', 'doctor', 'detalles'])
            ->latest()
            ->paginate(10);

        return view('admin.inmunizaciones.indexByPaciente', compact('paciente', 'inmunizaciones'));
    }

    private function u(?string $texto): ?string
    {
        return $texto ? mb_strtoupper($texto, 'UTF-8') : null;
    }
}