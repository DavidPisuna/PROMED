@extends('adminlte::page')

@section('title', 'Inmunizaciones')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-primary">
        <i class="fas fa-syringe mr-2"></i> Inmunizaciones
    </h1>

    @isset($paciente)
        <a href="{{ route('admin.inmunizaciones.createFromPaciente', $paciente) }}"
           class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Nueva Inmunización
        </a>
    @endisset
</div>
@endsection

@section('content')

{{-- ALERTAS --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
    </div>
@endif

{{-- INFO DEL PACIENTE --}}
@isset($paciente)
<div class="card card-outline card-info mb-3">
    <div class="card-body">
        <strong>Paciente:</strong>
        {{ $paciente->primer_apellido }}
        {{ $paciente->segundo_apellido }}
        {{ $paciente->primer_nombre }}
        {{ $paciente->segundo_nombre }}
        |
        <strong>Cédula:</strong> {{ $paciente->cedula_identidad }}
    </div>
</div>
@endisset

{{-- TABLA --}}
<div class="card card-outline card-primary">
    <div class="card-body table-responsive">
        <table class="table table-hover table-striped">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Paciente</th>
                    <th>Vacuna</th>
                    <th>Dosis</th>
                    <th>Fecha Aplicación</th>
                    <th>Doctor</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inmunizaciones as $inmunizacion)
                <tr>
                    <td>{{ $inmunizacion->id }}</td>

                    <td>
                        {{ $inmunizacion->paciente->primer_apellido }}
                        {{ $inmunizacion->paciente->primer_nombre }}
                    </td>

                    <td>{{ $inmunizacion->nombre_vacuna }}</td>

                    <td>{{ $inmunizacion->dosis }}</td>

                    <td>
                        {{ $inmunizacion->fecha_aplicacion
                            ? $inmunizacion->fecha_aplicacion->format('d/m/Y')
                            : '—' }}
                    </td>

                    <td>{{ $inmunizacion->doctor->nombre ?? '—' }}</td>

                    <td class="text-center">
                        <a href="{{ route('admin.inmunizaciones.show', $inmunizacion) }}"
                           class="btn btn-info btn-sm"
                           title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.inmunizaciones.edit', $inmunizacion) }}"
                           class="btn btn-warning btn-sm"
                           title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="{{ route('admin.inmunizaciones.pdf', $inmunizacion) }}"
                           class="btn btn-secondary btn-sm"
                           title="PDF"
                           target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                        <form action="{{ route('admin.inmunizaciones.destroy', $inmunizacion) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Desea eliminar esta inmunización?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        <i class="fas fa-info-circle"></i> No existen registros de inmunización
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="card-footer clearfix">
        {{ $inmunizaciones->links() }}
    </div>
</div>

@endsection
