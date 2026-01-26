@extends('adminlte::page')

@section('title', 'Detalle Centro de Trabajo')

@section('content_header')
    <h1 class="m-0 text-dark">Detalle Centro de Trabajo</h1>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-building"></i> {{ $centro->nombre_centro_trabajo }}</span>
        <div class="btn-group">
            <a href="{{ route('admin.centros_trabajos.edit', [$registro, $centro]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Tipo de Trabajo:</strong> {{ ucfirst($centro->tipo_trabajo) }}</li>
            <li class="list-group-item"><strong>Actividades Desempeñadas:</strong> {{ $centro->actividades_desempenadas }}</li>
            <li class="list-group-item"><strong>Tiempo de Trabajo:</strong> {{ $centro->tiempo_trabajo ?? '-' }}</li>
            <li class="list-group-item"><strong>Incidente:</strong> {{ $centro->incidente ? 'Sí' : 'No' }}</li>
            <li class="list-group-item"><strong>Accidente:</strong> {{ $centro->accidente ? 'Sí' : 'No' }}</li>
            <li class="list-group-item"><strong>Enfermedad Profesional:</strong> {{ $centro->enfermedad_profesional ? 'Sí' : 'No' }}</li>
            <li class="list-group-item"><strong>Calificado IESS:</strong> {{ $centro->calificado_iess ? 'Sí' : 'No' }}</li>
            <li class="list-group-item"><strong>Fecha de Calificación:</strong> {{ $centro->fecha_calificacion ? $centro->fecha_calificacion->format('d/m/Y') : '-' }}</li>
            <li class="list-group-item"><strong>Especificar:</strong> {{ $centro->especificar ?? '-' }}</li>
            <li class="list-group-item"><strong>Observaciones:</strong> {{ $centro->observaciones ?? '-' }}</li>
        </ul>
    </div>
</div>
@endsection