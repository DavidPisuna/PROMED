@extends('adminlte::page')

@section('title', 'Detalle Antecedente Reproductivo Masculino')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-primary"><i class="fas fa-male"></i> Antecedente Reproductivo Masculino</h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-danger text-white">
        <i class="fas fa-male"></i> Antecedente Reproductivo Masculino
    </div>
    <div class="card-body">
        @if($registro->antecedenteMasculino)
            <p><strong>Método de Planificación Familiar:</strong>
                @if($registro->antecedenteMasculino->planificacion_si) Sí ({{ $registro->antecedenteMasculino->planificacion_cual ?? 'Ninguno' }})
                @elseif($registro->antecedenteMasculino->planificacion_no) No
                @elseif($registro->antecedenteMasculino->planificacion_no_responde) No responde
                @else N/A
                @endif
            </p>

            {{-- Exámenes Masculinos --}}
            @if($registro->antecedenteMasculino->examenes->count())
                <hr>
                <h6><i class="fas fa-vials"></i> Exámenes Realizados</h6>
                <ul>
                    @foreach($registro->antecedenteMasculino->examenes as $examen)
                        <li>
                            <strong>{{ $examen->examen_realizado }}</strong> - Tiempo: {{ $examen->tiempo_meses ?? 'N/A' }} meses, Resultado: {{ $examen->resultado ?? 'N/A' }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No hay exámenes registrados.</p>
            @endif
        @else
            <p class="text-muted">No hay antecedentes reproductivos masculinos registrados.</p>
        @endif
    </div>
    <div class="card-footer text-end">
        @if($registro->antecedenteMasculino)
            <a href="{{ route('admin.antecedentes_masculinos.edit', $registro->antecedenteMasculino) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar Antecedente
            </a>
        @else
            <a href="{{ route('admin.antecedentes_masculinos.create', $registro) }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Crear Antecedente
            </a>
        @endif
    </div>
</div>
@stop