@extends('adminlte::page')

@section('title', 'Detalle Sucursal')

@section('content_header')
<h1>Detalle de Sucursal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <p><strong>Nombre:</strong> {{ $sucursal->nombre }}</p>
        <p><strong>Código:</strong> {{ $sucursal->codigo }}</p>
        <p><strong>Dirección:</strong> {{ $sucursal->direccion }}</p>
        <p><strong>Teléfono:</strong> {{ $sucursal->telefono }}</p>
        <p>
            <strong>Estado:</strong>
            @if($sucursal->activo)
                <span class="badge badge-success">Activo</span>
            @else
                <span class="badge badge-danger">Inactivo</span>
            @endif
        </p>

    </div>

    <div class="card-footer">
        <a href="{{ route('admin.sucursales.edit', $sucursal) }}" class="btn btn-warning">
            Editar
        </a>
        <a href="{{ route('admin.sucursales.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </div>
</div>
@stop
