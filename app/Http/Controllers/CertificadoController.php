<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Empresa;
use App\Models\Paciente;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoController extends Controller
{
    /**
     * Listado general de certificados
     */
    public function index()
    {
        $certificados = Certificado::with(['empresa', 'paciente', 'doctor'])
            ->latest()
            ->paginate(10);

        return view('admin.certificados.index', compact('certificados'));
    }

    /**
     * Crear certificado desde un paciente específico
     */
    public function createFromPaciente(Paciente $paciente)
    {
        $empresas = Empresa::activas()->get();
        $doctores = Doctor::where('activo', true)->get();

        return view('admin.certificados.create', compact('paciente', 'empresas', 'doctores'));
    }

    /**
     * Guardar certificado
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id'        => 'required|exists:empresas,id',
            'paciente_id'       => 'required|exists:pacientes,id',
            'doctor_id'         => 'required|exists:doctores,id',
            'tipo'              => 'required|in:ingreso,periodica,retiro,reintegro',
            'puesto'            => 'nullable|string|max:100',
            'fecha_emision'     => 'nullable|date',
            'aptitud'           => 'required|in:apto,apto en observacion,apto con limitacion,no apto',
            'observa_aptitud'   => 'nullable|string',
            'descripcion_reco'  => 'nullable|string',
            'observa_reco'      => 'nullable|string',
        ]);

        // Normalizar texto a MAYÚSCULAS
        $this->normalizarTexto($data);

        $certificado = Certificado::create($data);

        return redirect()
            ->route('admin.certificados.show', $certificado)
            ->with('success', '✅ Certificado creado correctamente.');
    }

    /**
     * Mostrar certificado
     */
    public function show(Certificado $certificado)
    {
        $certificado->load(['empresa', 'paciente', 'doctor']);

        return view('admin.certificados.show', compact('certificado'));
    }

    /**
     * Editar certificado
     */
    public function edit(Certificado $certificado)
    {
        $empresas = Empresa::activas()->get();
        $doctores = Doctor::where('activo', true)->get();
        $paciente = $certificado->paciente;

        return view('admin.certificados.edit', compact(
            'certificado',
            'empresas',
            'doctores',
            'paciente'
        ));
    }

    /**
     * Actualizar certificado
     */
    public function update(Request $request, Certificado $certificado)
{
    // ✅ 1. Validación estricta
    $data = $request->validate([
        'empresa_id'       => 'required|exists:empresas,id',
        'doctor_id'        => 'required|exists:doctores,id',
        'tipo'             => 'required|in:ingreso,periodica,retiro,reintegro',
        'puesto'           => 'nullable|string|max:100',
        'fecha_emision'    => 'nullable|date',
        'aptitud'          => 'required|in:apto,apto en observacion,apto con limitacion,no apto',
        'observa_aptitud'  => 'nullable|string',
        'descripcion_reco' => 'nullable|string',
        'observa_reco'     => 'nullable|string',
    ]);

    // ✅ 2. Convertir textos a MAYÚSCULAS
    $camposTexto = [
        'puesto',
        'observa_aptitud',
        'descripcion_reco',
        'observa_reco',
    ];

    foreach ($camposTexto as $campo) {
        if (!empty($data[$campo])) {
            $data[$campo] = mb_strtoupper($data[$campo], 'UTF-8');
        }
    }

    // ✅ 3. Actualizar correctamente
    $certificado->update($data);

    return redirect()
        ->route('admin.certificados.show', $certificado)
        ->with('success', '✅ Certificado actualizado correctamente.');
}


    /**
     * Eliminar certificado
     */
    public function destroy(Certificado $certificado)
    {
        try {
            $certificado->delete();

            return redirect()
                ->route('admin.certificados.index')
                ->with('success', '❌ Certificado eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el certificado.');
        }
    }

    /**
     * Generar PDF del certificado
     */
    public function pdf(Certificado $certificado)
    {
        $certificado->load(['empresa', 'paciente', 'doctor']);

        $pdf = Pdf::loadView('admin.certificados.pdf', compact('certificado'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('certificado_' . $certificado->id . '.pdf');
    }

    /**
     * Listar certificados por paciente
     */
    public function certificadosByPaciente(Paciente $paciente)
    {
        $certificados = Certificado::where('paciente_id', $paciente->id)
            ->with(['empresa', 'doctor'])
            ->latest()
            ->paginate(5);

        return view('admin.certificados.indexByPaciente', compact('paciente', 'certificados'));
    }

    /**
     * Normaliza campos de texto a MAYÚSCULAS
     */
    private function normalizarTexto(array &$data): void
    {
        $campos = [
            'puesto',
            'observa_aptitud',
            'descripcion_reco',
            'observa_reco',
        ];

        foreach ($campos as $campo) {
            if (!empty($data[$campo])) {
                $data[$campo] = mb_strtoupper($data[$campo], 'UTF-8');
            }
        }
    }
}
