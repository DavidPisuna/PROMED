<?php

namespace App\Http\Controllers;

use App\Models\NotaEvolucion;
use App\Models\Paciente;
use App\Models\Empresa;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class NotaEvolucionController extends Controller
{
    /**
     * 📋 Listar notas por paciente
     */
    public function byPaciente(Paciente $paciente)
    {
        $notas = NotaEvolucion::where('paciente_id', $paciente->id)
            ->with('doctor')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(10);

        return view('admin.notas_evoluciones.indexByPaciente', compact(
            'paciente',
            'notas'
        ));
    }

    /**
     * ➕ Crear nota desde paciente
     */
    public function createFromPaciente(Paciente $paciente)
    {
        $empresas = Empresa::activas()->get();
        $doctores = Doctor::where('activo', true)->get();

        return view('admin.notas_evoluciones.create', compact(
            'paciente',
            'empresas',
            'doctores'
        ));
    }

    /**
     * 💾 Guardar nota
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id'   => 'required|exists:empresas,id',
            'paciente_id'  => 'required|exists:pacientes,id',
            'doctor_id'    => 'required|exists:doctores,id',
            'fecha'        => 'required|date',
            'hora'         => 'required',
            'problemas'    => 'nullable|string|max:255',
            'evolucion'    => 'required|string',
        ]);

        // Normalizar texto
        $this->normalizarTexto($data);

        NotaEvolucion::create($data);

        return redirect()
            ->route('admin.notas.byPaciente', $data['paciente_id'])
            ->with('success', '📝 Nota de evolución registrada correctamente');
    }

    /**
     * 👁 Mostrar nota
     */
    public function show(NotaEvolucion $nota)
    {
        $nota->load(['paciente', 'doctor', 'empresa']);

        return view('admin.notas_evoluciones.show', compact('nota'));
    }

    /**
     * ✏️ Editar nota
     */
    public function edit(NotaEvolucion $nota)
    {
        $empresas = Empresa::activas()->get();
        $doctores = Doctor::where('activo', true)->get();
        $paciente = $nota->paciente;

        return view('admin.notas_evoluciones.edit', compact(
            'nota',
            'paciente',
            'empresas',
            'doctores'
        ));
    }

    /**
     * 🔄 Actualizar nota
     */
    public function update(Request $request, NotaEvolucion $nota)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'doctor_id'  => 'required|exists:doctores,id',
            'fecha'      => 'required|date',
            'hora'       => 'required',
            'problemas'  => 'nullable|string|max:255',
            'evolucion'  => 'required|string',
        ]);

        $this->normalizarTexto($data);

        $nota->update($data);

        return redirect()
            ->route('admin.notas.show', $nota)
            ->with('success', '✏️ Nota de evolución actualizada correctamente');
    }

    /**
     * 🗑 Eliminar nota
     */
    public function destroy(NotaEvolucion $nota)
    {
        $pacienteId = $nota->paciente_id;

        $nota->delete();

        return redirect()
            ->route('admin.notas.byPaciente', $pacienteId)
            ->with('success', '❌ Nota de evolución eliminada correctamente');
    }

    /**
     * 🔠 Normalizar texto a MAYÚSCULAS
     */
    private function normalizarTexto(array &$data): void
    {
        $campos = ['problemas', 'evolucion'];

        foreach ($campos as $campo) {
            if (!empty($data[$campo])) {
                $data[$campo] = mb_strtoupper($data[$campo], 'UTF-8');
            }
        }
    }

    public function pdfByPaciente(Paciente $paciente)
    {
        $notas = NotaEvolucion::where('paciente_id', $paciente->id)
            ->with(['doctor', 'empresa'])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        $pdf = Pdf::loadView('admin.notas_evoluciones.pdf_by_paciente', [
            'paciente' => $paciente,
            'notas' => $notas
        ])->setPaper('A4', 'portrait');

        return $pdf->stream(
            'evolucion_clinica_' . $paciente->cedula_identidad . '.pdf'
        );
    }
}
