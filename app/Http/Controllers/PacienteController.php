<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Listado de pacientes
     */
    public function index()
    {
        $pacientes = Paciente::with('sucursal')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.pacientes.index', compact('pacientes'));
    }

    /**
     * Formulario crear paciente
     */
    public function create()
    {
        $sucursales = Sucursal::where('activo', true)->get();

        return view('admin.pacientes.create', compact('sucursales'));
    }

    /**
     * Guardar paciente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'primer_apellido'   => 'required|string|max:100',
            'segundo_apellido'  => 'nullable|string|max:100',
            'primer_nombre'     => 'required|string|max:100',
            'segundo_nombre'    => 'nullable|string|max:100',
            'cedula_identidad'  => 'required|string|max:20|unique:pacientes,cedula_identidad',
            'codigo_empleado'   => 'required|string|max:20|unique:pacientes,codigo_empleado',
            'sexo'              => 'nullable|string|max:10',
            'grupo_sanguineo'   => 'nullable|string|max:10',
            'lateralidad'       => 'nullable|string|max:50',
            'fecha_nacimiento'  => 'nullable|date',
            'sucursal_id'       => 'required|exists:sucursales,id',
            'activo'            => 'boolean',
        ]);

        Paciente::create($validated);

        return redirect()
            ->route('admin.pacientes.index')
            ->with('success', '✅ Paciente creado correctamente.');
    }

    /**
     * Mostrar paciente
     */
    public function show(Paciente $paciente)
    {
        $paciente->load('sucursal');

        return view('admin.pacientes.show', compact('paciente'));
    }

    /**
     * Formulario editar paciente
     */
    public function edit(Paciente $paciente)
    {
        $sucursales = Sucursal::where('activo', true)->get();

        return view('admin.pacientes.edit', compact('paciente', 'sucursales'));
    }

    /**
     * Actualizar paciente
     */
    public function update(Request $request, Paciente $paciente)
    {
        $validated = $request->validate([
            'primer_apellido'   => 'required|string|max:100',
            'segundo_apellido'  => 'nullable|string|max:100',
            'primer_nombre'     => 'required|string|max:100',
            'segundo_nombre'    => 'nullable|string|max:100',
            'cedula_identidad'  => 'required|string|max:20|unique:pacientes,cedula_identidad,' . $paciente->id,
            'codigo_empleado'   => 'required|string|max:20|unique:pacientes,codigo_empleado,' . $paciente->id,
            'sexo'              => 'nullable|string|max:10',
            'grupo_sanguineo'   => 'nullable|string|max:10',
            'lateralidad'       => 'nullable|string|max:50',
            'fecha_nacimiento'  => 'nullable|date',
            'sucursal_id'       => 'required|exists:sucursales,id',
            'activo'            => 'boolean',
        ]);

        $paciente->update($validated);

        return redirect()
            ->route('admin.pacientes.index')
            ->with('success', '🩺 Paciente actualizado correctamente.');
    }

    /**
     * Activar / desactivar paciente
     */
    public function toggleActivo(Paciente $paciente)
    {
        $paciente->update([
            'activo' => ! $paciente->activo
        ]);

        return redirect()
            ->route('admin.pacientes.index')
            ->with('success', 'Estado del paciente actualizado.');
    }


    /**
     * Vista individual con registros
     */
    public function vistaIndividual(Paciente $paciente)
    {
        // Cargar los registros del paciente con relaciones
        $registros = $paciente->registros()->with(['empresa', 'doctor'])->get();

        $registros = $paciente->registros()
                         ->with(['doctor', 'empresa'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(5);

        return view('admin.pacientes.vistaIndividual', compact('paciente', 'registros'));
    }
}
