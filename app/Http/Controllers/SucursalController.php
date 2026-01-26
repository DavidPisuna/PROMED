<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Listado de sucursales
     */
    public function index()
    {
        $sucursales = Sucursal::orderBy('id', 'desc')->get();
        return view('admin.sucursales.index', compact('sucursales'));
    }

    /**
     * Formulario crear
     */
    public function create()
    {
        return view('admin.sucursales.create');
    }

    /**
     * Guardar sucursal
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100',
            'codigo'  => 'required|string|max:20|unique:sucursales,codigo',
            'direccion' => 'nullable|string|max:150',
            'telefono' => 'nullable|string|max:20',
        ]);

        Sucursal::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'activo' => true,
        ]);

        return redirect()
            ->route('admin.sucursales.index')
            ->with('success', 'Sucursal creada correctamente');
    }

    /**
     * Formulario editar
     */
    public function edit(Sucursal $sucursal)
    {
        return view('admin.sucursales.edit', compact('sucursal'));
    }

    /**
     * Actualizar sucursal
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100',
            'codigo'  => 'required|string|max:20|unique:sucursales,codigo,' . $sucursal->id,
            'direccion' => 'nullable|string|max:150',
            'telefono' => 'nullable|string|max:20',
        ]);

        $sucursal->update($request->all());

        return redirect()
            ->route('admin.sucursales.index')
            ->with('success', 'Sucursal actualizada correctamente');
    }

    /**
     * Activar / desactivar sucursal
     */
    public function toggle(Sucursal $sucursal)
    {
        $sucursal->activo = ! $sucursal->activo;
        $sucursal->save();

        return redirect()
            ->route('admin.sucursales.index')
            ->with('success', 'Estado de sucursal actualizado');
    }

    /**
     * NO borrar sucursales (seguridad)
     */
    public function destroy(Sucursal $sucursal)
    {
        return redirect()
            ->route('admin.sucursales.index')
            ->with('error', 'No se permite eliminar sucursales');
    }
}
