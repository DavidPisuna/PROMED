@extends('adminlte::page')

@section('title', 'Detalle de Nota')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-blue font-weight-bold">
        <i class="fas fa-file-alt mr-2"></i>Detalle de Nota de Evolución
    </h1>
    <div class="d-flex" style="gap: 10px;">
        <a href="{{ route('admin.notas.byPaciente', $nota->paciente) }}"
           class="btn btn-pastel-gray shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
        <a href="{{ route('admin.notas.edit', $nota) }}"
           class="btn btn-pastel-warning shadow-sm">
            <i class="fas fa-edit mr-1"></i> Editar Nota
        </a>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-5">

    <div class="row">
        {{-- COLUMNA IZQUIERDA: DATOS PACIENTE Y MÉDICO --}}
        <div class="col-md-4">
            <div class="card card-pastel shadow-sm mb-4">
                <div class="card-header bg-pastel-blue py-2">
                    <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-md mr-2"></i>Información General</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Paciente</label>
                        <p class="h6 font-weight-bold text-dark mb-0 text-uppercase">
                            {{ $nota->paciente->primer_apellido }} {{ $nota->paciente->segundo_apellido }}<br>
                            {{ $nota->paciente->primer_nombre }} {{ $nota->paciente->segundo_nombre }}
                        </p>
                        <small class="text-muted">ID: {{ $nota->paciente->cedula_identidad }}</small>
                    </div>

                    <div class="mb-4 border-top pt-3">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Médico Tratante</label>
                        <p class="h6 font-weight-bold text-primary mb-0">
                            DR(A). {{ strtoupper($nota->doctor->primer_nombre) }} {{ strtoupper($nota->doctor->primer_apellido) }}
                        </p>
                    </div>

                    <div class="mb-4 border-top pt-3">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Empresa Relacionada</label>
                        <p class="h6 mb-0">{{ strtoupper($nota->empresa->nombre) }}</p>
                    </div>

                    <div class="border-top pt-3">
                        <div class="row">
                            <div class="col-6 border-right">
                                <label class="text-muted small text-uppercase font-weight-bold d-block">Fecha</label>
                                <p class="h6 mb-0 font-weight-bold">{{ \Carbon\Carbon::parse($nota->fecha)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-6 pl-3">
                                <label class="text-muted small text-uppercase font-weight-bold d-block">Hora</label>
                                <p class="h6 mb-0 font-weight-bold">{{ \Carbon\Carbon::parse($nota->hora)->format('H:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: CUERPO DE LA NOTA --}}
        <div class="col-md-8">
            <div class="card card-pastel shadow-lg overflow-hidden border-0" style="border-radius: 20px;">
                <div class="card-body p-0">
                    {{-- Encabezado decorativo tipo hoja clínica --}}
                    <div class="bg-light px-4 py-3 border-bottom d-flex align-items-center">
                        <div class="bg-pastel-blue rounded-circle p-2 mr-3">
                            <i class="fas fa-notes-medical text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">REGISTRO DE EVOLUCIÓN CLÍNICA</h5>
                            <small class="text-muted text-uppercase">Folio Interno: #{{ str_pad($nota->id, 5, '0', STR_PAD_LEFT) }}</small>
                        </div>
                    </div>

                    <div class="p-4 bg-white" style="min-height: 400px; line-height: 1.8;">
                        {{-- SECCIÓN PROBLEMAS --}}
                        <div class="mb-4">
                            <h6 class="text-pastel-blue font-weight-bold border-bottom pb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>PROBLEMAS IDENTIFICADOS
                            </h6>
                            <div class="p-3 bg-light-soft rounded border-left border-info" style="border-left-width: 4px !important;">
                                <p class="mb-0 text-dark font-weight-bold">
                                    {{ $nota->problemas ?: 'NO SE REGISTRARON PROBLEMAS ESPECÍFICOS' }}
                                </p>
                            </div>
                        </div>

                        {{-- SECCIÓN EVOLUCIÓN --}}
                        <div class="mb-2">
                            <h6 class="text-pastel-blue font-weight-bold border-bottom pb-2">
                                <i class="fas fa-clipboard-check mr-2"></i>DESARROLLO DE LA EVOLUCIÓN
                            </h6>
                            <div class="p-2" style="white-space: pre-wrap; font-size: 1.1rem; color: #2c3e50;">{{ $nota->evolucion }}</div>
                        </div>
                    </div>

                    {{-- FIRMA DIGITAL SIMULADA --}}
                    <div class="card-footer bg-light p-4 text-center">
                        <div class="d-inline-block border-top px-5 pt-2 mt-3" style="border-top: 1.5px solid #ccc !important;">
                            <p class="mb-0 font-weight-bold">DR(A). {{ strtoupper($nota->doctor->primer_nombre) }} {{ strtoupper($nota->doctor->primer_apellido) }}</p>
                            <small class="text-muted d-block text-uppercase">Médico Responsable</small>
                            <small class="text-muted" style="font-size: 0.7rem;">Documento generado electrónicamente el {{ now()->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root { 
        --pastel-blue: #A8D8EA; 
        --pastel-gray: #E3E3E3; 
        --pastel-warning: #FFECB3;
    }
    
    .card-pastel { border: none; border-radius: 15px; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .text-pastel-blue { color: #5fa8c3 !important; }
    .bg-light-soft { background-color: #f8f9fa; }

    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    .btn-pastel-warning { background: var(--pastel-warning); border: none; border-radius: 8px; font-weight: bold; color: #856404; }
    
    /* Efecto de sombra suave */
    .shadow-lg { box-shadow: 0 1rem 3rem rgba(0,0,0,.08)!important; }

    /* Estilo de lectura */
    p { color: #444; }
</style>
@stop