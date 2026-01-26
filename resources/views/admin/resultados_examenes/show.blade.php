@extends('adminlte::page')

@section('title', 'Detalle de Resultado de Examen')

@section('content_header')
    <h1>Resultado de Examen</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-info text-white">
            Detalle del Examen
        </div>
        <div class="card-body">
            <p><strong>Nombre del Examen:</strong> {{ $resultadoExamen->nombre_examen }}</p>
            <p><strong>Fecha del Examen:</strong> {{ $resultadoExamen->fecha_examen->format('d-m-Y') }}</p>
            <p><strong>Resultados:</strong> {{ $resultadoExamen->resultados ?? 'Sin resultados' }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-secondary">Volver al registro</a>
            <a href="{{ route('admin.resultados_examenes.edit', [$registro, $resultadoExamen]) }}" class="btn btn-primary">Editar</a>
            <form action="{{ route('admin.resultados_examenes.destroy', [$registro, $resultadoExamen]) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('¿Está seguro que desea eliminar este resultado?')">Eliminar</button>
            </form>
        </div>
    </div>
@endsection