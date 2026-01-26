<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Listar doctores activos.
     */
    public function index()
    {
        $doctores = Doctor::orderBy('primer_apellido')->get(); // TODOS
        return view('admin.doctores.index', compact('doctores'));
    }


    /**
     * Listar doctores inactivos.
     */
    public function inactivos()
    {
        $doctores = Doctor::where('activo', false)->orderBy('primer_apellido')->get();
        return view('admin.doctores.index', compact('doctores'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('admin.doctores.create');
    }

    /**
     * Guardar nuevo doctor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'segundo_apellido' => 'nullable|string|max:50',
            'especialidad' => 'required|string|max:100',
            'numero_licencia' => 'required|string|max:20|unique:doctores',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:doctores',
            'direccion' => 'nullable|string|max:255',
        ]);

        Doctor::create($request->all());

        return redirect()->route('admin.doctores.index')->with('success', 'Doctor creado correctamente.');
    }

    /**
     * Mostrar detalle del doctor.
     */
    public function show(Doctor $doctor)
    {
        return view('admin.doctores.show', compact('doctor'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Doctor $doctor)
    {
        return view('admin.doctores.edit', compact('doctor'));
    }

    /**
     * Actualizar doctor.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'segundo_apellido' => 'nullable|string|max:50',
            'especialidad' => 'required|string|max:100',
            'numero_licencia' => 'required|string|max:20|unique:doctores,numero_licencia,' . $doctor->id,
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:doctores,email,' . $doctor->id,
            'direccion' => 'nullable|string|max:255',
        ]);

        $doctor->update($request->all());

        return redirect()->route('admin.doctores.index')->with('success', 'Doctor actualizado correctamente.');
    }

    /**
     * Activar/desactivar doctor (toggle).
     */
    public function toggleActivo(Doctor $doctor)
    {
        $doctor->update(['activo' => !$doctor->activo]);
        return redirect()->route('admin.doctores.index')->with('success', 'Estado del doctor actualizado.');
    }

    /**
     * Eliminar doctor.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('admin.doctores.index')->with('success', 'Doctor eliminado correctamente.');
    }
}