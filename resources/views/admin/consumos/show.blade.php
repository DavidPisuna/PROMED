@extends('adminlte::page')

@section('title', 'Detalle de Consumo de Sustancias y Estilo de Vida')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-primary"><i class="fas fa-prescription-bottle-alt"></i> Detalle Consumo y Estilo de Vida</h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
{{-- Card Consumo de Sustancias --}}
<div class="card shadow-sm mb-3">
    <div class="card-header bg-warning text-white">
        <i class="fas fa-smoking"></i> Consumo de Sustancias
    </div>
    <div class="card-body">
        <p><strong>Tabaco:</strong> {{ ucfirst($consumo->tabaco_estado) }}</p>
        <p><strong>Tiempo consumo:</strong> {{ $consumo->tabaco_tiempo_consumo ?? 'N/A' }} meses</p>
        <p><strong>Tiempo abstinencia:</strong> {{ $consumo->tabaco_tiempo_abstinencia ?? 'N/A' }} meses</p>

        <p><strong>Alcohol:</strong> {{ ucfirst($consumo->alcohol_estado) }}</p>
        <p><strong>Tiempo consumo:</strong> {{ $consumo->alcohol_tiempo_consumo ?? 'N/A' }} meses</p>
        <p><strong>Tiempo abstinencia:</strong> {{ $consumo->alcohol_tiempo_abstinencia ?? 'N/A' }} meses</p>

        <p><strong>Otras Sustancias:</strong> {{ ucfirst($consumo->otras_sustancias_estado) }}</p>
        <p><strong>¿Cuál?</strong> {{ $consumo->otras_sustancias_cual ?? 'Ninguna' }}</p>
        <p><strong>Tiempo consumo:</strong> {{ $consumo->otras_sustancias_tiempo_consumo ?? 'N/A' }} meses</p>
        <p><strong>Tiempo abstinencia:</strong> {{ $consumo->otras_sustancias_tiempo_abstinencia ?? 'N/A' }} meses</p>
    </div>
</div>

{{-- Card Actividad Física --}}
<div class="card shadow-sm mb-3">
    <div class="card-header bg-success text-white">
        <i class="fas fa-dumbbell"></i> Actividad Física
    </div>
    <div class="card-body">
        @if($consumo->actividades->count())
            <ul>
                @foreach($consumo->actividades as $actividad)
                    <li>
                        <strong>{{ $actividad->actividad_fisica_cual }}</strong> - {{ $actividad->actividad_fisica_tiempo ?? 'N/A' }} min, Frecuencia: {{ $actividad->actividad_fisica_frecuencia ?? 'N/A' }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No hay actividades físicas registradas.</p>
        @endif
    </div>
</div>

{{-- Card Medicación Habitual --}}
<div class="card shadow-sm mb-3">
    <div class="card-header bg-info text-white">
        <i class="fas fa-pills"></i> Medicación Habitual
    </div>
    <div class="card-body">
        @if($consumo->medicaciones->count())
            <ul>
                @foreach($consumo->medicaciones as $med)
                    <li>
                        <strong>{{ $med->medicacion_habitual_cual }}</strong> - Cantidad: {{ $med->medicacion_habitual_cantidad ?? 'N/A' }} - Toma: {{ $med->toma_medicacion_habitual ? 'Sí' : 'No' }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No hay medicaciones registradas.</p>
        @endif
    </div>
</div>

{{-- Observaciones --}}
<div class="card shadow-sm mb-3">
    <div class="card-header bg-secondary text-white">
        <i class="fas fa-sticky-note"></i> Observaciones
    </div>
    <div class="card-body">
        <p>{{ $consumo->observaciones ?? 'Ninguna' }}</p>
    </div>
</div>

@stop