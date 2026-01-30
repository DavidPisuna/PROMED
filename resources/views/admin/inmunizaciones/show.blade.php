@extends('adminlte::page')

@section('title', 'Detalle de Inmunización')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-file-medical-alt mr-2"></i>Detalle de Registro #{{ $inmunizacion->id }}
    </h1>
    <div>
        <a href="{{ route('admin.inmunizaciones.pdf', $inmunizacion) }}" target="_blank" class="btn btn-danger shadow-sm">
            <i class="fas fa-file-pdf mr-1"></i> Exportar PDF
        </a>
        {{-- CAMBIO AQUÍ: Usamos $inmunizacion->paciente_id o la relación --}}
        <a href="{{ route('admin.inmunizaciones.byPaciente', $inmunizacion->paciente_id) }}" class="btn btn-pastel-gray shadow-sm ml-2">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    
    {{-- 🔹 INFO DEL PACIENTE (Usando la relación $inmunizacion->paciente) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Información del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark text-uppercase">
                        {{ $inmunizacion->paciente->primer_nombre }} {{ $inmunizacion->paciente->segundo_nombre }} 
                        {{ $inmunizacion->paciente->primer_apellido }} {{ $inmunizacion->paciente->segundo_apellido }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $inmunizacion->paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-5">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Empresa Solicitante</small>
                    <span class="text-dark font-weight-bold text-uppercase">
                        {{ $inmunizacion->empresa->nombre ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- EL RESTO DEL CÓDIGO (TABLA DE VACUNAS) SIGUE IGUAL --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card card-pastel shadow-sm h-100">
                <div class="card-header bg-pastel-purple py-2">
                    <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-md mr-2"></i>Responsable</h6>
                </div>
                <div class="card-body">
                    <label class="small font-weight-bold text-muted mb-1">MÉDICO EVALUADOR</label>
                    <p class="text-dark font-weight-bold text-uppercase border-bottom pb-2">
                        DR(A). {{ $inmunizacion->doctor->primer_nombre }} {{ $inmunizacion->doctor->primer_apellido }}
                    </p>
                    <label class="small font-weight-bold text-muted mb-1 mt-2">FECHA DE REGISTRO</label>
                    <p class="text-muted">{{ $inmunizacion->created_at->format('d/m/Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-pastel shadow-lg h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                        <i class="fas fa-syringes mr-2"></i>Vacunas Registradas
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="small text-muted text-uppercase">
                                    <th class="pl-4">Vacuna</th>
                                    <th>Dosis</th>
                                    <th>Lote</th>
                                    <th>Fecha</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inmunizacion->detalles as $detalle)
                                <tr>
                                    <td class="pl-4 align-middle">
                                        <div class="font-weight-bold text-dark text-uppercase">{{ $detalle->vacuna }}</div>
                                        <small class="text-muted text-uppercase">Centro: {{ $detalle->establecimiento_salud ?? 'N/R' }}</small>
                                    </td>
                                    <td class="align-middle text-uppercase font-weight-bold text-muted">
                                        {{ $detalle->dosis }}
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-light border text-uppercase">{{ $detalle->lote ?? 'S/L' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($detalle->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($detalle->esquema_completo)
                                            <span class="badge badge-success px-3 py-2 shadow-sm text-white">
                                                <i class="fas fa-check-circle mr-1"></i> COMPLETO
                                            </span>
                                        @else
                                            <span class="badge badge-light border px-3 py-2 text-muted">
                                                INCOMPLETO
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No hay vacunas registradas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root { --pastel-blue: #A8D8EA; --pastel-purple: #CAB8FF; --pastel-gray: #E3E3E3; }
    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-purple { color: #9b86d6 !important; }
    .btn-pastel-gray { background-color: var(--pastel-gray); border: none; border-radius: 8px; font-weight: 600; color: #666; }
    .badge-success { background-color: #b6e2d3 !important; color: #2d5a4c !important; }
</style>
@stop