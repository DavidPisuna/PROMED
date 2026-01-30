@extends('adminlte::page')

@section('title', 'Perfil del Paciente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center px-3 mt-3">
    <div>
        <h1 class="text-dark font-weight-bold" style="letter-spacing: -1px;">
            <i class="fas fa-user-circle text-pastel-purple-dark mr-2"></i>Perfil del Paciente
        </h1>
        <p class="text-muted">Gestión y visualización detallada de datos clínicos.</p>
    </div>
    <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Regresar
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Columna Izquierda: Perfil Rápido --}}
        <div class="col-md-4">
            <div class="card card-pastel border-0 shadow-sm mb-4">
                <div class="card-body text-center pt-5">
                    <div class="avatar-container mb-3">
                        @if($paciente->sexo == 'F')
                            <div class="avatar-circle bg-pastel-pink-soft">
                                <i class="fas fa-female fa-4x text-pastel-pink-dark"></i>
                            </div>
                        @elseif($paciente->sexo == 'M')
                            <div class="avatar-circle bg-pastel-blue-soft">
                                <i class="fas fa-male fa-4x text-pastel-blue-dark"></i>
                            </div>
                        @else
                            <div class="avatar-circle bg-pastel-purple-soft">
                                <i class="fas fa-user fa-4x text-pastel-purple-dark"></i>
                            </div>
                        @endif
                        <span class="status-indicator {{ $paciente->activo ? 'bg-success' : 'bg-danger' }}" 
                              title="{{ $paciente->activo ? 'Activo' : 'Inactivo' }}"></span>
                    </div>

                    <h3 class="font-weight-bold mb-1">{{ $paciente->nombre_completo }}</h3>
                    <p class="text-muted mb-3">{{ $paciente->codigo_empleado }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge badge-pastel-purple px-3 py-2">ID: #{{ $paciente->id }}</span>
                        @if($paciente->grupo_sanguineo)
                            <span class="badge badge-pastel-red px-3 py-2">{{ $paciente->grupo_sanguineo }}</span>
                        @endif
                    </div>

                    <hr class="my-4">

                    <div class="action-buttons px-3">
                        <a href="{{ route('admin.pacientes.edit', $paciente) }}" class="btn btn-pastel-warning w-100 mb-2">
                            <i class="fas fa-edit mr-2"></i> Editar Perfil
                        </a>
                        
                        <form action="{{ route('admin.pacientes.toggleActivo', $paciente) }}" method="POST" id="toggle-form">
                            @csrf
                            @method('PUT') {{-- Cambiado a PUT según tu ruta anterior --}}
                            <button type="submit" class="btn {{ $paciente->activo ? 'btn-pastel-danger-soft' : 'btn-pastel-success' }} w-100" onclick="return confirmToggle(event)">
                                <i class="fas fa-power-off mr-2"></i>
                                {{ $paciente->activo ? 'Desactivar Paciente' : 'Activar Paciente' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Card de Auditoría --}}
            <div class="card card-pastel border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-clock text-muted mr-2"></i>
                        <small class="text-muted uppercase font-weight-bold">Registro del Sistema</small>
                    </div>
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Creado:</span>
                            <span class="text-dark">{{ $paciente->created_at->format('d M, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Último cambio:</span>
                            <span class="text-dark">{{ $paciente->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Información Detallada --}}
        <div class="col-md-8">
            <div class="card card-pastel border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-info-tab" data-toggle="pill" href="#pills-info" role="tab">
                                <i class="fas fa-file-alt mr-2"></i>Datos Generales
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-medical-tab" data-toggle="pill" href="#pills-medical" role="tab">
                                <i class="fas fa-heartbeat mr-2"></i>Información Médica
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-4">
                    <div class="tab-content">
                        {{-- Tab: Información General --}}
                        <div class="tab-pane fade show active" id="pills-info">
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <label class="text-muted small mb-1">Cédula de Identidad</label>
                                    <div class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</div>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label class="text-muted small mb-1">Sucursal Asignada</label>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape-sm bg-pastel-blue-soft mr-2">
                                            <i class="fas fa-building text-pastel-blue-dark"></i>
                                        </div>
                                        <div class="h6 font-weight-bold mb-0">
                                            {{ $paciente->sucursal->nombre ?? 'Sin asignar' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label class="text-muted small mb-1">Fecha de Nacimiento</label>
                                    <div class="h6 font-weight-bold">
                                        {{ $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d / m / Y') : 'No registrada' }}
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label class="text-muted small mb-1">Edad Actual</label>
                                    <div class="h6">
                                        @if($paciente->fecha_nacimiento)
                                            <span class="badge badge-pastel-purple-dark text-white px-3">
                                                {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} Años
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab: Información Médica --}}
                        <div class="tab-pane fade" id="pills-medical">
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <label class="text-muted small mb-1">Lateralidad</label>
                                    <div class="d-flex align-items-center h6 font-weight-bold">
                                        <i class="fas fa-hand-paper mr-2 text-pastel-orange"></i>
                                        {{ $paciente->lateralidad ?? 'No especificado' }}
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label class="text-muted small mb-1">Género Biológico</label>
                                    <div class="h6 font-weight-bold">
                                        @if($paciente->sexo == 'M') Masculino @elseif($paciente->sexo == 'F') Femenino @else Otro @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-pastel-info-soft border-0">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Para ver el historial clínico completo de este paciente, diríjase al módulo de <strong>Consultas</strong>.
                                    </div>
                                </div>
                            </div>
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
        --purple-dark: #6f42c1;
        --purple-light: #f3e5f5;
        --blue-soft: #e3f2fd;
        --blue-dark: #0d6efd;
        --pink-soft: #fce4ec;
        --pink-dark: #d81b60;
        --orange-pastel: #fff3e0;
    }

    .card-pastel { border-radius: 20px; }
    
    /* Avatar Styles */
    .avatar-container { position: relative; display: inline-block; }
    .avatar-circle {
        width: 120px; height: 120px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .status-indicator {
        position: absolute; bottom: 5px; right: 5px;
        width: 25px; height: 25px;
        border-radius: 50%; border: 4px solid #fff;
    }

    /* Colors */
    .bg-pastel-pink-soft { background-color: var(--pink-soft); }
    .text-pastel-pink-dark { color: var(--pink-dark); }
    .bg-pastel-blue-soft { background-color: var(--blue-soft); }
    .text-pastel-blue-dark { color: var(--blue-dark); }
    .bg-pastel-purple-soft { background-color: var(--purple-light); }
    .text-pastel-purple-dark { color: var(--purple-dark); }
    .badge-pastel-purple-dark { background-color: var(--purple-dark); }
    .alert-pastel-info-soft { background-color: var(--blue-soft); color: #055160; border-radius: 12px; }

    /* Custom Pills */
    .custom-pills .nav-link {
        border-radius: 10px; color: #6c757d;
        padding: 10px 20px; font-weight: 600;
        transition: all 0.3s; margin-right: 10px;
    }
    .custom-pills .nav-link.active {
        background-color: var(--purple-light) !important;
        color: var(--purple-dark) !important;
    }

    /* Buttons */
    .btn-pastel-gray { background: #f8f9fa; color: #333; border: 1px solid #ddd; border-radius: 12px; }
    .btn-pastel-warning { background: #fff3e0; color: #e65100; border: none; border-radius: 12px; font-weight: bold; }
    .btn-pastel-success { background: #e8f5e9; color: #2e7d32; border: none; border-radius: 12px; font-weight: bold; }
    .btn-pastel-danger-soft { background: #ffebee; color: #c62828; border: none; border-radius: 12px; font-weight: bold; }

    .icon-shape-sm {
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmToggle(e) {
        e.preventDefault();
        const form = document.getElementById('toggle-form');
        const esActivo = {{ $paciente->activo ? 'true' : 'false' }};
        
        Swal.fire({
            title: esActivo ? '¿Desactivar Paciente?' : '¿Activar Paciente?',
            text: "El estado de visibilidad del paciente cambiará.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: esActivo ? '#d33' : '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@stop