<?php

namespace App\Http\Controllers;


use App\Models\Registro;
use App\Models\Empresa;
use App\Models\Paciente;
use App\Models\Doctor;
use Illuminate\Http\Request;

class RegistroController extends Controller
{

    

    public function index()
    {
        $registros = Registro::with(['empresa', 'paciente', 'doctor'])->get();
        return view('admin.registros.index', compact('registros'));
    }

    public function createFromPaciente(Paciente $paciente)
    {
        $empresas = Empresa::activas()->get();
        $doctores = Doctor::all();

        return view('admin.registros.create', compact('paciente', 'empresas', 'doctores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'tipo' => 'required|in:INGRESO,PERIODICA,RETIRO,REINTEGRO',
            'puesto' => 'nullable|string|max:100',
            'fecha_ingreso' => 'nullable|date',
            'fecha_periodica' => 'nullable|date',
            'fecha_retiro' => 'nullable|date',
            'fecha_reintegro' => 'nullable|date',
            'atencion_prioritaria' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
        ]);

        $registro = Registro::create($data);

        return redirect()
            ->route('admin.antecedentes_patologicos.create', $registro->id)
            ->with('success', 'Registro creado correctamente. Continúe con los antecedentes patológicos.');
    }

    public function show(Registro $registro)
    {
        $registro->load([
            'empresa',
            'paciente',
            'doctor',
            'antecedentePatologico',
            'antecedenteGineco.examenes',
            'antecedenteMasculino.examenes',
            'consumoSustancia',
            'actividadesFisicas',
            'medicacionesHabituales',
            'constanteVital',
            'examenesFisicos',
            'puestos.actividades.factoresRiesgo',
            'centros',
            'actividadesExtras',
            'resultadosExamenes',
            'diagnosticos',
            'aptitudesMedicas',
            'retirosEvaluaciones',
        ]);

        return view('admin.registros.show', compact('registro'));
    }

    public function edit(Registro $registro)
    {
        $empresas = Empresa::activas()->get();
        $pacientes = Paciente::where('activo', true)->get();
        $doctores = Doctor::where('activo', true)->get();

        return view('admin.registros.edit', compact('registro', 'empresas', 'pacientes', 'doctores'));
    }

    public function update(Request $request, Registro $registro)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'tipo' => 'required|in:INGRESO,PERIODICA,RETIRO,REINTEGRO',
            'puesto' => 'nullable|string|max:100',
            'fecha_ingreso' => 'nullable|date',
            'fecha_periodica' => 'nullable|date',
            'fecha_retiro' => 'nullable|date',
            'fecha_reintegro' => 'nullable|date',
            'atencion_prioritaria' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
        ]);

        $registro->update($data);

        return redirect()->route('admin.registros.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(Registro $registro)
    {
        try {
            // Obtener parámetros de paginación antes de eliminar
            $page = request('page', 1);
            $perPage = request('per_page', 10);
            $pacienteId = $registro->paciente_id;
            
            // Eliminar el registro
            $registro->delete();
            
            // Redirigir manteniendo los parámetros
            return redirect()->route('admin.pacientes.vistaIndividual', [
                'paciente' => $pacienteId,
                'page' => $page,
                'per_page' => $perPage
            ])->with('success', 'Registro eliminado correctamente.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }

    public function registrosPaciente(Paciente $paciente)
    {
        $registros = $paciente->registros()->with(['empresa', 'doctor'])->get();

        return view('admin.registros.index', compact('registros', 'paciente'));
    }

    public function pdf(Registro $registro)
    {
        $registro->load([
            'empresa',
            'paciente',
            'doctor',
            'antecedentePatologico',
            'consumoSustancia',
            'constanteVital',
            'diagnosticos',
            'aptitudesMedicas',
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.registros.pdf', compact('registro'))
                    ->setPaper('A4', 'portrait');

        return $pdf->stream('registro_'.$registro->id.'.pdf');
    }

}