@extends('adminlte::page')

@section('title', 'Detalle del Puesto de Trabajo')

@section('content_header')
<h1 class="m-0 text-dark">Detalle del Puesto: {{ $puesto->nombre_puesto }}</h1>
@stop

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-briefcase"></i> {{ $puesto->nombre_puesto }}
        </div>
        <a href="{{ route('admin.puestos.edit', [$registro, $puesto]) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>

    <div class="card-body">
        @if($puesto->actividades->count())
            @foreach($puesto->actividades as $actividad)
                <div class="mb-4 p-3 border rounded shadow-sm">
                    <h5 class="text-primary">{{ $actividad->nombre_actividad }}</h5>

                    @if($actividad->factoresRiesgo->count())
                        <div class="row mt-2">
                            @foreach($actividad->factoresRiesgo->groupBy('categoria') as $categoria => $factores)
                                <div class="col-md-4 mb-2">
                                    <div class="card border-{{ $loop->index % 2 == 0 ? 'primary' : 'secondary' }}">
                                        <div class="card-header bg-light">
                                            <i class="fas fa-{{ getIconoCategoria($categoria) }} text-{{ getColorCategoria($categoria) }}"></i>
                                            {{ ucfirst($categoria) }}
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($factores as $factor)
                                                    <span class="badge bg-{{ getColorCategoria($categoria) }} text-white px-2 py-1" style="font-size: 0.85em;">
                                                        {{ $factor->factor_riesgo }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mt-2">No hay factores de riesgo registrados.</p>
                    @endif
                </div>
                @if(!$loop->last)
                    <hr>
                @endif
            @endforeach
        @else
            <div class="text-center py-4">
                <i class="fas fa-briefcase fa-2x text-muted mb-3"></i>
                <p class="text-muted">No hay actividades registradas para este puesto.</p>
            </div>
        @endif

        {{-- Botón para regresar al registro --}}
        <div class="text-end mt-3">
            <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar al Registro
            </a>
        </div>
    </div>
</div>
@stop