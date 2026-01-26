<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Mostrar todas las empresas.
     */
    public function index()
    {
         // ✅ CORRECTO - Devuelve objeto LengthAwarePaginator
        $empresas = Empresa::paginate(10); // 10 empresas por página
        return view('admin.empresas.index', compact('empresas'));
    }

    /**
     * Mostrar el formulario para crear una nueva empresa.
     */
    public function create()
    {
        return view('admin.empresas.create');
    }

    /**
     * Guardar una nueva empresa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'actividad_economica' => 'required|string|max:255',
            'ruc' => 'required|string|min:10|max:13|unique:empresas,ruc', // Cambiado aquí
            'direccion' => 'required|string|max:255',
            'representante_legal' => 'required|string|max:255',
            'ciiu' => 'nullable|string|max:255',
        ]);

        Empresa::create($request->all());

        return redirect()->route('admin.empresas.index')->with('success', 'Empresa creada correctamente.');
    }

    /**
     * Mostrar una empresa específica.
     */
    public function show(Empresa $empresa)
    {
        return view('admin.empresas.show', compact('empresa'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Empresa $empresa)
    {
        return view('admin.empresas.edit', compact('empresa'));
    }

    /**
     * Actualizar una empresa.
     */
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'actividad_economica' => 'required|string|max:255',
            'ruc' => 'required|string|min:10|max:13|unique:empresas,ruc,' . $empresa->id, // Cambiado aquí
            'direccion' => 'required|string|max:255',
            'representante_legal' => 'required|string|max:255',
            'ciiu' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);

        $empresa->update($request->all());

        return redirect()->route('admin.empresas.index')->with('success', 'Empresa actualizada correctamente.');
    }

    /**
     * Eliminar una empresa.
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa eliminada correctamente.');
    }

    /**
     * Desactivar empresa.
     */
    public function desactivar(Empresa $empresa)
    {
        $empresa->update(['activo' => false]);
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa desactivada.');
    }

    /**
     * Activar empresa.
     */
    public function activar(Empresa $empresa)
    {
        $empresa->update(['activo' => true]);
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa activada.');
    }

    /**
     * Alternar estado (toggle).
     */
   

    public function toggle(Empresa $empresa)
    {
        $empresa->update(['activo' => !$empresa->activo]);
        return redirect()->route('admin.empresas.index')->with('success', 'Estado de la empresa actualizado.');
    }
}